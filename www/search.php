<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$products = $db->getProducts();
	$customers = $db->getCustomers();
	$db->closeConnection();
?>

<html>
<head>
<title>KK Sweden AB - Pallet Search</title>
</head>
<body>
<h1 align="center">Pallet Search</h1>
<center><i>(Funcionality only supported by browsers Chrome, Safari and Opera)</i></center> <br>
<i>Search by pallet-Id, product, customer, production date or delivery date. </i>
<hr>

<p>
<form method="post" action="searchByPalletId.php">
    <t><strong>Search by Pallet Id: </strong><br>
    <input type="text" size="20" name="palletId">
    <input type="submit" value="Search">
</form>
<hr>

<p>
	<t><Strong>Search by product: </strong> <br>
	<form method=post action="searchByProduct.php">
		<select name="product" size=10>
		<?php
			$first = true;
			foreach ($products as $product) {
					print "<option>";
					print $product;
			}
		?>
		</select>
<br>
		<input type=submit value="Search by product">
	</form>
<hr>

<p>
	<t><Strong>Search by customer: </strong> <br>
	<form method=post action="searchByCustomer.php">
		<select name="customer" size=10>
		<?php
			$first = true;
			foreach ($customers as $customer) {
					print "<option>";
					print $customer['customerName'];
			}
		?>
		</select>
<br>
		<input type=submit value="Search by customer">
	</form>
<hr>

<p>
	<t><Strong>Search by production date: </strong> <br>
	<form method=post action="searchByProductionDateTime.php">
	From:
  	<input type="datetime-local" value ="2015-01-01T11:42:13.510" name="productionIntervalStart">
 	 To:
 	<input type="datetime-local" value ="2015-03-23T22:39:23.510" name="productionIntervalEnd">
	<input type=submit value="Search by production date">
</form>
<hr>

<p>
	<t><Strong>Search by delivery date: </strong> <br>
	<form method=post action="searchByDeliveryDateTime.php">
	From:
  	<input type="datetime-local" value ="2015-01-01T11:42:13.510" name="deliveryIntervalStart">
 	 To:
 	<input type="datetime-local" value ="2015-03-23T22:39:23.510" name="deliveryIntervalEnd">
	<input type=submit value="Search by delivery date">
</form>
<hr>
<p>
	<t><Strong>Search for blocked pallets: </strong> <br>
	<form method=post action="searchBlockedPallets.php">
	<input type=submit value="Show Blocked Pallets">
</form>
<hr>


</body>
</html>
