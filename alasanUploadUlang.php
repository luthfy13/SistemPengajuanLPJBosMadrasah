<?php
	include "headerPemeriksa.php";
	include_once "conn.php";

	$npsn = $_GET["npsn"];
	$tahun = $_GET["tahun"];
	$tahap = $_GET["tahap"];
	
	$ps = $conn->stmt_init();
	$ps->prepare("select * from tb_penilaian where npsn=? and tahun=? and tahap=? and status=?");
	$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
	$p1 = $npsn;
	$p2 = $tahun;
	$p3 = $tahap;
	$p4 = "Proses";
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows == 0){
		$ps->close();
		$conn->close();
		echo "
			<script>
				location.href='penilaianLPJ.php';
			</script>
		";
	}
	else{
		$row = $hasil->fetch_assoc();
		$ps->close();
		$conn->close();
	}
	

?>

<div id="main">
<div id="isiMain">
	<div class="loadingGif" id="loadingDiv">
			<img src="picts/loading.gif">
	</div>
	<form>
		<div class="baris">
			<div class="kolom1" style="width: 21%; margin-right: 2%">
				<label class="styleLabel">Masukkan penyebab sehingga LPJ harus di-<i>upload</i> ulang</label>
			</div>
			<div class="kolom2"  style="width: 75%">
				<textarea id="txtAlasan" style="width: 100%; height: 350px; border-radius: 5px; border: 1px solid gray; padding: 10px;"><?php echo $row["keterangan"]?></textarea>
			</div>
		</div>
		<div class="baris">
			<input class="styleButton" type="button" value="Lanjut" id="btnLanjut">
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
		
		$(document).on("click", "#btnLanjut", function(){
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			        $("#loadingDiv").css("display","none");
			        location.href="detailUploadUlang.php" +
						"?npsn=" + "<?php echo $npsn; ?>" + 
						"&tahun=" + "<?php echo $tahun; ?>" + 
						"&tahap=" + "<?php echo $tahap; ?>";
			    }
			};
			xmlhttp.open("POST", "updateAlasanUploadUlang.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var alasan;
			alasan = $("#txtAlasan").val();
			// alasan = alasan + "\n\n";
			xmlhttp.send("nilai=" + alasan +
						"&npsn=" + "<?php echo $npsn; ?>" + 
						"&tahun=" + "<?php echo $tahun; ?>" + 
						"&tahap=" + "<?php echo $tahap; ?>"
						);
		});

	});
</script>


<?php 
	include "footer.php";
?>