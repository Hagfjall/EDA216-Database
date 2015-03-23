<?php
  require_once('database.inc.php');
  require_once("mysql_connect_data.inc.php");
  $db = new Database($host, $userName, $password, $database);
  $db->openConnection();
  if (!$db->isConnected()) {
    header("Location: cannotConnect.html");
    exit();
  }

  session_start();
  $_SESSION['db'] = $db;
?>
<html>
<head>
<title>KK Sweden AB</title>
</head>
<body>
<h1 align="center">KK Sweden AB Production</h1>
<a href="blockPallets.php">Do you need to block one or more pallets?</a><br>
<a href="search.php">Search</a><br>


<!-- Code for barcode reader-box-->
<form method="post" action="barcodeReader.php">
    <t>Barcode scanner for freezer-entrance <br>
    <input type="text" size="20" name="Barcode scanner freezer-entrance">
    <input type="submit" value="Scan">
    <!-- Use different values for different barcode-readers -->
    <input type="hidden" value="freezer-entrance" name="barcodeReader">
</form>

<!-- Code for barcode reader-box-->
<form method="post" action="barcodeReader.php">
    <t>Barcode scanner for freezer-exit <br>
    <input type="text" size="20" name="Barcode scanner freezer-exit">
    <input type="submit" value="Scan">
    <!-- Use different values for different barcode-readers -->
    <input type="hidden" value="freezer-exit" name="barcodeReader">
</form>

</body>
</html>