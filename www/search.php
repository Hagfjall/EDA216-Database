<html>
<head>
<title>KK Sweden AB - Pallet Search</title>
</head>
<body>
<!-- Code for barcode reader-box-->
<form method="post" action="searchForPalletId.php">
    <t>Search for Pallet Id: <br>
    <input type="text" size="20" name="Barcode scanner freezer-entrance">
    <input type="submit" value="Scan">
    <!-- Use different values for different barcode-readers -->
    <input type="hidden" value="freezer-entrance" name="barcodeReader">
</form>

</body>
</html>
