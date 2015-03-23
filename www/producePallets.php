<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$db->closeConnection();

?>



<html>
<head><title>KK Sweden AB Production</title></head>
<body><h1>Produce new Pallet(s)</h1>

</body>
</html>