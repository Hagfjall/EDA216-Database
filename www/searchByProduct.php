<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$productName = $_REQUEST['product'];
	$db->openConnection();
	$pallets= $db->getPalletsWithProduct($productName);
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Search</title><head>
<body><h1>Pallets with <?php print($productName);
print "</h1>";
$db->printHTMLCodeForTable($pallets);
?>
</body>
</html>
