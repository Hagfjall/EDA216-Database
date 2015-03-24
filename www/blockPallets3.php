<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$ingredient = $_SESSION['ingredient'];
	$interval = $_REQUEST['interval'];
	$array = preg_split('/\s+/',$interval);
	$startDate = $array[0]." " .$array[1];
	$endDate = $array[2]." ".$array[3];
	//$nbrOfBlocketPallets = $db->blockPallets($ingredient,$startDate,$endDate);
	print($startDate);
	print($endDate);
?>

<html>
<head><title>KK Sweden AB - Block Pallets</title><head>
<body><h1>Block Pallets(s)</h1>
	
	<!-- <?php print "Blocked $nbrOfBlocketPallets nbr of pallets!" ?> -->

</body>
</html>
