<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$query = $_REQUEST['query'];
	$db->openConnection();
	$ingredients = $db->getIngredients();
	if(!empty($query)){

	}
	$db->closeConnection();

?>



<html>
<head><title>KK Sweden AB Production</title><head>
<body><h1>Block pallets(s)</h1>
	<p>
	Movies showing:
	<p>
		<form method=post action="blockPallets2.php">
		<select name="ingredient" size=10>
		<?php
			$first = true;
			foreach ($ingredients as $ingredient) {
					print "<option>";
					print $ingredient;
			}
		?>
		</select>
		<input type=submit value="Choose dates">
	</form>
</body>
</html>
