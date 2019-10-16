<?php
	include "headerPemeriksa.php";
	include_once "conn.php";

	$sql = "
			delete from tb_lpj
			WHERE npsn = ? AND tahun = ? AND tahap = ? AND status = ? and (path_file is null or path_file = ?)
			";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sssss", $p1, $p2, $p3, $p4, $p5);
	$p1 = $_GET["npsn"];
	$p2 = $_GET["tahun"];
	$p3 = $_GET["tahap"];
	$p4 = "Upload Ulang";
	$p5 = "";
	$ps->execute();

	$sql = "
			update tb_lpj set status = 'Proses'
			WHERE npsn = ? AND tahun = ? AND tahap = ? AND status = ?
			";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
	$p1 = $_GET["npsn"];
	$p2 = $_GET["tahun"];
	$p3 = $_GET["tahap"];
	$p4 = "Upload Ulang";
	$ps->execute();
	
	$sql = "
			SELECT
				tb_lpj.id_lampiran,
				tb_lpj.bulan,
				tb_lampiran.nama,
				tb_lampiran.keterangan,
				if(tb_lpj.bulan = 0, '', concat('Bulan ', tb_lpj.bulan)) as bln
			FROM
				tb_lpj
				INNER JOIN tb_lampiran ON tb_lampiran.id = tb_lpj.id_lampiran 
			WHERE
				tb_lpj.npsn = ? 
				AND tb_lpj.tahun = ? 
				AND tb_lpj.tahap = ?
			ORDER BY
				tb_lpj.id_lampiran
			";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_GET["npsn"];
	$p2 = $_GET["tahun"];
	$p3 = $_GET["tahap"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$lampiran = array();
		while($row = $hasil->fetch_assoc()){
			$i1 = $row["id_lampiran"];
			if ($i1 < 10) $i1 = "0".$i1;
			$i2 = $row["bulan"];
			if ($i2 < 10) $i2 = "0".$i2;
			$lampiran[$i1.$i2] = $row["nama"].": ".$row["keterangan"]." ".$row["bln"];
		}
	}
	else{
		echo "<script> location.replace('index.php'); </script>";
		exit();
	}

	$sql = "
			select angka from (
				select 1 as angka union
				select 2 as angka union
				select 3 as angka union
				select 4 as angka union
				select 5 as angka union
				select 6 as angka union
				select 7 as angka union
				select 8 as angka union
				select 9 as angka union
				select 10 as angka union
				select 11 as angka union
				select 12 as angka
			) as a
			where angka not in (
				SELECT bulan 
				FROM tb_lpj 
				WHERE npsn = ? AND tahun = ? AND tahap = ? AND id_lampiran = 19
			)
			";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_GET["npsn"];
	$p2 = $_GET["tahun"];
	$p3 = $_GET["tahap"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$blnK7 = array();
		while($row = $hasil->fetch_assoc()){
			$indexBulan = $row["angka"]-1;
			$blnK7[$row["angka"]] = $bulan[$indexBulan];
		}
	}
	else{
		echo "<script> location.replace('index.php'); </script>";
		exit();
	}
	
	$ps->close();
	$conn->close();

	
?>

