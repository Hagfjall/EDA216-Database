<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$product = $_REQUEST['product'];
	$_SESSION['product'] = $product;
print($_REQUEST['intervalStart']);
print($_REQUEST['intervalEnd']);
?>

<html>
<head><title>KK Sweden AB - Block Pallets</title><head>
<body><h1>Block Pallets(s)</h1>

	<p>
	Chose time period:
	<p>
		<form method="post" action="blockPallets3.php">
		    <t>Enter time period (YYYY-MM-DD HH:MM:SS YYYY-MM-DD HH:MM:SS):<br>

		    <input type="text" size="40" name="interval">
		    <input type="submit" value="Block">
		</form>
</body>
</html>
