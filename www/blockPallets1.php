<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$products = $db->getProducts();
	$db->closeConnection();
?>
<html>
<head><title>KK Sweden AB - Block Pallets</title><head>
<body><h1>Block Pallets </h1>
<i>(Funcionality only supported by browsers Chrome, Safari and Opera)</i>
	<p>
	<b>Product to block</b>
	<p>
		<form method=post action="blockPallets2.php">
		<select name="product" size=10>
		<?php
			$first = true;
			foreach ($products as $product) {
					print "<option>";
					print $product;
			}
		?>
		</select>
<p>
<b>Production Time Period:</b>
<p>
  <input type="datetime-local" value ="2015-01-01T11:42:13.510" name="intervalStart">
  To:
  <input type="datetime-local" value ="2015-03-23T22:39:23.510" name="intervalEnd">
<p>
		<input type=submit value="Block products!">
	</form>
</body>
</html>
