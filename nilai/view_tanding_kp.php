<?php 
	include "../backend/includes/connection.php";

	//dapatkan ID jadwal pertandingan
	$id_partai = mysqli_real_escape_string($koneksi,$_GET["id_partai"]);

	//Mencari data jadwal pertandingan
	$sqljadwal = "SELECT * FROM jadwal_tanding 
					WHERE id_partai='$id_partai'";
	$jadwal_tanding = mysqli_query($koneksi,$sqljadwal);
	$jadwal = mysqli_fetch_array($jadwal_tanding);

	
	//----------------- WASIT JURI 1 MERAH
	//Kueri nilai wasit juri 1, babak 1, sudut merah
	$sqljuri1babak1merah = "SELECT SUM(nilai) FROM nilai_tanding
							WHERE id_jadwal='$id_partai' AND 
							id_juri='1' AND
							babak='1' AND
							sudut='KUNING'";
	$juri1babak1merah = mysqli_query($koneksi,$sqljuri1babak1merah);
	$nilaijuri1babak1merah = mysqli_fetch_array($juri1babak1merah);

	//Kueri nilai wasit juri 1, babak 2, sudut merah
	$sqljuri1babak2merah = "SELECT SUM(nilai) FROM nilai_tanding
							WHERE id_jadwal='$id_partai' AND 
							id_juri='1' AND
							babak='2' AND
							sudut='KUNING'";
	$juri1babak2merah = mysqli_query($koneksi,$sqljuri1babak2merah);
	$nilaijuri1babak2merah = mysqli_fetch_array($juri1babak2merah);

	//Kueri nilai wasit juri 1, babak 3, sudut merah
	$sqljuri1babak3merah = "SELECT SUM(nilai) FROM nilai_tanding
							WHERE id_jadwal='$id_partai' AND 
							id_juri='1' AND
							babak='3' AND
							sudut='KUNING'";
	$juri1babak3merah = mysqli_query($koneksi,$sqljuri1babak3merah);
	$nilaijuri1babak3merah = mysqli_fetch_array($juri1babak3merah);
	//----------------- END WASIT JURI 1 MERAH



	//----------------- AREA BIRU --------------------------
	//------------------------------------------------------

	//----------------- WASIT JURI 1 BIRU
	//Kueri nilai wasit juri 1, babak 1, sudut biru
	$sqljuri1babak1biru = "SELECT SUM(nilai) FROM nilai_tanding
							WHERE id_jadwal='$id_partai' AND 
							id_juri='1' AND
							babak='1' AND
							sudut='BIRU'";
	$juri1babak1biru = mysqli_query($koneksi,$sqljuri1babak1biru);
	$nilaijuri1babak1biru = mysqli_fetch_array($juri1babak1biru);

	//Kueri nilai wasit juri 1, babak 2, sudut biru
	$sqljuri1babak2biru = "SELECT SUM(nilai) FROM nilai_tanding
							WHERE id_jadwal='$id_partai' AND 
							id_juri='1' AND
							babak='2' AND
							sudut='BIRU'";
	$juri1babak2biru = mysqli_query($koneksi,$sqljuri1babak2biru);
	$nilaijuri1babak2biru = mysqli_fetch_array($juri1babak2biru);

	//Kueri nilai wasit juri 1, babak 3, sudut biru
	$sqljuri1babak3biru = "SELECT SUM(nilai) FROM nilai_tanding
							WHERE id_jadwal='$id_partai' AND 
							id_juri='1' AND
							babak='3' AND
							sudut='BIRU'";
	$juri1babak3biru = mysqli_query($koneksi,$sqljuri1babak3biru);
	$nilaijuri1babak3biru = mysqli_fetch_array($juri1babak3biru);
	//----------------- END WASIT JURI 1 biru
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
<!--<div class="table-responsive">-->

<table class="table">
  <thead>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

  </thead>
  <tbody class="content_penilaian">
  			<tr class="text-center">
      <td colspan="9" style="font-size: 28px; font-weight: bold;">PARTAI : <?php echo $jadwal['partai']." (".$jadwal['gelanggang'].")"; ?></td>
    </tr>
    <tr class="text-center">
      <td colspan="9" style="font-size: 28px; font-weight: bold;"><?php echo $jadwal['kelas']." (".$jadwal['babak'].")"; ?></td>
    </tr>
    <tr>
      <td colspan="9"></td>
    </tr>
    <tr class="text-center">
      <td colspan="4" bgcolor="black" style="color: white;font-weight: bold"><p><?php echo $jadwal['nm_merah']; ?></p></td>
      <td>&nbsp;</td>

      <td colspan="4" bgcolor="black" style="color: white; font-weight: bold"><p><?php echo $jadwal['nm_biru']; ?></p></td>
    </tr>
    <tr class="text-center">
      <td colspan="4" bgcolor="white" style="color: black; font-weight: bold"><p><?php echo $jadwal['kontingen_merah']; ?></p></td>
      <td>&nbsp;</td>
      
      <td colspan="4" bgcolor="white" style="color: black; font-weight: bold"><p><?php echo $jadwal['kontingen_biru']; ?></p></td>
    </tr>
