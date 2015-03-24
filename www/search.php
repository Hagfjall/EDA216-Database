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
<i>Search by pallet-Id, product, customer, production date or delivery date. </i>
<hr>

<p>
<form method="post" action="searchForPalletId.php">
    <t><strong>Search by Pallet Id: </strong><br>
    <input type="text" size="20" name="Barcode scanner freezer-entrance">
    <input type="submit" value="Scan">
    <!-- Use different values for different barcode-readers -->
    <input type="hidden" value="freezer-entrance" name="barcodeReader">
</form>
<hr>

<p>
	<t><Strong>Search by product: </strong> <br>
	<form method=post action="blockPallets2.php">
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
		<input type=submit value="Search for product">
	</form>
<hr>

<p>
	<t><Strong>Search by customer: </strong> <br>

<hr>

<p>
	<t><Strong>Search for production date: </strong> <br>

<hr>
<p>
	<t><Strong>Search for delivery date: </strong> <br>

<hr>


</body>
</html>
