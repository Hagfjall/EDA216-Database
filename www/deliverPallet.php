<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$orderId = $_REQUEST['orderId'];
	$palletId = $_SESSION['scannedPalletId'];
	$db->openConnection();
	$db->deliverPallet($palletId, $orderId);
	$db->closeConnection();
	header("Location: palletMaintenance.php");
?>