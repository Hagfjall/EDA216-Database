<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$freezerEntrance = $_REQUEST['freezerEntrance'];
	$freezerExit  = $_REQUEST['freezerExit'];
	$db->openConnection();
		if(!empty(freezerEntrance)){
	$palletId = $db->freezerEntranceScanner($freezerEntrance);	
	} else if (!empty(freezerExit)){
		$palletId = $db->freezerExitScanner($freezerExit);
	}	
	$db->closeConnection();
	header("Location: palletMaintenance.php");
?>