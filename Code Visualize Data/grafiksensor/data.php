<?php 
    // koneksi ke database 
    $konek = mysqli_connect("localhost", "root", "", "gas_leak_detection");
    
    // validasi koneksi
    if (!$konek) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

 // membaca tabel gas_leak1
    // Membaca ID Tertinggi
    $sql_No = mysqli_query($konek, "SELECT MAX(No) FROM gas_leak1");
    // Tanggal Data
    $data_No = mysqli_fetch_array($sql_No);
    // Mengambi Sampel Terakhir / Terbaru
    $No_akhir = $data_No ['MAX(No)'];
    $No_awal = $No_akhir - 24
     ;

    // membaca tanggal Sumbu X
    $Tanggal = mysqli_query($konek, "SELECT `Tanggal/Waktu` FROM gas_leak1 WHERE No>= '$No_awal' and No<='$No_akhir' ORDER BY No ASC");
    if (!$Tanggal) {
        die("Error pada query Tanggal: " . mysqli_error($konek));
    }

    // membaca gas level Sumbu Y
    $GasLevel = mysqli_query($konek, "SELECT `Gas Level` FROM gas_leak1 WHERE No>= '$No_awal' and No<='$No_akhir' ORDER BY No ASC");
    if (!$GasLevel) {
        die("Error pada query Gas Level: " . mysqli_error($konek));
    }

    // membaca LED BAHAYA
    // $LedBahaya = mysqli_query($konek, "SELECT `Lampu BAHAYA` FROM gas_leak1 ORDER BY No ASC");

    // membaca LED AMAN
    // $LedAman = mysqli_query($konek, "SELECT `Lampu AMAN` FROM gas_leak1 ORDER BY No ASC");
?>

<!-- Menampilkan Grafik -->
<div class="panel panel-primary">
	<div class="panel-heading">
		Nilai Gas Level 
	</div>
	<div class="panel-body">
		<!-- Menyiapkan Canvas untuk Grafik -->
		<canvas id="myChart"></canvas>

		<!-- Gambar Grafik -->
		<script type="text/javascript">
			// Membaca ID Canva Grafik
			var canvas = document.getElementById('myChart');

			// Tempat Data Grafik Tggl Gas Level
			var data = {
				labels : [
					<?php 
					while ($data_tanggal = mysqli_fetch_array ($Tanggal))
					{
						echo '"'.$data_tanggal['Tanggal/Waktu'].'",';
					} 
					?>
				], 
				datasets : [
                    {
    					label : "Gas Level",
    					fill : true,
    					backgroundColor : "rgba(64, 159, 138, .4)",
    					borderColor : "rgba(64, 159, 138, 1)",
    					lineTension : 0.3,
    					pointRadius : 5,
    					data : [
    						<?php 
    						while($data_GasLevel = mysqli_fetch_array($GasLevel))
    						{
    							echo $data_GasLevel["Gas Level"].',';
    						} 
    						?>
    					]
    				},
                    {
                        label: "Ambang Batas (700)",
                        fill: false,
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderDash: [10, 5], // Garis putus-putus
                        pointRadius: 0, // Tidak ada titik
                        data: [
                            <?php 
                            $totalData = mysqli_num_rows($Tanggal); // Hitung jumlah data tanggal
                            for ($i = 0; $i < $totalData; $i++) {
                                echo '700,';
                            }
                            ?>
                        ]
                    }
                ]
			};

			// Pilihan Grafik
			var option = {
				showLines : true,
				animation : {duration : 0}
			};

			// Mencetak Grafik di Canva
			var myLineChart = new Chart(canvas, {
				type: 'line', // Pastikan tipe grafik adalah 'line'
				data : data,
				options : option
			});
		</script>
	</div>
</div>
