<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$userId = $_SESSION['userId'];
	$db->openConnection();
	
	$db->closeConnection();
?>
<html>
<head>
<title>KK Sweden AB - Pallet Maintenance</title>
</head>
<body>
<h1 align="center">Pallet Maintenance</h1>
<a href="blockPallets.php">Block Pallets</a><br>
<a href="producePallets.php">Pallet Production</a><br>
<a href="search.php">Search</a><br>


<!-- Code for barcode reader-box-->
<form method="post" action="barcodeReader.php">
    <t>Barcode scanner for freezer-entrance <br>
    <input type="text" size="20" name="Barcode scanner freezer-entrance">
    <input type="submit" value="Scan">
    <!-- Use different values for different barcode-readers -->
    <input type="hidden" value="freezer-entrance" name="barcodeReader">
</form>

<!-- Code for barcode reader-box-->
<form method="post" action="barcodeReader.php">
    <t>Barcode scanner for freezer-exit <br>
    <input type="text" size="20" name="Barcode scanner freezer-exit">
    <input type="submit" value="Scan">
    <!-- Use different values for different barcode-readers -->
    <input type="hidden" value="freezer-exit" name="barcodeReader">
</form>

</body>
</html>