<div id="main">
<div id="isiMain">
	<div class="loadingGif" id="loadingDiv">
			<img src="picts/loading.gif">
	</div>
	<form>
		<div class="baris">
			<div class="kolom1">
				<label class="styleLabel">Lampiran yang bermasalah</label>
			</div>
			<div class="kolom2">
				<select class="styleInput" id="optLampiran">
					<option value="0">Pilih Lampiran</option>
					<?php 
						foreach($lampiran as $key => $keyVal){
							echo "<option ";
							echo "data-idLampiran='".(int)substr($key, 0, 2)."' ";
							echo "data-bulan='".(int)substr($key, 2, 2)."' ";
							echo "value='".$key."'>".$keyVal."</option>";
						}
					?>
				</select>
			</div>
			<div class="kolom3">
				<input class="styleButton  btnFormUlang" type="button" value="Tambahkan" id="btnTambah1">
			</div>
		</div>

		<div class="baris">
			<div class="kolom1">
				<label class="styleLabel">Lampiran FORMAT BOS K7 yang kurang</label>
			</div>
			<div class="kolom2">
				<select class="styleInput" id="optBulan">
					<option value="0">Pilih Lampiran</option>
					<?php 
						foreach($blnK7 as $key => $keyVal){
							echo "<option value='".$key."'>".$keyVal."</option>";
						}
					?>
				</select>
			</div>
			<div class="kolom3">
				<input class="styleButton btnFormUlang" type="button" value="Tambahkan" id="btnTambah2">
			</div>
		</div>
		<div class="baris">
			<div id="kolom1" style="width: 49%; float: left;">
				<button type="button" title="Hapus Data Lampiran Bermasalah" id="btnClear1" class="styleButton"
					style="width: auto; height: auto; margin-bottom: 5px; background-color: transparent;">
					<img src="picts/hapus.png" width="18">
				</button><br>
				<textarea id="daftarMasalah" style="width: 100%; height: 400px; border-radius: 4px; border: 1px solid gray; padding: 10px;" readonly="readonly">
				</textarea>	
			</div>
			<div id="kolom2" style="width: 49%; float: right;">
				<button type="button" title="Hapus Data Lampiran BOS K-7 yang Kurang" id="btnClear2" class="styleButton"
				style="width: auto; height: auto; margin-bottom: 5px; background-color: transparent;">
					<img src="picts/hapus.png" width="18">
				</button><br>
				<textarea id="daftarKekurangan" style="width: 100%;height: 400px; border-radius: 4px; border: 1px solid gray; padding: 10px;" readonly="readonly">
				</textarea>
			</div>
			<div class="baris">
				<input class="styleButton" type="button" value="Selesai" id="btnSelesai">
			</div>
		</div>
	</form>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#mn2").css({
			"background-color" : "green",
			"color" : "white"
		});

		$(document).on("mouseover", "#optLampiran", function(){
			$(this).attr("title", $("#optLampiran option:selected").text());
		});

		$("#daftarMasalah").html("Lampiran BOS yang bermasalah:");
		$("#daftarKekurangan").html("Lampiran Format BOS-K7 (KUITANSI/BUKTI PEMBAYARAN) yang kurang:");

		$(document).on("click", "#btnTambah1", function(){
			if ($("#optLampiran").val() == "0") return;
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	var masalah;
			    	masalah = $("#daftarMasalah").val() + "\n- " + $("#optLampiran option:selected").text();			    	
			    	$("#daftarMasalah").val(masalah);
			    	$("#optLampiran option:selected").hide();
			    	$("#optLampiran").val("0");
			        $("#loadingDiv").css("display","none");
			    }
			};
			xmlhttp.open("POST", "prosesUploadUlang1.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("npsn=" + "<?php echo $_GET['npsn']; ?>" + 
						"&tahun=" + "<?php echo $_GET['tahun']; ?>" + 
						"&tahap=" + "<?php echo $_GET['tahap']; ?>" +
						"&idLampiran=" +$("#optLampiran option:selected").attr("data-idLampiran") +
						"&bulan=" + $("#optLampiran option:selected").attr("data-bulan")
						);
		});

		$(document).on("click", "#btnTambah2", function(){
			if ($("#optBulan").val() == "0") return;
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	var masalah;
			    	masalah = $("#daftarKekurangan").val() + "\n- Lampiran BOS-K7 Bulan " + $("#optBulan option:selected").text();			    	
			    	$("#daftarKekurangan").val(masalah);
			    	$("#optBulan option:selected").hide();
			    	$("#optBulan").val("0");
			        $("#loadingDiv").css("display","none");
			    }
			};
			xmlhttp.open("POST", "prosesUploadUlang2.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("npsn=" + "<?php echo $_GET['npsn']; ?>" + 
						"&tahun=" + "<?php echo $_GET['tahun']; ?>" + 
						"&tahap=" + "<?php echo $_GET['tahap']; ?>" +
						"&idLampiran=19" +
						"&bulan=" + $("#optBulan").val()
						);
		});

		$(document).on("click", "#btnClear1", function(){
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$("#daftarMasalah").val("Lampiran BOS yang bermasalah:");
					$("#optLampiran option").show();
			        $("#loadingDiv").css("display","none");
			    }
			};
			xmlhttp.open("POST", "clearUploadUlang1.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("npsn=" + "<?php echo $_GET['npsn']; ?>" + 
						"&tahun=" + "<?php echo $_GET['tahun']; ?>" + 
						"&tahap=" + "<?php echo $_GET['tahap']; ?>"
						);
		});

		$(document).on("click", "#btnClear2", function(){
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$("#daftarKekurangan").val("Lampiran Format BOS-K7 (KUITANSI/BUKTI PEMBAYARAN) yang kurang:");
					$("#optBulan option").show();
			        $("#loadingDiv").css("display","none");
			    }
			};
			xmlhttp.open("POST", "clearUploadUlang2.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("npsn=" + "<?php echo $_GET['npsn']; ?>" + 
						"&tahun=" + "<?php echo $_GET['tahun']; ?>" + 
						"&tahap=" + "<?php echo $_GET['tahap']; ?>"
						);
		});

		function updatePenilaian(){
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$("#loadingDiv").css("display","none");
					location.href = "penilaianLPJ.php";
				}
			};
			xmlhttp.open("POST", "updateStatusPenilaian.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("nilai=Upload Ulang" +
						"&npsn=" + "<?php echo $_GET['npsn']; ?>" + 
						"&tahun=" + "<?php echo $_GET['tahun']; ?>" + 
						"&tahap=" + "<?php echo $_GET['tahap']; ?>"
						);
		}


		$(document).on("click", "#btnSelesai", function(){
			if (
					$("#daftarMasalah").val() == "Lampiran BOS yang bermasalah:" && 
					$("#daftarKekurangan").val() == "Lampiran Format BOS-K7 (KUITANSI/BUKTI PEMBAYARAN) yang kurang:"
				){
				swal("Lampiran yang Bermasalah/Kurang Belum Dipilih!!!", "Silakan pilih lampiran yang bermasalah", "error");
				return;
			}
			swal({
				  title: 'Apakah Anda yakin ingin melanjutkan?',
				  text: "Status LPJ akan diubah menjadi 'Upload Ulang'.",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya!',
				  cancelButtonText: 'Tidak'
				}).then((result) => {
				  if (result.value) {
					updatePenilaian();
				  }
				});
		});

	});
</script>


<?php 
	include "footer.php";
?>