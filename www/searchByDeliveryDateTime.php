<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$intervalStart = $_REQUEST['deliveryIntervalStart'];
	$intervalEnd = $_REQUEST['deliveryIntervalEnd'];
	$db->openConnection();
	$pallets = $db->getPalletsByDeliveryDateTime($intervalStart, $intervalEnd);
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Pallet Info</title><head>
<body><h1>Pallet(s) Info </h1>
	<p>
<?php
print "</h1>";
$db->printHTMLCodeForTable($pallets);
?>
	</body>
	</html>
