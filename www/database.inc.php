<?php
/*
 * Class Database: interface to the movie database FROM PHP.
 *
 * You must:
 *
 * 1) Change the function userExists so the SQL query is appropriate for your tables.
 * 2) Write more functions.
 *
 */
class Database {
	private $host;
	private $userName;
	private $password;
	private $database;
	private $conn;

	/**
	 * Constructs a database object for the specified user.
	 */
	public function __construct($host, $userName, $password, $database) {
		$this->host = $host;
		$this->userName = $userName;
		$this->password = $password;
		$this->database = $database;
	}

	/**
	 * Opens a connection to the database, using the earlier specified user
	 * name and password.
	 *
	 * @return true if the connection succeeded, false if the connection
	 * couldn't be opened or the supplied user name and password were not
	 * recognized.
	 */
	public function openConnection() {
		try {
			$this->conn = new PDO("mysql:host=$this->host;dbname=$this->database",
					$this->userName,  $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$error = "Connection error: " . $e->getMessage();
			print $error . "<p>";
			unset($this->conn);
			return false;
		}
		return true;
	}

	/**
	 * Closes the connection to the database.
	 */
	public function closeConnection() {
		$this->conn = null;
		unset($this->conn);
	}

	/**
	 * Checks if the connection to the database has been established.
	 *
	 * @return true if the connection has been established
	 */
	public function isConnected() {
		return isset($this->conn);
	}

	/**
	 * Execute a database query (SELECT).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The result set
	 */
	private function executeQuery($query, $param = null) {
		try {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
			$result = $stmt->fetchAll();
		} catch (PDOException $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $result;
	}

	/**
	 * Execute a database update (insert/delete/update).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters
	 * @return The number of affected rows
	 */
	private function executeUpdate($query, $param = null) {
		// ...
		try {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
			$result = $stmt->rowCount();

		} catch (Exception $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);

		}
		return $result;
	}

	/**
	* returns YYYY-MM-DD HH:MM:SS FROM YYYY-MM-DDTHH:MM:SS.msmsms
	*/
	private function convertDateTime($dateTimeFromHTML){
		$ret = substr($dateTimeFromHTML,0,10)." ".substr($dateTimeFromHTML,11,8);
		return $ret;
	}

	private function getAllPalletInfoQuery(){
		$sql = "SELECT * FROM (SELECT Pallets.palletId palletId, productionDateTime, state, blocked, productName, orderId, deliveryDateTime, desiredDeliveryDate, customerName FROM Pallets LEFT OUTER JOIN (SELECT * FROM PalletDeliveries NATURAL JOIN Orders) InnerQ ON Pallets.palletId=InnerQ.palletId) OuterQ ";
		return $sql;
	}

	public function getIngredients(){
		$sql = "SELECT rawMaterialName FROM RawMaterials";
		$result = $this->executeQuery($sql);
		$ret;
		$i = 0;
		foreach($result as $ingredient){
			$ret[$i] = $ingredient['rawMaterialName'];
			$i++;
		}
		return $ret;
	}

	public function producePallets($productName, $amount) {
		$sql = "SELECT ingredientName, quantity FROM Ingredients  WHERE productName = ?";
		$result = $this->executeQuery($sql, array($productName));

		$updateQuery = "UPDATE RawMaterials SET totalQuantity = totalQuantity - ?  WHERE rawMaterialName = ?";
		$insertQuery = "INSERT INTO Pallets(productName) VALUES (?)";
		$this->conn->beginTransaction();
		foreach ($result as $ingr) {
			$totAmount = 54 * $ingr['quantity'] * $amount;
			$this->executeUpdate($updateQuery, array($totAmount, $ingr['ingredientName']));
		}
		for ($i = 0; $i < $amount; $i = $i + 1) {
			$this->executeUpdate($insertQuery, array($productName));
		}
		$this->conn->commit();
	}

	public function getProducts(){
		$sql = "SELECT productName FROM Products";
		$result = $this->executeQuery($sql);
		$ret;
		$i = 0;
		foreach($result as $product){
			$ret[$i] = $product['productName'];
			$i++;
		}
		return $ret;
	}

	//TODO REMOVE
	public function getPallets() {
		$sql = "SELECT palletId, productionDateTime AS prodDate, state, blocked, productName FROM Pallets";
		return $this->executeQuery($sql);
	}

	public function blockPallets($product, $intervalStart, $intervalEnd) {
		$intervalStart = $this->convertDateTime($intervalStart);
		$intervalEnd = $this->convertDateTime($intervalEnd);
		$sql = "UPDATE Pallets SET blocked = true  WHERE productName = ?
		AND productionDateTime >= ? AND productionDateTime <= ? AND state = 'freezer'";
		return $this->executeUpdate($sql, array($product, $intervalStart, $intervalEnd));
	}

	public function freezerExitScanner($palletId){
		$sql = "UPDATE Pallets SET state = 'delivered' WHERE palletId = ?";
		return $this->executeUpdate($sql, array($palletId));
	}

	public function getPalletInfo($palletId){
		$sql = $this->getAllPalletInfoQuery();
		$sql = $sql."WHERE palletId= ?";
		return $this->executeQuery($sql, array($palletId));
	}

	public function getPalletsWithProduct($productName){
		$sql = $this->getAllPalletInfoQuery();
		$sql = $sql."WHERE productName = ? ORDER BY productionDateTime,deliveryDateTime";
		return $this->executeQuery($sql, array($productName));
	}

	public function getCustomers(){
		$sql = "SELECT customerName FROM Customers";
		return $this->executeQuery($sql);
	}

	public function getPalletsToCustomer($customerName) {
		$sql = $this->getAllPalletInfoQuery();
		$sql = $sql."WHERE customerName = ? ORDER BY deliveryDateTime";
		return $this->executeQuery($sql, array($customerName));
	}

	//TODO Check somewhere that the pallet actually exsits!
	//Något är fel i den sista parentesen, det som returneras där är ju flera värden... Det man söker är ju för varje specifik order
	//om alla pallar har levererats

	//LÖSNING: Skapa en view med för varje orderId hur många pallar av den här produkten som har levererats

	/**
	* Creates a lot of views right now but that's just to be able to do all the joins correctly
	*/

	public function getOrdersWithProduct($palletId){
		$sql = "SELECT productName FROM Pallets WHERE palletId = ?
		AND blocked is false AND state = 'freezer'";
		$productName = $this->executeQuery($sql, array($palletId));
		$productName = $productName[0]['productName'];

		$sql = "CREATE OR REPLACE view PalletsDeliveredToOrderId AS SELECT orderId,
		 count(*) nbrDelivered FROM PalletDeliveries NATURAL JOIN Pallets
		WHERE productName = ? GROUP BY orderId";
		$this->executeUpdate($sql, array($productName));

		$sql = "CREATE OR REPLACE view Deliveries AS SELECT * FROM Orders
		NATURAL JOIN ProductOrders WHERE productName = ?";
		$this->executeUpdate($sql, array($productName));

		$sql = "CREATE OR REPLACE view NbrOfDeliveries
		AS SELECT Deliveries.orderId, desiredDeliveryDate, customerName,
		productName, nbrOfPallets, nbrDelivered
		FROM Deliveries LEFT OUTER JOIN PalletsDeliveredToOrderId
		ON PalletsDeliveredToOrderId.orderId=Deliveries.orderId";
		$this->executeUpdate($sql);

		$sql = "SELECT orderId FROM NbrOfDeliveries
		WHERE nbrOfPallets > nbrDelivered OR nbrDelivered is NULL";
		return $this->executeQuery($sql, array($productName));

	}

	public function deliverPallet($palletId, $orderId){
		$sql = "INSERT INTO PalletDeliveries VALUES(?, ?, NOW())";
		$this->executeUpdate($sql, array($palletId, $orderId));
		$sql = "UPDATE Pallets SET state = 'delivered' WHERE palletId = ?";
		$this->executeUpdate($sql, array($palletId));
	}

	public function getPalletsByProductionDateTime($intervalStart, $intervalEnd){
		$intervalStart = $this->convertDateTime($intervalStart);
		$intervalEnd = $this->convertDateTime($intervalEnd);
		$sql = $this->getAllPalletInfoQuery();
		$sql = $sql."WHERE productionDateTime >= ? AND productionDateTime <= ? ORDER BY productionDateTime";
		return $this->executeQuery($sql, array($intervalStart,$intervalEnd));

	}
	public function getPalletsByDeliveryDateTime($intervalStart, $intervalEnd){
		$intervalStart = $this->convertDateTime($intervalStart);
		$intervalEnd = $this->convertDateTime($intervalEnd);
		$sql = $this->getAllPalletInfoQuery();
		$sql = $sql."WHERE deliveryDateTime >= ? AND deliveryDateTime <= ? ORDER BY deliveryDateTime";
		return $this->executeQuery($sql, array($intervalStart,$intervalEnd));
	}

	public function getBlockedPallets(){
		$sql = $this->getAllPalletInfoQuery();
		$sql = $sql."WHERE blocked is true ORDER BY productionDateTime";
		return $this->executeQuery($sql);
	}

	public function printHTMLCodeForTable($input){
		print("<table style=\"width:100%\">
	  <tr>
		<td><b>palletId</b></td>
		<td><b>productionDateTime</b></td>
		<td><b>state</b></td>
		<td><b>blocked</b></td>
		<td><b>productName</b></td>
		<td><b>orderId</b></td>
		<td><b>deliveryDateTime</b></td>
		<td><b>desiredDeliveryDate</b></td>
		<td><b>customerName</b></td>
		</tr>");

			foreach($input as $row){
				print "<tr>";
				print "<td> ".$row['palletId']."</td>";
				print "<td> ".$row['productionDateTime']."</td>";
				print "<td> ".$row['state']."</td>";
				print "<td> ";
				if($row['blocked'] == 1){
					print("yes");
				}
				else{
					print("no");
				}
				print "</td>";
				print "<td> ".$row['productName']."</td>";
				print "<td> ".$row['orderId']."</td>";
				print "<td> ".$row['deliveryDateTime']."</td>";
				print "<td> ".$row['desiredDeliveryDate']."</td>";
				print "<td> ".$row['customerName']."</td>";
				print "</tr>";
			}
	print("</table>");
	}
}

?>
