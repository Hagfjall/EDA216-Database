<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$product = $_REQUEST['product'];
	$amount = $_REQUEST['amount'];
	$db->openConnection();
	$ans = $db->producePallets($product, $amount);
	$db->closeConnection();

?>