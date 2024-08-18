<?php
	include "../backend/includes/connection.php";

	$pemenang = mysqli_real_escape_string($koneksi,$_POST["pemenang"]);
	$id_partai = mysqli_real_escape_string($koneksi,$_POST["id_partai"]);
	
	$skorakhirmerah = mysqli_real_escape_string($koneksi,$_POST["skorakhirmerah"]);
	$skorakhirbiru = mysqli_real_escape_string($koneksi,$_POST["skorakhirbiru"]);
	$skorakhir = "( ".$skorakhirmerah."-".$skorakhirbiru." )";

	if($pemenang == '' OR $id_partai == '')
	{
		?>
		<script type="text/javascript">
			alert('Gagal!');
			document.location='index.php';
		</script>
		<?php
		exit; 
	}

	//Mencari data atribut partai
	$sqlpartai = "SELECT * FROM jadwal_tanding 
					WHERE id_partai='$id_partai'";
	$datapartai = mysqli_query($koneksi,$sqlpartai);
	$partai = mysqli_fetch_array($datapartai);

	$no_partai = $partai['partai'];
	$nama_merah = $partai['nm_merah'];
	$nama_biru = $partai['nm_biru'];
	$kontingen_merah = $partai['kontingen_merah'];
	$kontingen_biru = $partai['kontingen_biru'];

	//Mencari total nilai dan hukuman SUDUT KUNING
	$sqltotalnilaimerah = "SELECT SUM(nilai) AS datanilaimerah FROM nilai_tanding WHERE sudut='KUNING' AND id_jadwal='$id_partai'";
	$totalnilaimerah = mysqli_query($koneksi,$sqltotalnilaimerah);
	$nilaimerah = mysqli_fetch_array($totalnilaimerah);
	$nilaisudutmerah = $nilaimerah['datanilaimerah'] / 4;

	$sqltotalhukumanmerah = "SELECT SUM(nilai) AS datahukumanmerah FROM nilai_tanding WHERE sudut='KUNING' AND nilai LIKE '%-%' AND id_jadwal='$id_partai'";
	$totalhukumanmerah = mysqli_query($koneksi,$sqltotalhukumanmerah);
	$hukumanmerah = mysqli_fetch_array($totalhukumanmerah);
	$hukumansudutmerah = $hukumanmerah['datahukumanmerah'] / 4;
	
	//Mencari total nilai dan hukuman SUDUT BIRU
	$sqltotalnilaibiru = "SELECT SUM(nilai) AS datanilaibiru FROM nilai_tanding WHERE sudut='BIRU' AND id_jadwal='$id_partai'";
	$totalnilaibiru = mysqli_query($koneksi,$sqltotalnilaibiru);
	$nilaibiru = mysqli_fetch_array($totalnilaibiru);
	$nilaisudutbiru = $nilaibiru['datanilaibiru'] / 4;

	$sqltotalhukumanbiru = "SELECT SUM(nilai) AS datahukumanbiru FROM nilai_tanding WHERE sudut='BIRU' AND nilai LIKE '%-%' AND id_jadwal='$id_partai'";
	$totalhukumanbiru = mysqli_query($koneksi,$sqltotalhukumanbiru);
	$hukumanbiru = mysqli_fetch_array($totalhukumanbiru);
	$hukumansudutbiru = $hukumanbiru['datahukumanbiru'] / 4;
	

	//input data total nilai dan hukuman ATLET SUDUT KUNING
	$insertnilaimerah = mysqli_query($koneksi, "INSERT INTO nilai_atlet(no_partai, nama, kontingen, hukuman, nilai) 
		VALUES('$no_partai', '$nama_merah', '$kontingen_merah', '$hukumansudutmerah', '$nilaisudutmerah')");

	//input data total nilai dan hukuman ATLET SUDUT BIRU
	$insertnilaibiru = mysqli_query($koneksi, "INSERT INTO nilai_atlet(no_partai, nama, kontingen, hukuman, nilai) 
		VALUES('$no_partai', '$nama_biru', '$kontingen_biru', '$hukumansudutbiru', '$nilaisudutbiru')");

	
	//ubah status NON-AKTIF PARTAI
	$updateaktif = mysqli_query($koneksi,"UPDATE jadwal_tanding SET aktif='0' WHERE id_partai='$id_partai'");

	//UPDATE DATA PEMENANG dan SKOR AKHIR
	$update = mysqli_query($koneksi,"UPDATE jadwal_tanding SET status='$skorakhir', pemenang='$pemenang' WHERE id_partai='$id_partai'");

	?>
		<script type="text/javascript">
			alert('Nilai berhasil tersimpan.');
			document.location='index.php';
		</script>
	<?php
?>