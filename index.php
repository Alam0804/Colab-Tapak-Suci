<?php 
	/*
	*---------------------------------------------------------------
	* E-REGISTRASI PENCAK SILAT
	*---------------------------------------------------------------
	* This program is free software; you can redistribute it and/or
	* modify it under the terms of the GNU General Public License
	* as published by the Free Software Foundation; either version 2
	* of the License, or (at your option) any later version.
	*
	* This program is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	* GNU General Public License for more details.
	*
	* You should have received a copy of the GNU General Public License
	* along with this program; if not, write to the Free Software
	* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
	*
	* @Creator Yudha Yogasara
	* yudha.yogasara@gmail.com
	* @Contributor Sofyan Hadi, Satria Salam
	*
	* IPSI KABUPATEN TANGERANG
	* SALAM OLAHRAGA
	*/
	
	include "backend/includes/connection.php";


	//count jumlah peserta ALL
	$sqlpesertaall = mysqli_query($koneksi, "SELECT COUNT(*) FROM peserta");
	$datapesertaall = mysqli_fetch_array($sqlpesertaall);

	//count jumlah peserta ALL WHERE PAID
	$sqlpesertpaid = mysqli_query($koneksi, "SELECT COUNT(*) FROM peserta WHERE status='PAID' ");
	$datapesertapaid = mysqli_fetch_array($sqlpesertpaid);

	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrasi Sirkuit Pencak Silat</title>
<meta name="description" content="Registrasi Online Kejuaraan Pencak Silat">
<meta name="keywords" content="registrasi,online,pencak,silat">
<meta name="robots" content="index,follow">
<meta name="author" content="Yudha Yogasara">
<!-- CSS Files -->
    <link href="css/reset.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/stylesheet.css" rel="stylesheet" type="text/css" media="all" />
	
</head>
<body>
<!-- Start Wrapper -->
<div id="wrapper">
  <?php 
	include "headmenu.php";
  ?>
<h1 align="center" id="logo" name="logo"><a href="index.php"></a><a href="index.php"><img src="images/kejurfaklogo.png" height="100" /></a></h1>
<p><strong>KEJURFAK TAPAK SUCI UINAM 2024</strong></p>
<p>Bagian dari rangkaian acara Milad UKM Tapak Suci UINAM yang ke-33
</p>

</br></br>
<p><strong>JADWAL KEGIATAN</strong></p>
<p><strong>Pendaftaran :</strong> 6 Mei - 6 Juni 2024</p>
<p><strong>Technical Meeting :</strong> 13 Juni 2024</p>
<p><strong>Upacara Pembukaan :</strong> 14 Juni 2024</p>
<p><strong>Pertandingan :</strong> 14 Juni 2024</p>
<p><strong>Upacara Penutupan :</strong> 15 Juni 2024</p>

</br></br>

<h1>TOTAL PENDAFTAR</h1>
<p>Sampai dengan <?php date_default_timezone_set("Asia/Jakarta"); echo date("d/m/Y").", ".date("h:i A"); ?>, yang telah melakukan registrasi sebanyak <?php echo "<strong>".$datapesertaall[0]."</strong>"; ?> orang.</p>
<p>Peserta yang sudah melakukan konfirmasi biaya pendaftaran dan terverifikasi datanya, sebanyak <?php echo "<strong>".$datapesertapaid[0]."</strong>"; ?> orang.</p>
<p>Klik menu <a href="pencarian.php">Pencarian Data</a> untuk memeriksa apakah Pesilat Anda sudah terdaftar.</p>

</br>
</br>
<div align="center"><a href="mulai_pendaftaran.php"><img src="images/daftar-now.gif" width="200px"></a></div>


<!-- start: footer -->
<div id="footer">
	<p>Copyleft 2016 <?php echo " - ".date("Y"); ?> <a href="developer.php">IPSI Kabupaten Tangerang</a> </p>
	<!-- end: footer -->
</div>
<!-- end: footer -->
</div>
  </body>
</html>