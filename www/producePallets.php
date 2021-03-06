<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$products = $db->getProducts();
	$db->closeConnection();
?>

<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#produce").click(function(){
		var input = {product : $("#type").val(), amount : $("#amount").val()};	
		if (input.amount < 1) {

		} else {
			$.get("produceReq.php", input, function(){	

				$("p#res").append($("#amount").val());	
				if (input.amount > 1) {	
					$("p#res").append(" pallets of ");		
					$("p#res").append($("#type").val());
					$("p#res").append("s is now produced and stored in the freezer</br>");
				} else {
					$("p#res").append(" pallet of ");		
					$("p#res").append($("#type").val());
					$("p#res").append("s is now produced and stored in the freezer</br>");
				}
					
			});
		}
	});
});
</script>
<title>KK Sweden AB Production</title>
</head>
<body>
	<h1>Produce new Pallets</h1>
	<p>Choose product:</p>
	<select id="type" name="type" size=10>
		<?php
		$first = true;
		foreach ($products as $product) {
			print "<option>";
			print $product;
		}
		?>
	</select>
	</br>
	<p>Enter number of pallets :</p>
	<input id="amount" type="text" name="amount">
	<button id="produce">Produce pallet(s)</button>
	<p id="res"></p>

</body>
</html>
