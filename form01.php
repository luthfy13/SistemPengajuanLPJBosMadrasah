<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	if (isset($_SESSION["loginStat"])){
		if ($_SESSION["loginStat"] != "operator LPJ login")
			exit();
	}
	else{
		echo "Kacian deh lu";
		exit();
	}
	
// 	function sudahUpload(){
// 		include "conn.php";
// 		$ada = "";
// 		$ps = $conn->stmt_init();
// 		$ps->prepare("select * from tb_lpj where npsn=? and tahun=? and tahap=? and id_lampiran=?");
// 		$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
// 		$p1 = $_SESSION["npsn"];
// 		$p2 = $_SESSION["tahun"];
// 		$p3 = $_SESSION["tahap"];
// 		$p4 = "1";
// 		$ps->execute();
// 		$hasil = $ps->get_result();
// 		if ($hasil->num_rows > 0){
// 			$ada = true;
// 		}
// 		else{
// 			$ada = false;
// 		}
// 		$ps->close();
// 		$conn->close();
// 		return $ada;
// 	}
	
// 	$sudah = sudahUpload();
?>

<form id="uploadForm1" class="uploadForm" method="post" action="uploadFile.php">
	<input type="text" name="inputName" value="up1" hidden="hidden">
	<div class="baris judul">
		<label style="font-weight: bold; font-size: 150%;">FORMULIR BOS-01</label><br>
		<label>SK PEJABAT PEMBUAT KOMITMEN TENTANG PENETAPAN MADRASAH SWASTA PENERIMA BANTUAN OPERASIONAL SEKOLAH</label>
	</div>
	<div class="baris">
		<div class="kolom1">
			<input type="file" id="up1" name="up1" <?php if($status[1] == "Pending" || $status[1] == "Proses" || $status[1] == "Diterima") echo "disabled"?>>
		</div>
		<div class="kolom2">
			<input type="submit" value="Upload File" id="btn1" class="btnSubmitFile" <?php if($status[1] == "Pending" || $status[1] == "Proses" || $status[1] == "Diterima") echo "disabled"?>>
		</div>
	</div>
	<div id="progress-div" class="progressDiv">
		<div id="progress-bar" class="progressBar" <?php if($sudah[1] == "1") echo "style='width:100%'";?>>
			<?php
				if($sudah[1] == "1") echo "File Sudah Terupload";
				if($status[1] != "") echo ". Status Dokumen: <b>".$status[1]."</b>.";
			?>
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){

		$("#btn1").click(function(e){
			var file1 = document.getElementById('up1').files[0];
			if ($("#up1").val()==""){
				e.preventDefault();
				swal({
					title: "Gagal Menyimpan Data",
					text: "Lengkapi data Anda terlebih dahulu!!!",
					type: "error",
					allowOutsideClick: false
				});
			}
			else{
				if (file1.size > 2621440){
					e.preventDefault();
					swal({
						title: "Gagal Menyimpan Data",
						html: "Ukuran file tidak boleh lebih dari 2.5MB!<br>Kompresi file pdf Anda " +
							  "<a href='https://www.ilovepdf.com/compress_pdf' target='_blank'>di website ini</a>. " +
							  "Ketika melakukan kompresi file, pilih Recommended Compression. <br>Atau anda dapat mengikuti " + 
							  "<a href='pdf/Langkah Kompresi PDF.pdf'>langkah-langkah ini</a> untuk melakukan kompresi file secara offline di PC Anda.",
						type: "error",
						allowOutsideClick: false
					});
				}
				else{
					var r = confirm("Apakah data yang Anda masukkan sudah benar?");
					if (r == false) {
							e.preventDefault();
					}
				}
			}

		});


		$('#uploadForm1').submit(function(e) {	
			if($('#up1').val()) {
				e.preventDefault();
				var re = /(?:\.([^.]+))?$/;
				var ext = $("#up1").val().toLowerCase();
				ext = re.exec(ext)[1];
				if (ext != "pdf"){
					swal({
						title: "File tidak didukung!",
						text: "File yang diperbolehkan hanya file PDF.",
						type: "error",
						allowOutsideClick: false
					});
					return;
				}
				$(this).ajaxSubmit({ 
					target:'', 
					beforeSubmit: function() {
						$("#progress-bar").width('0%');
					},
					uploadProgress: function (event, position, total, percentComplete){	
						$("#progress-bar").width(percentComplete + '%');
						$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
					},
					success:function (){
						$("#progress-bar").html("<b>Upload Selesai</b>");
					},
					resetForm: true
				}); 
				return false; 
			}
		});
	});
</script>