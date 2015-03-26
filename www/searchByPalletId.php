<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$palletId = $_REQUEST['palletId'];
	$db->openConnection();
	$palletInfo = $db->getPalletInfo($palletId);
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Search</title><head>
<body><h1>Pallet Info</h1>
	<?php
		$db->printHTMLCodeForTable($palletInfo);
	?>
</body>
</html>
