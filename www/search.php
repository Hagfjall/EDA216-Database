<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$products = $db->getProducts();
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
    <input type="text" size="20" name="Barcode scanner freezer-entrance">
    <input type="submit" value="Scan">
    <!-- Use different values for different barcode-readers -->
    <input type="hidden" value="freezer-entrance" name="barcodeReader">
</form>
<hr>

<p>
	<t><Strong>Search by product: </strong> <br>
	<form method=post action="searchByCustomer.php">
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

<hr>

<p>
	<t><Strong>Search by production date: </strong> <br>
	<form method=post action="searchByProductionDate.php">
	From:
  	<input type="datetime-local" name="intervalStart">
 	 To:
 	<input type="datetime-local" name="intervalEnd">
	<input type=submit value="Search by production date">
	<form>
<hr>
<p>
	<t><Strong>Search by delivery date: </strong> <br>
	<form method=post action="searchByDeliveryDate.php">
	From:
  	<input type="datetime-local" name="intervalStart">
 	 To:
 	<input type="datetime-local" name="intervalEnd">
	<input type=submit value="Search by delivery date">
	<form>
<hr>


</body>
</html>
