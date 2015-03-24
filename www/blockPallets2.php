<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$product = $_REQUEST['product'];
	$intervalStart = $_REQUEST['intervalStart'];
	$intervalEnd = $_REQUEST['intervalEnd'];
	$db->openConnection();
	$nbrOfBlockedPallets = $db->blockPallets($product, $intervalStart, $intervalEnd);
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Pallets Blocked</title><head>
<body><h1>Blocked Pallets</h1>
	<p>
	<?php
	print($nbrOfBlockedPallets);
	print(" pallets blocked");
	?>
<p>
<i>It is unclear whether this functionality actually works, at this point. It will be easier to see when functionality for searching is implemented.</i>
	<p>
<a href="palletMaintenance.php">Back to Pallet Maintenance</a>
	
</body>
</html>
