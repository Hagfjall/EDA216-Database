<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$intervalStart = $_REQUEST['productionIntervalStart'];
	$intervalEnd = $_REQUEST['productionIntervalEnd'];
	$db->openConnection();
	$pallets = $db->getPalletsByProductionDateTime($intervalStart, $intervalEnd);
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Pallet Info</title><head>
<body><h1>Pallet(s) Info 
<?php
	print "</h1>";
	$db->printHTMLCodeForTable($pallets);
?>
	</body>
	</html>