<tr class="text-center">
	<td colspan="9" bgcolor="#14B932" style="font-size: 20px; font-weight: bold; color: white">RONDE I</td>
</tr>
		<tr class="text-center" style="font-size: 300px">
			<td rowspan="7" colspan="4"

			<?php
				//juri 1 merah RONDE 1
	      		if($nilaijuri1babak1merah[0] > $nilaijuri1babak1biru[0]) {
	      			echo "<td bgcolor=yellow><font color=black>".$nilaijuri1babak1merah[0]."</bgcolor=yellow></font></td>";
	      		} else {
	      			echo "<td bgcolor=yellow><font color=black>".$nilaijuri1babak1merah[0]."</bgcolor=yellow></font></td>";
	      		}

			?></td></tr>
	      
	      <tr class="text-center" style="font-size: 300px">
			<td rowspan="6" colspan="1"

	      <tr class="text-center" style="font-size: 300px">
			<td rowspan="6" colspan="4"

	     	

	     	<?php
				//juri 1 biru RONDE 1
	      		if($nilaijuri1babak1biru[0] > $nilaijuri1babak1merah[0]) {
	      			echo "<td bgcolor=blue><font color=white>".$nilaijuri1babak1biru[0]."</font></td>";
	      		} else {
	      			echo "<td bgcolor=blue><font color=white>".$nilaijuri1babak1biru[0]."</td>";
	      		}

			?>
		</td>

	    </tr>
   		<tr>
    		<td colspan="9"></td></tr>
	    
	    <tr>
    		<td colspan="9"></td>
   		</tr>
   		<tr>
    		<td colspan="9"></td>
   		</tr>
   		<tr>
    		<td colspan="9"></td>
   		</tr>
   		<tr>
    		<td colspan="9"></td>
   		</tr>
   		</tr>
   		<tr>
    		<td colspan="9"style="color: white; font-size: 60px;">----------------------------------------------------</td>
   		</tr>
   	
    <tr class="text-center">
      <td colspan="9" style="font-size: 28px; font-weight: bold;">PARTAI : <?php echo $jadwal['partai']." (".$jadwal['gelanggang'].")"; ?></td>
    </tr>
    <tr class="text-center">
      <td colspan="9" style="font-size: 28px; font-weight: bold;"><?php echo $jadwal['kelas']." (".$jadwal['babak'].")"; ?></td>
    </tr>
    <tr>
      <td colspan="9"></td>
    </tr>
    <tr class="text-center">
      <td colspan="4" bgcolor="black" style="color: white;font-weight: bold"><p><?php echo $jadwal['nm_merah']; ?></p></td>
      <td>&nbsp;</td>

      <td colspan="4" bgcolor="black" style="color: white; font-weight: bold"><p><?php echo $jadwal['nm_biru']; ?></p></td>
    </tr>
    <tr class="text-center">
      <td colspan="4" bgcolor="white" style="color: black; font-weight: bold"><p><?php echo $jadwal['kontingen_merah']; ?></p></td>
      <td>&nbsp;</td>
      
      <td colspan="4" bgcolor="white" style="color: black; font-weight: bold"><p><?php echo $jadwal['kontingen_biru']; ?></p></td>
    </tr>

<tr class="text-center">
	<td colspan="9" bgcolor="#14B932" style="font-size: 20px; font-weight: bold; color: white;">RONDE II</td>

	    <tr class="text-center" style="font-size: 300px">
			<td rowspan="7" colspan="4"
	    	<?php
				//juri 1 merah RONDE 2
	      		if($nilaijuri1babak2merah[0] > $nilaijuri1babak2biru[0]) {
	      			echo "<td bgcolor=yellow><font color=black>".$nilaijuri1babak2merah[0]."</font></td>";
	      		} else {
	      			echo "<td bgcolor=yellow><font color=black>".$nilaijuri1babak2merah[0]."</td>";
	      		}

			?></td></tr>

	       <tr class="text-center" style="font-size: 300px">
			<td rowspan="6" colspan="1"

	      <tr class="text-center" style="font-size: 300px">
			<td rowspan="6" colspan="4"
	     	<?php
				//juri 1 biru RONDE 2
	      		if($nilaijuri1babak2biru[0] > $nilaijuri1babak2merah[0]) {
	      			echo "<td bgcolor=blue><font color=white>".$nilaijuri1babak2biru[0]."</font></td>";
	      		} else {
	      			echo "<td bgcolor=blue><font color=white>".$nilaijuri1babak2biru[0]."</td>";
	      		}

			?></td>

	    </tr>

