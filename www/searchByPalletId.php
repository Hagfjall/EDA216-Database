<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$palletId = $_REQUEST['palletId'];
	$db->openConnection();
	$palletInfo= $db->getPalletInfo($palletId);
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Search</title><head>
<body><h1>Pallet Info</h1>
<?php
	$palletInfo = $palletInfo[0];
	if(empty($palletInfo)) {
		print("No such pallet!");
	} else {
	print("<b>Pallet ID: </b>".$palletInfo['palletId']."<br>");
	print("<b>Product: </b>".$palletInfo['productName']."<br>");
	print("<b>Produced: </b>".$palletInfo['productionDateTime']."<br>");
	print("<b>Status: </b>".$palletInfo['state']."<br>");
	print("<b>Blocked?: </b>".$palletInfo['blocked']."<br>");
	}
?>
</body>
</html>