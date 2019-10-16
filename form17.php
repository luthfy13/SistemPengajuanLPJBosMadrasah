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

<form id="uploadForm17" class="uploadForm" method="post" action="uploadFile.php">
	<input type="text" name="inputName" value="up17" hidden="hidden">
	<div class="baris judul">
		<label style="font-weight: bold; font-size: 150%;">FORMAT BOS-K5</label><br>
		<label>REKAPITULASI PENYALURAN DANA BOS</label>
	</div>
	<div class="baris">
		<div class="kolom1">
			<input type="file" id="up17" name="up17" <?php if($status[17] == "Pending" || $status[17] == "Proses" || $status[17] == "Diterima") echo "disabled"?>>
		</div>
		<div class="kolom2">
			<input type="submit" value="Upload File" id="btn17" class="btnSubmitFile" <?php if($status[17] == "Pending" || $status[17] == "Proses" || $status[17] == "Diterima") echo "disabled"?>>
		</div>
	</div>
	<div id="progress-div17" class="progressDiv">
		<div id="progress-bar17" class="progressBar" <?php if($sudah[17] == "1") echo "style='width:100%'";?>>
			<?php
				if($sudah[17] == "1") echo "File Sudah Terupload";
				if($status[17] != "") echo ". Status Dokumen: <b>".$status[17]."</b>.";
			?>
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){

		$("#btn17").click(function(e){
			var file1 = document.getElementById('up17').files[0];
			if ($("#up17").val()==""){
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


		$('#uploadForm17').submit(function(e) {	
			if($('#up17').val()) {
				e.preventDefault();
				var re = /(?:\.([^.]+))?$/;
				var ext = $("#up17").val().toLowerCase();
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
						$("#progress-bar17").width('0%');
					},
					uploadProgress: function (event, position, total, percentComplete){	
						$("#progress-bar17").width(percentComplete + '%');
						$("#progress-bar17").html('<div id="progress-status">' + percentComplete +' %</div>')
					},
					success:function (){
						$("#progress-bar17").html("<b>Upload Selesai</b>");
					},
					resetForm: true
				}); 
				return false; 
			}
		});
	});
</script>