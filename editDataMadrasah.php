<?php
	include "headerOperator.php";
	include_once "conn.php";
	
	$jenjang = array("Madrasah Ibtidaiyah","Madrasah Tsanawiyah","Madrasah Aliyah");
	$status = array("Negeri","Swasta");
	
	$kec = array();
	$hasil = $conn->query("select id, name from tb_kecamatan order by name");
	while($row = $hasil->fetch_assoc()) $kec[$row["id"]] = $row["name"];
	
	$ps = $conn->stmt_init();
	$ps->prepare("select * from tb_madrasah where npsn = ?");
	$ps->bind_param("s", $npsn);
	$npsn = $_SESSION["npsn"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$rowHasil = $hasil->fetch_assoc();
	}
	else{
		echo "<script> location.replace('index.php'); </script>";
		exit();
	}
	
	$kel = array();
	$ps = $conn->stmt_init();
	$ps->prepare("select id, name from tb_kelurahan where district_id = ?  order by name");
	$ps->bind_param("s", $id);
	$id = $rowHasil["id_kec"];
	$ps->execute();
	$hasil = $ps->get_result();
	while($row = $hasil->fetch_assoc()) $kel[$row["id"]] = $row["name"];
	
	
	$ps->close();
	$conn->close();
?>

<div id="main">
<div id="isiDataMadrasah">
	<div class="loadingGif" id="loadingDiv">
			<img src="picts/loading.gif">
	</div>
	<form method="post" action="simpanDataMadrasah.php">
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">NPSN</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtNpsn" name="txtNpsn" value="<?php echo $rowHasil["npsn"];?>" readonly="readonly">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">NSM</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtNsm" name="txtNsm" value="<?php echo $rowHasil["nsm"];?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Jenjang</label>
			</div>
			<div class="kolomDM2">
				<select class="styleInput" id="optJenjang" name="optJenjang">
					<?php 
						foreach($jenjang as $val){
							if ($val == $rowHasil["jenjang"])
								echo "<option value='".$val."' selected='selected'>".$val."</option>";
							else
								echo "<option value='".$val."'>".$val."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Status</label>
			</div>
			<div class="kolomDM2">
				<select class="styleInput" id="optStatus" name="optStatus">
					<?php 
						foreach($status as $val){
							if ($val == $rowHasil["status"])
								echo "<option value='".$val."' selected='selected'>".$val."</option>";
							else
								echo "<option value='".$val."'>".$val."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Nama Madrasah</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtNama" name="txtNama" value="<?php echo $rowHasil["nama"];?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Alamat</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtAlamat" name="txtAlamat" value="<?php echo $rowHasil["alamat"];?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Nama Kepala Sekolah</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtNamaKepsek" name="txtNamaKepsek" value="<?php echo $rowHasil["nama_kepsek"];?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Nama Bendahara</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtNamaBendahara" name="txtNamaBendahara" value="<?php echo $rowHasil["nama_bendahara"];?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">No. Telp Madrasah</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtNoTelp" name="txtNoTelp" value="<?php echo $rowHasil["no_telp"];?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Kecamatan</label>
			</div>
			<div class="kolomDM2" >
				<select class="styleInput" id="optKec" name="optKec">
					<option value="0">PILIH</option>
					<?php 
						foreach($kec as $key => $keyVal){
							if ($key == $rowHasil["id_kec"])
								echo "<option value='".$key."' selected='selected'>".$keyVal."</option>";
							else
								echo "<option value='".$key."'>".$keyVal."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Kelurahan</label>
			</div>
			<div class="kolomDM2">
				<select class="styleInput" id="optKel" name="optKel">
					<option value="0">PILIH</option>
					<?php 
						foreach($kel as $key => $keyVal){
							if ($key == $rowHasil["id_kel"])
								echo "<option value='".$key."' selected='selected'>".$keyVal."</option>";
							else
								echo "<option value='".$key."'>".$keyVal."</option>";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="baris" style="box-sizing: border-box;">
			<input class="styleButton" style="font-size: 120%; margin-top: 10px; width:100%; box-sizing: border-box; box-shadow: initial;" type="submit" value="Simpan Data Madrasah" name="btnSimpan">
		</div>
		
	</form>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#mn3").css({
			"background-color" : "green",
			"color" : "white"
		});
		
		$("#optKec").change(function(){
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			        $("#optKel").html(this.responseText);
			        $("#loadingDiv").css("display","none");
			    }
			};
			xmlhttp.open("POST", "namaKelurahan.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("idKec=" + $("#optKec").val());
		});
	});
</script>


<?php 
	include "footer.php";
?>