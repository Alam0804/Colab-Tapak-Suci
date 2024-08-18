<?php
	include "../backend/includes/connection.php";

	//dapatkan ID jadwal pertandingan
	//$id_partai = mysqli_real_escape_string($koneksi,$_GET["id_partai"]);
	$id_partai = (int) $_GET['id_partai'];
	//echo $id_partai;

	//Mencari data jadwal pertandingan
	$sqljadwal = "SELECT * FROM jadwal_tanding 
					WHERE id_partai='$id_partai'";
	$jadwal_tanding = mysqli_query($koneksi,$sqljadwal);
	$jadwal = mysqli_fetch_array($jadwal_tanding);

?>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- SELESAI Confirm Function -->	
	<script>
		function cek_selesai()
		{
			if(confirm('Apakah Anda Yakin Pertandingan Sudah Berakhir?')){
				return true;
			} else {
				return false;
			}
		}
	</script>

</head>
<body>
<div class="container">
	<div class="table-responsive">
		<table class="table">
			<tr class="text-center">
				<td><a href="index.php" class="btn btn-warning" role="button">KEMBALI</a></td>
				<td><a href="monitor_nilai.php?id_partai=<?php echo $id_partai;?>" class="btn btn-warning" role="button">Detail Poin</a></td>
				<td><a href="view_tanding_kp.php?id_partai=<?php echo $id_partai;?>" class="btn btn-warning" role="button">Monitor Skor</a></td>
			</tr>
		</table>
	</div>

	<div class="table-responsive">
		<table class="table">
			<tr class="text-center" style="font-size: 24px; font-weight: bold;">
				<td colspan="8">GELANGGANG : <?php echo $jadwal['gelanggang']; ?></td>
			</tr>
			<tr class="text-center" style="font-size: 24px; font-weight: bold;">
				<td colspan="8">
					PARTAI KE : <?php echo $jadwal['partai']; ?> - 
					<?php echo $jadwal['kelas']; ?> -
					(<?php echo $jadwal['babak']; ?>)
				</td>
			</tr>
		</table>

		<table class="table table-bordered">
		<tr class="text-center" bgcolor="#C6C9CA">
			<td colspan="8">RONDE 1</td>
		</tr>
		<tr class="text-center">
			<td td colspan="1" width="50%"; bgcolor="#FFFF00">K</td>
			<td td colspan="1" width="50%" ; bgcolor="#4d94ff">B</td>
			
		</tr>
		<tr class="text-center">
			<td>
				<table style="width: 100%;">
					<?php 
						$sqljadwal = "SELECT id_nilai,id_jadwal,button FROM nilai_tanding WHERE id_jadwal={$id_partai} AND babak=1 AND id_juri=1 AND sudut='kuning' ORDER BY id_nilai DESC";
						$jadwal_tanding = mysqli_query($koneksi,$sqljadwal);
						while($item = mysqli_fetch_array($jadwal_tanding)):
					?>
						<tr>
							<th class="text-center"><?=$item['button']?></th>
						</tr>
					<?php endwhile;?>
				</table>
			</td>
			<td>
				<table style="width: 100%;">
					<?php 
						$sqljadwal = "SELECT id_nilai,id_jadwal,button FROM nilai_tanding WHERE id_jadwal={$id_partai} AND babak=1 AND id_juri=1 AND sudut='biru' ORDER BY id_nilai DESC";
						$jadwal_tanding = mysqli_query($koneksi,$sqljadwal);
						while($item = mysqli_fetch_array($jadwal_tanding)):
					?>
						<tr>
							<th class="text-center"><?=$item['button']?></th>
						</tr>
					<?php endwhile;?>
				</table>
			</td>

			
		</tr>
	</table>

	<table class="table table-bordered">
		<tr class="text-center" bgcolor="#C6C9CA">
			<td colspan="8">RONDE 2</td>
		</tr>
		<tr class="text-center">
			<td td colspan="1" width="50%"; bgcolor="#FFFF00">K</td>
			<td td colspan="1" width="50%" ; bgcolor="#4d94ff">B</td>
			
		</tr>
		<tr class="text-center">
			
			<td>
				<table style="width: 100%;">
					<?php 
						$sqljadwal = "SELECT id_nilai,id_jadwal,button FROM nilai_tanding WHERE id_jadwal={$id_partai} AND babak=2 AND id_juri=1 AND sudut='kuning' ORDER BY id_nilai DESC";
						$jadwal_tanding = mysqli_query($koneksi,$sqljadwal);
						while($item = mysqli_fetch_array($jadwal_tanding)):
					?>
						<tr>
							<th class="text-center"><?=$item['button']?></th>
						</tr>
					<?php endwhile;?>
				</table>
			</td>
			<td>
				<table style="width: 100%;">
					<?php 
						$sqljadwal = "SELECT id_nilai,id_jadwal,button FROM nilai_tanding WHERE id_jadwal={$id_partai} AND babak=2 AND id_juri=1 AND sudut='biru' ORDER BY id_nilai DESC";
						$jadwal_tanding = mysqli_query($koneksi,$sqljadwal);
						while($item = mysqli_fetch_array($jadwal_tanding)):
					?>
						<tr>
							<th class="text-center"><?=$item['button']?></th>
						</tr>
					<?php endwhile;?>
				</table>
			</td>

			
		</tr>
	</table>

	<table class="table table-bordered">
		<tr class="text-center" bgcolor="#C6C9CA">
			<td colspan="8">RONDE TAMBAHAN</td>
		</tr>
		<tr class="text-center">
			<td td colspan="1" width="50%"; bgcolor="#FFFF00">K</td>
			<td td colspan="1" width="50%" ; bgcolor="#4d94ff">B</td>
		</tr>
		<tr class="text-center">
			<td>
				<table style="width: 100%;">
					<?php 
						$sqljadwal = "SELECT id_nilai,id_jadwal,button FROM nilai_tanding WHERE id_jadwal={$id_partai} AND babak=3 AND id_juri=1 AND sudut='kuning' ORDER BY id_nilai DESC";
						$jadwal_tanding = mysqli_query($koneksi,$sqljadwal);
						while($item = mysqli_fetch_array($jadwal_tanding)):
					?>
						<tr>
							<th class="text-center"><?=$item['button']?></th>
						</tr>
					<?php endwhile;?>
				</table>
			</td>
			<td>
				<table style="width: 100%;">
					<?php 
						$sqljadwal = "SELECT id_nilai,id_jadwal,button FROM nilai_tanding WHERE id_jadwal={$id_partai} AND babak=3 AND id_juri=1 AND sudut='biru' ORDER BY id_nilai DESC";
						$jadwal_tanding = mysqli_query($koneksi,$sqljadwal);
						while($item = mysqli_fetch_array($jadwal_tanding)):
					?>
						<tr>
							<th class="text-center"><?=$item['button']?></th>
						</tr>
					<?php endwhile;?>
				</table>
			</td>

			
		</tr>
	</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	
	setInterval(function(){
		$.ajax({
            url: 'http://192.168.83.162/tapaksuci//nilai/api.php', 
            data : {'a' : 'get_data_view_monitoring', 'id_partai': <?=$_GET["id_partai"]?>},
            type: "GET",
            success: function(obj){
            	$('#content_babak').html(obj);

            	console.log('Request ... Done');
            }
        });
	}, 2000);

</script>
</body>
</html>