<tr>
    		<td colspan="9"></td></tr>
	    
	    <tr>
    		<td colspan="9"></td>
   		</tr>
   		<tr>
    		<td colspan="9"></td>
   		</tr>
   		<tr>
    		<td colspan="9"></td>
   		</tr>
   		<tr>
    		<td colspan="9"></td>
   		</tr>
   		</tr>
   		<tr>
    		<td colspan="9"style="color: white; font-size: 60px;">----------------------------------------------------</td>
   		</tr>

    <tr class="text-center">
      <td colspan="9" style="font-size: 28px; font-weight: bold;">PARTAI : <?php echo $jadwal['partai']." (".$jadwal['gelanggang'].")"; ?></td>
    </tr>
    <tr class="text-center">
      <td colspan="9" style="font-size: 28px; font-weight: bold;"><?php echo $jadwal['kelas']." (".$jadwal['babak'].")"; ?></td>
    </tr>
    <tr>
      <td colspan="9"></td>
    </tr>
    <tr class="text-center">
      <td colspan="4" bgcolor="black" style="color: white;font-weight: bold"><p><?php echo $jadwal['nm_merah']; ?></p></td>
      <td>&nbsp;</td>

      <td colspan="4" bgcolor="black" style="color: white; font-weight: bold"><p><?php echo $jadwal['nm_biru']; ?></p></td>
    </tr>
    <tr class="text-center">
      <td colspan="4" bgcolor="white" style="color: black; font-weight: bold"><p><?php echo $jadwal['kontingen_merah']; ?></p></td>
      <td>&nbsp;</td>
      
      <td colspan="4" bgcolor="white" style="color: black; font-weight: bold"><p><?php echo $jadwal['kontingen_biru']; ?></p></td>
    </tr>

