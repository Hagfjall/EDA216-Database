<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$freezerExit  = $_REQUEST['freezerExit'];
	$db->openConnection();
	$db->freezerExitScanner($freezerExit);
	$db->closeConnection();
	header("Location: palletMaintenance.php");
?>