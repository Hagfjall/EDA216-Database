<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$customerName = $_REQUEST['customer'];
	$db->openConnection();
	$pallets= $db->getPalletsToCustomer($customerName);
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Search</title><head>
<body><h1>Pallets delivered to <?php print($customerName);
	print "</h1>";
$db->printHTMLCodeForTable($pallets);
?>
</body>
</html>