<tr class="text-center">
	<td colspan="9" bgcolor="#14B932" style="font-size: 20px; font-weight: bold; color: white;">TAMBAHAN</td>


	    
	    <tr class="text-center" style="font-size: 300px">
			<td rowspan="7" colspan="4" 	
	     	<?php
				//juri 1 merah RONDE 3
	      		if($nilaijuri1babak3merah[0] > $nilaijuri1babak3biru[0]) {
	      			echo "<td bgcolor=yellow><font color=black>".$nilaijuri1babak3merah[0]."</font></td>";
	      		} else {
	      			echo "<td bgcolor=yellow><font color=black>".$nilaijuri1babak3merah[0]."</td>";
	      		}

			?></td></tr>

	      <tr class="text-center" style="font-size: 300px">
			<td rowspan="6" colspan="1"
			<tr class="text-center" style="font-size: 300px">
			<td rowspan="6" colspan="4"
	      	<?php
				//juri 1 biru RONDE 3
	      		if($nilaijuri1babak3biru[0] > $nilaijuri1babak3merah[0]) {
	      			echo "<td bgcolor=blue><font color=white>".$nilaijuri1babak3biru[0]."</font></td>";
	      		} else {
	      			echo "<td bgcolor=blue><font color=white>".$nilaijuri1babak3biru[0]."</td>";
	      		}

			?></td></tr>
	    </tr>

	    <tr>
    		<td colspan="9"></td></tr>
	    
	    <tr>
    		<td colspan="9"></td>
   		</tr>
   		<tr>
    		<td colspan="9"></td>
   		</tr>
   		<tr>
    		<td colspan="9"></td>
   		</tr>
   		<tr>
    		<td colspan="9"></td>
   		</tr>
   		</tr>
   		<tr>
    		<td colspan="9"style="color: white; font-size: 200px;">-----------------</td>
   		</tr>
   		<tr class="text-center">
      <td colspan="9" style="font-size: 28px; font-weight: bold;">PARTAI : <?php echo $jadwal['partai']." (".$jadwal['gelanggang'].")"; ?></td>
    </tr>
    <tr class="text-center">
      <td colspan="9" style="font-size: 28px; font-weight: bold;"><?php echo $jadwal['kelas']." (".$jadwal['babak'].")"; ?></td>
    </tr>
    <tr>
      <td colspan="9"></td>
    </tr>
    <tr class="text-center">
      <td colspan="4" bgcolor="black" style="color: white;font-weight: bold"><p><?php echo $jadwal['nm_merah']; ?></p></td>
      <td>&nbsp;</td>

      <td colspan="4" bgcolor="black" style="color: white; font-weight: bold"><p><?php echo $jadwal['nm_biru']; ?></p></td>
    </tr>
    <tr class="text-center">
      <td colspan="4" bgcolor="white" style="color: black; font-weight: bold"><p><?php echo $jadwal['kontingen_merah']; ?></p></td>
      <td>&nbsp;</td>
      
      <td colspan="4" bgcolor="white" style="color: black; font-weight: bold"><p><?php echo $jadwal['kontingen_biru']; ?></p></td>
    </tr>

	    <tr class="text-center" bgcolor="#FF8000" style="font-size: 20px; color: white;">
	    	<td>Ronde I</td>
	    	<td>Ronde II</td>
	    	<td>Tambahan</td>
	    	<td bgcolor="#14B932">TOTAL</td>
	    	<td bgcolor="white"></td>
	    	<td bgcolor="#14B932">TOTAL</td>
	    	<td>Tambahan</td>
	    	<td>Ronde II</td>
	    	<td>Ronde I</td>
	    </tr>

	    <tr class="text-center" bgcolor="#FF8000" style="font-size: 20px; color: white;">
	    	<td>
		    	<?php
		    		$totalmerahsatu = ($nilaijuri1babak1merah[0])/1;
		    		echo $totalmerahsatu;
		    	?>
	    	</td>
	    	<td>
	    		<?php
	    			$totalmerahdua = ($nilaijuri1babak2merah[0])/1;
	    			echo $totalmerahdua;
	    		?>
	    	</td>
	    	<td>
	    		<?php
		    		$totalmerahtiga = ($nilaijuri1babak3merah[0])/1;
		    		echo $totalmerahtiga;
	    		?>
	    	</td>
	    	<td bgcolor="#14B932">
	    		<?php
	    			$skorakhirmerah = $nilaijuri1babak1merah[0] + $nilaijuri1babak2merah[0] + $nilaijuri1babak3merah[0];
	    			echo $skorakhirmerah;
	    		?>
	    	</td>
	    	<td bgcolor="white"></td>
	    	<td bgcolor="#14B932">
	    		<?php
	    			$skorakhirbiru = $nilaijuri1babak1biru[0] + $nilaijuri1babak2biru[0] + $nilaijuri1babak3biru[0];
	    			echo $skorakhirbiru;
	    		?>
	    	</td>
	    	<td>
	    		<?php
	    			$totalbirutiga = ($nilaijuri1babak3biru[0])/1;
	    			echo $totalbirutiga;
	    		?>
	    	</td>
	    	<td>
	    		<?php
		    		$totalbirudua = ($nilaijuri1babak2biru[0])/1;
		    		echo $totalbirudua;
	    		?>
	    	</td>
	    	<td>
	    		<?php
	    			$totalbirusatu = ($nilaijuri1babak1biru[0])/1;
	    			echo $totalbirusatu;
	    		?>
	    	</td>
	    </tr>

   		 <tr>
    		<td colspan="9"></td>
    	</tr>

	    <?php
	    	//TOTAL ROUND 1
	    	$totalmerahronde1 = ($nilaijuri1babak1merah[0]) / 1;

	    	$totalbiruronde1 = ($nilaijuri1babak1biru[0]) / 1;

	    	//TOTAL ROUND 2
	    	$totalmerahronde2 = ($nilaijuri1babak2merah[0]) / 1;

	    	$totalbiruronde2 = ($nilaijuri1babak2biru[0]) / 1;

	    	//TOTAL ROUND TAMBAHAN
	    	$totalmerahronde3 = ($nilaijuri1babak3merah[0]) / 1;

	    	$totalbiruronde3 = ($nilaijuri1babak3biru[0]) / 1;
	    	$kuning = 0;
	   		$biru = 0;
	    ?>
    	
    <tr class="text-center">
    	<td colspan="4"></td>
    	<td bgcolor="#FF8000" style="font-size: 20px; color: white;">PEMENANG</td>
    	<td colspan="4"></td>
    </tr>
    <tr class="text-center" bgcolor="#FF8000" style="font-size: 20px; color: white;">
    	<td colspan="3">Ronde I</td>
    	<td colspan="3">Ronde II</td>
    	<td colspan="3">Ronde Tambahan</td>
    </tr>
    <tr class="text-center" bgcolor="grey" style="font-size: 24px; color: white;">
    	<td colspan="3">
    		<?php
    				if($totalmerahronde1 > $totalbiruronde1) {
    					echo "<font color=yellow>KUNING</font>";
    					$kuning = $kuning + 1;
    				} else if ($totalmerahronde1 < $totalbiruronde1) {
    					echo "<font color=blue>BIRU</font>";
    					$biru = $biru + 1;
    				} else if ($totalmerahronde3 == 0	 && $totalbiruronde3 == 0) {
    					echo "---";
    				} else {
    					echo "SERI";
    					$kuning = $kuning + 1;
    					$biru = $biru + 1;
    				}

    				if($totalmerahronde1 >= 200) {
    					echo " <font color=yellow>(MUTLAK)</font>";
    					$kuning = $kuning + 1;
    				} elseif ($totalbiruronde1 >= 200) {
    					echo " <font color=blue>(MUTLAK)</font>";
    					$biru = $biru + 1;
    				}
    		?>
    	</td>

    	<td colspan="3">
    		<?php
    				if($totalmerahronde2 > $totalbiruronde2) {
    					echo "<font color=yellow>KUNING</font>";
    					$kuning = $kuning + 1;
    				} else if ($totalmerahronde2 < $totalbiruronde2) {
    					echo "<font color=blue>BIRU</font>";
    					$biru = $biru + 1;
    				} else if ($totalmerahronde3 == 0	 && $totalbiruronde3 == 0) {
    					echo "---";
    				} else {
    					echo "SERI";
    					$kuning = $kuning + 1;
    					$biru = $biru + 1;
    				}

    				if($totalmerahronde2 >= 200) {
    					echo " <font color=yellow>(MUTLAK)</font>";
    					$kuning = $kuning + 1;
    				} elseif ($totalbiruronde2 >= 200) {
    					echo " <font color=blue>(MUTLAK)</font>";
    					$biru = $biru + 1;
    				}
    		?>
    	</td>

    	<td colspan="3">
    		<?php
    				if($totalmerahronde3 > $totalbiruronde3) {
    					echo "<font color=yellow>KUNING</font>";
    					$kuning = $kuning + 1;
    				} else if ($totalmerahronde3 < $totalbiruronde3) {
    					echo "<font color=blue>BIRU</font>";
    					$biru = $biru + 1;
    				} else if ($totalmerahronde3 == 0 && $totalbiruronde3 == 0) {
    					echo "---";
    				} else {
    					echo "SERI";
    					$kuning = $kuning + 1;
    					$biru = $biru + 1;
    				}

    				if($totalmerahronde3 >= 200) {
    					echo " <font color=yellow>(MUTLAK)</font>";
    					$kuning = $kuning + 1;
    				} elseif ($totalbiruronde3 >= 200) {
    					echo " <font color=blue>(MUTLAK)</font>";
    					$biru = $biru + 1;
    				}
    			?>
    	</td>
    	<?php
			//echo $kuning; echo $biru;
			if ($kuning > $biru) {
				$pemenang = $jadwal['nm_merah'];
			} else {
				$pemenang = $jadwal['nm_biru'];
			}
			//echo $pemenang;
		?>
    </tr>
    <tr>
    		
    		<td colspan="9"style="color: white; font-size: 200px;">-----------------</td>
   		</tr>
	</table>
