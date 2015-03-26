<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$pallets = $db->getBlockedPallets();
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Pallet Info</title><head>
<body><h1>Pallet Info </h1>
	<p>
	<?php
	print "</h1>";
	$db->printHTMLCodeForTable($pallets);
	?>

	</body>
	</html>
