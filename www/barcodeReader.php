<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$palletId  = $_SESSION['scannedPalletId'] = $_REQUEST['freezerExit'];
	$db->openConnection();
	$orders = $db->getOrdersWithProduct($palletId);
	$db->closeConnection();
?>

<html>
<head>
	<title></title>
</head>

<body>
	<p>
		<?php
		 //print $orders[0];
		?>
	</p>
<form method=post action="deliverPallet.php">
		<select name="orderId" size=10>
		<?php
			foreach ($orders as $order) {
					print "<option>";
					print $order['orderId'];
			}
		?>
		</select>
<br>
		<input type=submit value="Deliver Pallet">
	</form>



</body>

</html>