</div>
</div>
<div class="table-responsive">
	<table class="table">
		<tr>
			<td class="text-left">
				<a href="index.php" class="btn btn-warning" role="button">KEMBALI</a>
			</td>
			<td class="text-right">
				<form name="SetorNilai" id="SetorNilai" method="POST" action="setor_nilai.php" onclick="return cek_selesai();">
					<input type="hidden" name="skorakhirmerah" id="skorakhirmerah" value="<?php echo $skorakhirmerah; ?>">
					<input type="hidden" name="skorakhirbiru" id="skorakhirbiru" value="<?php echo $skorakhirbiru; ?>">
					<input type="hidden" name="pemenang" id="pemenang" value="<?php echo $pemenang; ?>">
					<input type="hidden" name="id_partai" id="id_partai" value="<?php echo $id_partai; ?>">
					<input type="submit" class="btn btn-info" value="SELESAI">
				</form>
			</td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	
	setInterval(function(){
		$.ajax({
            url: 'http://192.168.83.162/tapaksuci/nilai/api.php', 
            data : {'a' : 'get_data_view_tanding', 'id_partai': <?=$_GET["id_partai"]?>},
            type: "GET",
            success: function(obj){
            	$('.content_penilaian').html(obj);

            	console.log('Request ... Done');
            }
        });
	}, 2000);

</script>
</body>
</html>


