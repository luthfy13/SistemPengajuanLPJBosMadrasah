<?php
	include "headerOperator.php";
	include_once "fungsi.php";
	
	if (session_status() == PHP_SESSION_NONE)
		session_start();

	include_once "conn.php";
	$sudah = array();
	$status = array();
	$sudah[0] = "0";
	$status[0] = "0";
	for ($i=1; $i<=19; $i++){
		$sql = "select count(*) as jml, status from tb_lpj where npsn=? and tahun=? and tahap=? and id_lampiran=?
		GROUP BY id_lampiran, status";
		$ps = $conn->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
		$p1 = $_SESSION["npsn"];
		$p2 = $_SESSION["tahun"];
		$p3 = $_SESSION["tahap"];
		$p4 = $i;
		$ps->execute();
		$hasil = $ps->get_result();
		if ($hasil->num_rows > 0){
			$row = $hasil->fetch_assoc();
			$sudah[$i] = $row["jml"];
			$status[$i] = $row["status"];
		}
		else{
			$sudah[$i] = "0";
			$status[$i] = "";	
		}
		
	}

	$hasilPenilaian = "";
	$sql = "select status from tb_penilaian where npsn=? and tahun=? and tahap=?";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_SESSION["npsn"];
	$p2 = $_SESSION["tahun"];
	$p3 = $_SESSION["tahap"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$row = $hasil->fetch_assoc();
		$hasilPenilaian = $row["status"];
	}
	
	$ps->close();
	$conn->close();
?>

<div id="main">
	<div id="isiLPJ">
	<div class="loadingGif" id="loadingDiv">
			<img src="picts/loading.gif">
	</div>
	<label style="
		position: relative;
		top: 40px;
		color:green; 
		font-weight: bold; 
		font-size: 280%; 
		font-family: Tahoma;
		text-shadow: 2px 2px 3px black;"
	>LAMPIRAN BOS</label>
<?php 
	include "form01.php";
	if ($_SESSION["jenjang"] == "Madrasah Ibtidaiyah")
		include "form02.php";
	else if ($_SESSION["jenjang"] == "Madrasah Tsanawiyah")
		include "form03.php";
	else if ($_SESSION["jenjang"] == "Madrasah Aliyah")
		include "form04.php";
	include "form05.php";
	include "form06.php";
	//include "form07.php"; //bukan isian madrasah
	include "form08.php";
	include "form09.php";
	include "form10.php";
	include "form11.php";
	//include "form12.php"; //bukan isian madrasah
?>

<label style="
	position: relative;
	top: 40px;
	color:green; 
	font-weight: bold; 
	font-size: 280%; 
	font-family: Tahoma;
	text-shadow: 2px 2px 3px black;"
>LAMPIRAN KEUANGAN</label>
<?php
	if ($_SESSION["tahap"] == "Tahap I") include "form13.php";
	include "form14.php";
	include "form15.php";
	include "form19.php";
?>
	<br>
	<button id="btnAjukanLPJ" style="width:100%;" class="styleButton">Ajukan LPJ Dana BOS</button>
	</div>
	<div id="sideMenu">
		<div id="sideMenu1" class="isiSideMenu">
			<a href="#uploadForm1" class="navSide">BOS<br>01</a>
		</div>
		<div id="sideMenu2" class="isiSideMenu">
			<a href="#uploadForm2" class="navSide">BOS<br>02</a>
		</div>
		<div id="sideMenu3" class="isiSideMenu">
			<a href="#uploadForm5" class="navSide">BOS<br>03</a>
		</div>
		<div id="sideMenu4" class="isiSideMenu">
			<a href="#uploadForm6" class="navSide">BOS<br>04</a>
		</div>
		<div id="sideMenu5" class="isiSideMenu">
			<a href="#uploadForm8" class="navSide">BOS<br>06</a>
		</div>
		<div id="sideMenu6" class="isiSideMenu">
			<a href="#uploadForm9" class="navSide">BOS<br>07</a>
		</div>
		<div id="sideMenu7" class="isiSideMenu">
			<a href="#uploadForm10" class="navSide">BOS<br>08</a>
		</div>
		<div id="sideMenu8" class="isiSideMenu">
			<a href="#uploadForm11" class="navSide">BOS<br>09</a>
		</div>
	</div>
	<div id="sideMenuKanan">
		<div id="sideMenu9" class="isiSideMenu">
			<a href="#uploadForm13" class="navSide">BOS<br>K1</a>
		</div>
		<div id="sideMenu10" class="isiSideMenu">
			<a href="#uploadForm14" class="navSide">BOS<br>K2</a>
		</div>
		<div id="sideMenu11" class="isiSideMenu">
			<a href="#uploadForm15" class="navSide">BOS<br>K3</a>
		</div>
		<div id="sideMenu12" class="isiSideMenu">
			<a href="#uploadForm19" class="navSide">BOS<br>K7</a>
		</div>
		<div id="sideMenu13" class="isiSideMenu">
			<a href="#header" class="navSide">&#x25B2<br>TOP</a>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

		var hasilPenilaian = "<?php echo $hasilPenilaian; ?>";
		if (hasilPenilaian == "Proses"){
			$(".uploadForm input").attr('disabled', 'disabled');
		}
		
		$("#mn1").css({
			"background-color" : "green",
			"color" : "white"
		});

		function ajukanLPJ(){
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			        if (this.responseText=="Sukses"){
			        	swal('Data Tersimpan', 'Pengajuan LPJ Berhasil!!!', 'success').then(function(){
			        		location.reload();
			        	});
				    }
			        else if (this.responseText=="Sukses Upload Ulang"){
			        	swal('Data Tersimpan', 'Pengajuan Ulang LPJ Berhasil!!!', 'success').then(function(){
			        		location.reload();
				        });
				    }
			        else if (this.responseText=="Pending"){
			        	swal('Data sudah diajukan', 'LPJ dalam proses pemeriksaan!!!', 'success');
				    }
			        else if (this.responseText=="Proses" || this.responseText=="Diterima" || this.responseText=="Ditolak"){
			        	swal('Data sudah diajukan', 'Status LPJ: ' + this.responseText, 'info');
				    }
			        else{
			        	swal('Pengajuan LPJ Gagal! ' + this.responseText, 'Data lampiran belum lengkap!!!', 'error');
				    }
			        $("#loadingDiv").css("display","none");
			    }
			};
			xmlhttp.open("POST", "prosesPengajuanLPJ.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send();
		}

		$(document).on("click", "#btnAjukanLPJ", function(){
			swal({
				  title: 'Apakah Anda yakin ingin mengajukan lampiran-lampiran LPJ ini?',
				  text: "LPJ yang telah diajukan tidak bisa dibatalkan, status lampiran yang telah ter-upload akan berubah menjadi Pending.",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya!',
				  cancelButtonText: 'Tidak'
				}).then((result) => {
				  if (result.value) {
					ajukanLPJ();
				  }
				});
		});
		
		var teksMn1 = $("#mn1").text();
		teksMn1 = teksMn1 + '<?php echo " ".$_SESSION["tahun"]." ".$_SESSION["tahap"];?>';
		$("#mn1").text(teksMn1);

		
	});
</script>

<?php 
	include "footer.php";
?>