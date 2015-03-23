<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$ingredient = $_REQUEST['ingredient'];
	$_SESSION['ingredient'] = $ingredient;
?>

<html>
<head><title>KK Sweden AB - Block Pallets</title><head>
<body><h1>Block Pallets(s)</h1>
	<p>
	Movies showing:
	<p>
		<form method="post" action="blockPallets3.php">
		    <t>Barcode scanner for freezer-entrance (YYYY-MM-DD HH:MM:SS YYYY-MM-DD HH:MM:SS) <br>

		    <input type="text" size="40" name="interval">
		    <input type="submit" value="Block">
		</form>
</body>
</html>
