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
	
?>

<form id="uploadForm12" class="uploadForm" method="post" action="uploadFile.php">
	<input type="text" name="inputName" value="up12" hidden="hidden">
	<div class="baris judul">
		<label>FORMULIR BOS-10 (LEMBAR PENCATATAN PENGADUAN MASYARAKAT)</label>
	</div>
	<div class="baris">
		<div class="kolom1">
			<input type="file" id="up12" name="up12" <?php if($status[12] == "Pending" || $status[12] == "Proses" || $status[12] == "Diterima") echo "disabled"?>>
		</div>
		<div class="kolom2">
			<input type="submit" value="Upload File" id="btn12" class="btnSubmitFile" <?php if($status[12] == "Pending" || $status[12] == "Proses" || $status[12] == "Diterima") echo "disabled"?>>
		</div>
	</div>
	<div id="progress-div12" class="progressDiv">
		<div id="progress-bar12" class="progressBar" <?php if($sudah[12] == "1") echo "style='width:100%'";?>>
			<?php
				if($sudah[12] == "1") echo "File Sudah Terupload";
				if($status[12] != "") echo ". Status Dokumen: <b>".$status[12]."</b>.";
			?>
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){

		$("#btn12").click(function(e){
			var file1 = document.getElementById('up12').files[0];
			if ($("#up12").val()==""){
				e.preventDefault();
				swal({
					title: "Gagal Menyimpan Data",
					text: "Lengkapi data Anda terlebih dahulu!!!",
					type: "error",
					allowOutsideClick: false
				});
			}
			else{
				if (file1.size > 1572864){
					e.preventDefault();
					swal({
						title: "Gagal Menyimpan Data",
						html: "Ukuran <b>file</b> tidak boleh lebih dari 1.5MB!<br>Kompresi file pdf Anda " +
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


		$('#uploadForm12').submit(function(e) {	
			if($('#up12').val()) {
				e.preventDefault();
				var re = /(?:\.([^.]+))?$/;
				var ext = $("#up12").val().toLowerCase();
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
						$("#progress-bar12").width('0%');
					},
					uploadProgress: function (event, position, total, percentComplete){	
						$("#progress-bar12").width(percentComplete + '%');
						$("#progress-bar12").html('<div id="progress-status">' + percentComplete +' %</div>')
					},
					success:function (){
						$("#progress-bar12").html("<b>Upload Selesai</b>");
					},
					resetForm: true
				}); 
				return false; 
			}
		});
	});
</script>