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

<form id="uploadForm14" class="uploadForm" method="post" action="uploadFile.php">
	<input type="text" name="inputName" value="up14" hidden="hidden">
	<div class="baris judul">
		<label style="font-weight: bold; font-size: 150%;">FORMAT BOS-K2</label><br>
		<label>BUKU KAS UMUM</label>
	</div>
	<div class="baris">
		<div class="kolom1">
			<input type="file" id="up14" name="up14" <?php if($status[14] == "Pending" || $status[14] == "Proses" || $status[14] == "Diterima") echo "disabled"?>>
		</div>
		<div class="kolom2">
			<input type="submit" value="Upload File" id="btn14" class="btnSubmitFile" <?php if($status[14] == "Pending" || $status[14] == "Proses" || $status[14] == "Diterima") echo "disabled"?>>
		</div>
	</div>
	<div id="progress-div14" class="progressDiv">
		<div id="progress-bar14" class="progressBar" <?php if($sudah[14] == "1") echo "style='width:100%'";?>>
			<?php
				if($sudah[14] == "1") echo "File Sudah Terupload";
				if($status[14] != "") echo ". Status Dokumen: <b>".$status[14]."</b>.";
			?>
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){

		$("#btn14").click(function(e){
			var file1 = document.getElementById('up14').files[0];
			if ($("#up14").val()==""){
				e.preventDefault();
				swal({
					title: "Gagal Menyimpan Data",
					text: "Lengkapi data Anda terlebih dahulu!!!",
					type: "error",
					allowOutsideClick: false
				});
			}
			else{
				if (file1.size > 5242880){
					e.preventDefault();
					swal({
						title: "Gagal Menyimpan Data",
						html: "Ukuran file tidak boleh lebih dari 5MB!<br>Kompresi file pdf Anda " +
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


		$('#uploadForm14').submit(function(e) {	
			if($('#up14').val()) {
				e.preventDefault();
				var re = /(?:\.([^.]+))?$/;
				var ext = $("#up14").val().toLowerCase();
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
						$("#progress-bar14").width('0%');
					},
					uploadProgress: function (event, position, total, percentComplete){	
						$("#progress-bar14").width(percentComplete + '%');
						$("#progress-bar14").html('<div id="progress-status">' + percentComplete +' %</div>')
					},
					success:function (){
						$("#progress-bar14").html("<b>Upload Selesai</b>");
					},
					resetForm: true
				}); 
				return false; 
			}
		});
	});
</script>