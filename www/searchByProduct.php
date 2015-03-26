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
	<table style="width:100%">
<tr>
<td><b>orderId</b></td>
<td><b>palletId</b></td>
<td><b>productionDateTime</b></td>
<td><b>state</b></td>
<td><b>blocked</b></td>
<td><b>productName</b></td>
<td><b>deliveryDateTime</b></td>
<td><b>desiredDeliveryDate</b></td>
<td><b>customerName</b></td>
</tr>
<?php
	foreach($pallets as $row){
		print "<tr>";
		print "<td> ".$row['orderId']."</td>";
		print "<td> ".$row['palletId']."</td>";
		print "<td> ".$row['productionDateTime']."</td>";
		print "<td> ".$row['state']."</td>";
		print "<td> ".$row['blocked']."</td>";
		print "<td> ".$row['productName']."</td>";
		print "<td> ".$row['deliveryDateTime']."</td>";
		print "<td> ".$row['desiredDeliveryDate']."</td>";
		print "<td> ".$row['customerName']."</td>";
		print "</tr>";
	}
?>
</table>
</body>
</html>
