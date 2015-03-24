<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$productName = $_REQUEST['product'];
	$db->openConnection();
	$pallets= $db->getPalletsWithProduct($productName);
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Search</title><head>
<body><h1>Pallets with <?php print($productName);?></h1>
	<form method=post action="searchByPalletId.php">
	<select name="palletId" size=10>
		<?php
			$first = true;
			foreach ($pallets as $pallet) {
					print "<option>";
					print $pallet['palletId'];
			}
		?>
		</select>
		<input type=submit value="Select pallet">
	</form>
</body>
</html>