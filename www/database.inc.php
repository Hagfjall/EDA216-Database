<?php
/*
 * Class Database: interface to the movie database from PHP.
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
	 * Execute a database query (select).
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
	* returns YYYY-MM-DD HH:MM:SS from YYYY-MM-DDTHH:MM:SS.msmsms
	*/
	private function getDateTime($dateTimeFromHTML){
		$ret = substr($dateTimeFromHTML,0,10)." ".substr($dateTimeFromHTML,11,8);
		return $ret;
	}

	/**
	 * Check if a user with the specified user id exists in the database.
	 * Queries the Users database table.
	 *
	 * @param userId The user id
	 * @return true if the user exists, false otherwise.
	 */
	public function userExists($userId) {
		$sql = "select userId from Users where userId = ?";
		$result = $this->executeQuery($sql, array($userId));
		return count($result) == 1;
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


	public function producePallets($cookieType, $amount) {
		$sql = "SELECT ingredientName AS name, quantity FROM Ingredients WHERE productName = ?";
		$result = $this->executeQuery($sql, array($cookieType));

		$updateQuery = "UPDATE RawMaterials SET totalQuantity = totalQuantity - ? WHERE rawMaterialName = ?";
		$insertQuery = "INSERT INTO Pallets VALUES (null, default, 'freezer', false, ?)";
		$this->conn->beginTransaction();
		foreach ($result as $ingr) {
			$totAmount = 54 * $ingr['quantity'] * $amount; //FÖRTYDLIGA SENARE
			$this->executeUpdate($updateQuery, array($totAmount, $ingr['name']));
		}
		for ($i = 0; $i < $amount; $i = $i + 1) {
			$this->executeUpdate($insertQuery, array($cookieType));
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

	public function getPallets() {
		$sql = "SELECT palletId, productionDateTime AS prodDate, state, blocked, productName FROM Pallets";
		$result = $this->executeQuery($sql);
		return $result;
	}

//2015-01-01T11:42:13.510
	public function blockPallets($product, $intervalStart, $intervalEnd) {
		$intervalStart = $this->getDateTime($intervalStart);
		$intervalEnd = $this->getDateTime($intervalEnd);
		$sql = "UPDATE Pallets SET blocked = true WHERE productName = ? AND productionDateTime >= ? AND productionDateTime <= ?";
		$result = $this->executeUpdate($sql, array($product, $intervalStart, $intervalEnd));
		return $result;
	}


		public function freezerExitScanner($palletId){

	}

	public function getPalletInfo($palletId){
		$sql = "select * from Pallets where palletId = ?";
		$result = $this->executeQuery($sql, array($palletId));
		return $result;
	}

	public function getPalletsWithProduct($productName){
		$sql = "select * from Pallets where productName = ?";
		$result = $this->executeQuery($sql, array($productName));
		return $result;
	}

	public function getCustomers(){
		$sql = "SELECT customerName FROM Customers";
		return $this->executeQuery($sql);
	}

	public function getPalletsToCustomer($customerName) {
		$sql = "SELECT palletId FROM PalletDeliveries NATURAL JOIN Orders NATURAL JOIN Customers WHERE customerName = ?";
		return $this->executeQuery($sql, array($customerName));
	}

	public function getPalletsByProductionDateTime($intervalStart, $intervalEnd){
		$intervalStart = $this->getDateTime($intervalStart);
		$intervalEnd = $this->getDateTime($intervalEnd);
		$sql = "SELECT * FROM Pallets WHERE productionDateTime >= ? AND productionDateTime <= ?";
		$result = $this->executeQuery($sql, array($intervalStart,$intervalEnd));
		return $result;

	}
	public function getPalletsByDeliveryDateTime($intervalStart, $intervalEnd){
		$intervalStart = $this->getDateTime($intervalStart);
		$intervalEnd = $this->getDateTime($intervalEnd);
		$sql = "SELECT * FROM Pallets NATURAL JOIN PalletDeliveries NATURAL JOIN Orders WHERE deliveryDateTime >= ? AND deliveryDateTime <= ?";
		$result = $this->executeQuery($sql, array($intervalStart,$intervalEnd));
		return $result;
	}

}

?>
