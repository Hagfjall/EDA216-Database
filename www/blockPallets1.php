<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$query = $_REQUEST['query']; // Where does thos come from? Where is request attribute 'query' set?
	$db->openConnection();
	$products = $db->getProducts();
	if(!empty($query)){

	}
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
  From:
  <input type="datetime-local" name="intervalStart">
  To:
  <input type="datetime-local" name="intervalEnd">
<p>
		<input type=submit value="Block products!">
	</form>
</body>
</html>
