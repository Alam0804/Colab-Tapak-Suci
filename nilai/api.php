<?php 

include "../backend/includes/connection.php";

// REQUIRED 
// agar bisa di akses oleh android API
header('Access-Control-Allow-Origin: *');

// get ACTION 
$param = isset($_GET['a']) ? $_GET['a'] : ''; 

if("" != $param)
{
	switch($param)
	{

		case "ceksettingan":

			if($username !== $_GET['username'])
			{
				echo json_encode(['status' => 'error', 'messages' => 'Settingan username salah silahkan dicoba kembali']);

				return false;
			}

			if($password !== $_GET['password'])
			{
				echo json_encode(['status' => 'error', 'messages' => 'Settingan Password salah silahkan dicoba kembali']);

				return false;
			}

			if($nama_database !== $_GET['database'])
			{
				echo json_encode(['status' => 'error', 'messages' => 'Settingan Database salah silahkan dicoba kembali']);

				return false;
			}

			echo json_encode(['status' => 'success']);

		break;
		case "partai":
			echo partai();
		break;

		case "juri":
			echo juri();
		break;

		case "login":


			$id_juri = $_GET['id'];
			$password = md5($_GET['password']);

			$sql = "SELECT * FROM wasit_juri WHERE id_juri='{$id_juri}' and pass_juri='{$password}'";

			$exec = mysqli_query($koneksi,$sql);

			$row = mysqli_fetch_row($exec);
			
			if($row){
				echo json_encode(['status' => 'success']);
			}else{
				echo json_encode(['status' => 'error']);
			}
		break;
		case "jadwal":

			$id = $_GET['id_partai'];

			$sql = "SELECT * FROM jadwal_tanding WHERE id_partai='{$id}'";

			$exec = mysqli_query($koneksi,$sql);

			$row = mysqli_fetch_assoc($exec);

			if($row)
				echo json_encode($row);
			else
				echo json_encode([]);
		break;
		case "history":

			$id_juri 	= $_GET['id_juri'];
			$id_jadwal 	= $_GET['id_jadwal'];
			$sudut 		= $_GET['sudut'];
			$babak 		= $_GET['babak'];
			
			$sql = mysqli_query($koneksi,"SELECT nilai_tanding.*, w.nm_juri FROM nilai_tanding inner join wasit_juri w on w.id_juri=nilai_tanding.id_juri  WHERE id_jadwal='{$id_jadwal}' AND nilai_tanding.id_juri='{$id_juri}' AND sudut='{$sudut}' AND babak='{$babak}' ORDER BY id_nilai DESC");

			$key= 0;
			$data = [];
			while($result = mysqli_fetch_array($sql))
			{
				$data[$key] = $result;
				$key++;
			}

			if($data)
				echo json_encode($data);
			else
				echo json_encode([]);
		break;
		case "submit_skor":
			
			$id_jadwal 	= $_POST['id_jadwal'];
			$id_juri 	= $_POST['id_juri'];
			$button 	= $_POST['button'];
			$nilai		= $_POST['nilai'];
			$sudut 		= $_POST['sudut'];
			$babak 		= $_POST['babak'];
			
			// INSERT INTO `nilai_tanding` (`id_nilai`, `id_jadwal`, `id_juri`, `button`, `nilai`, `sudut`, `babak`) VALUES (NULL, 'idpartaisaatlogin', 'juriyglogin', '1+1', '2', 'MERAH/BIRU', 'babakygaktif');
			$result = mysqli_query($koneksi,"INSERT INTO nilai_tanding (id_nilai, id_jadwal, id_juri, button, nilai, sudut, babak) VALUES (NULL, '{$id_jadwal}','{$id_juri}','{$button}',{$nilai}, '{$sudut}','{$babak}')");

			if($result)
				echo json_encode(['message' => 'success']);
			else
				echo json_encode(['message' => 'error']);
		break;
		case "delete_nilai":
			// get id_nilai
			$id_nilai = $_GET['id_nilai'];

			$result = mysqli_query($koneksi,"DELETE FROM nilai_tanding WHERE id_nilai={$id_nilai}");

			if($result)
				echo json_encode(['status' => 'success']);
			else
				echo json_encode(['status' => 'error']);
		break;
		case "get_data_view_tanding":
			get_data_view_tanding();
		break;
		case "get_data_view_monitoring":
			get_data_view_monitoring();
		break;
	}
}

/**
 * [partai description]
 * @return [type] [description]
 */
function partai()
{
	include "../backend/includes/connection.php";

	$sql = "SELECT * FROM jadwal_tanding WHERE status='-' AND aktif='1' ORDER BY (0 + partai) ASC";

	$exec = mysqli_query($koneksi,$sql);

	$result = [];
	
	$key = 0;
	while($item = mysqli_fetch_array($exec)):
		$result[$key]['id'] = $item['id_partai'];
		$result[$key]['name'] = $item['partai'];
		$result[$key]['kelas'] = $item['kelas'];
		$result[$key]['gelanggang'] = $item['gelanggang'];
		$key++;
	endwhile;

	return json_encode($result);
}

function juri()
{
	include "../backend/includes/connection.php";

	$sql = "SELECT * FROM wasit_juri";

	$exec = mysqli_query($koneksi,$sql);

	$result = [];
	
	$key = 0;
	while($item = mysqli_fetch_array($exec)):
		$result[$key]['id'] = $item['id_juri'];
		$result[$key]['name'] = $item['nm_juri'];
		$key++;
	endwhile;

	return json_encode($result);
}

/**
 * [get_data_view_monitoring description]
 * @return [type] [description]
 */
function get_data_view_monitoring()
{
	include "../backend/includes/connection.php";
	//dapatkan ID jadwal pertandingan
	$id_partai = mysqli_real_escape_string($koneksi,$_GET["id_partai"]);

	ob_start();
	?>
		
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
	<?php 
	
	$out1 = ob_get_contents();

	ob_end_clean();

	echo $out1;
}

/**
 * [get_data_view_tanding description]
 * @return [type] [description]
 */
function get_data_view_tanding()
{
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

	//
	ob_start();
	?>
	
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
    		
    		<td colspan="9"style="color: white; font-size: 300px;">-----------------</td>
   		</tr>

	<?php 

	$out1 = ob_get_contents();

	ob_end_clean();

	echo $out1;
}
?>