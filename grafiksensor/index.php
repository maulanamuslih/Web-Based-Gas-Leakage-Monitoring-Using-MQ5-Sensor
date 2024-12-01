<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Grafik Sensor Kebocoran Gas MQ5 Realtime</title>

	<!-- Memanggil file bootstrap -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<script type="text/javascript"src="assets/js/jquery-3.4.0.min.js"></script>
	<script type="text/javascript"src="assets/js/mdb.min.js"></script>
	<script type="text/javascript"src="jquery-latest.js"></script>
	<!-- Memanggil data grafik -->
	<script type="text/javascript">
		var refreshid = setInterval(function(){
			$('#responsecontainer').load('data.php');
		},1000);
	</script>

</head>
<body>

	<!-- Tempat menampilkan Grafik -->
	<div class="container" style="text-align: center;">
		<h3>Grafik Sensor Kebocoran Gas MQ5 Realtime</h3>
		<p>(Data yang ditampilkan adalah 25 data terakhir)</p>
	</div>

	<!-- div untuk grafik -->
	<div class="container">
		<div class="container"id="responsecontainer" style="width: 100%; text-align: center;"></div>
	</div>
	

	<!-- Untuk menampilkan gambar -->
	 <!-- <div class="container" style="text-align: center;"> -->
	 	<!-- <img src="assets/img/avatar_default_2.png"> -->
	 <!-- </div> -->

</body>
</html>