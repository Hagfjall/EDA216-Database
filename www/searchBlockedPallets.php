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
		<table style="width:100%">
	<tr>
	<td><b>palletId</b></td>
	<td><b>productionDateTime</b></td>
	<td><b>state</b></td>
	<td><b>productName</b></td>
	</tr>
<?php
		foreach($pallets as $row){
			print "<tr>";
			print "<td> ".$row['palletId']."</td>";
			print "<td> ".$row['productionDateTime']."</td>";
			print "<td> ".$row['state']."</td>";
			print "<td> ".$row['productName']."</td>";
			print "</tr>";
		}
?>
</table>



	</body>
	</html>