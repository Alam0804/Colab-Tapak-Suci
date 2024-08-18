<?php 
	include "../backend/includes/connection.php";

	//mencari TOTAL partai
	$sqltotalpartai = mysqli_query($koneksi, "SELECT COUNT(*) FROM jadwal_tanding");
	$totalpartai = mysqli_fetch_array($sqltotalpartai);

	//mencari TOTAL partai SELESAI
	$sqlpartaiselesai = mysqli_query($koneksi, "SELECT COUNT(*) FROM jadwal_tanding WHERE status<>'-'");
	$partaiselesai = mysqli_fetch_array($sqlpartaiselesai);

	//Mencari data jadwal pertandingan
	$sqljadwal = "SELECT * FROM jadwal_tanding WHERE status <> '-' ORDER BY id_partai ASC";
	$jadwal_tanding = mysqli_query($koneksi,$sqljadwal);
?>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<center><h1>Jadwal Pertandingan</h1></center>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr class="text-center">
			<td><a href="index.php" class="btn btn-info" role="button">PROSES</a></td>
			<td><a href="index-selesai.php" class="btn btn-default" role="button">SELESAI</a></td>
		</tr>
	</table>
</div>

<div class="table-responsive">
	<table class="table table-bordered">
		<tr class="text-center">
			<td><b>TOTAL : <?php echo $totalpartai[0]." Partai"; ?></b></td>
			<td><b>SELESAI : <?php echo $partaiselesai[0]." Partai"; ?></b></td>
			<td><b>SISA : <?php echo $totalpartai[0] - $partaiselesai[0]." Partai"; ?></b></td>
		</tr>
	</table>
</div>

<div id="jadwaltanding" class="table-responsive">
<table class="table table-bordered table-striped">
	<thead>
	<tr>
		<td>GEL.</td>
		<td>PARTAI</td>
		<td>BABAK</td>
		<td>KELOMPOK</td>
		<td>SUDUT KUNING</td>
		<td>SUDUT BIRU</td>
		<td>SKOR</td>
		<td>PEMENANG</td>
		<td>ACTION</td>
	</tr>
	</thead>
	<?php while($jadwal = mysqli_fetch_array($jadwal_tanding)) { ?>
	<tr>
		<td rowspan="2"><center><?php echo $jadwal['gelanggang']; ?></center></td>
		<td rowspan="2"><center><?php echo $jadwal['partai']; ?></center></td>
		<td rowspan="2"><center><?php echo $jadwal['babak']; ?></center></td>
		<td rowspan="2"><?php echo $jadwal['kelas']; ?></td>
		<td><?php echo $jadwal['nm_merah']; ?></td>
		<td><?php echo $jadwal['nm_biru']; ?></td>
		<td rowspan="2"><?php echo $jadwal['status']; ?></td>
		<td rowspan="2"><?php echo $jadwal['pemenang']; ?></td>
		<td rowspan="2">
			<a href="view_tanding.php?id_partai=<?php echo $jadwal['id_partai']; ?>" class="btn btn-warning" role="button">Lihat Nilai</a>
			<br/>
			<a href="monitor_nilai.php?id_partai=<?php echo $jadwal['id_partai']; ?>" class="btn btn-warning" role="button">Monitoring KP</a>
		</td>
	</tr>
	<tr>
		<td><?php echo $jadwal['kontingen_merah']; ?></td>
		<td><?php echo $jadwal['kontingen_biru']; ?></td>
	</tr>
	<?php } ?>
</table>
</div>
</div>
</body>
</html>