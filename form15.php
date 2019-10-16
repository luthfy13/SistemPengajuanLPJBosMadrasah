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

<form id="uploadForm15" class="uploadForm" method="post" action="uploadFile.php">
	<input type="text" name="inputName" value="up15" hidden="hidden">
	<div class="baris judul">
		<label style="font-weight: bold; font-size: 150%;">FORMAT BOS-K3</label><br>
		<label>BUKU PEMBANTU PAJAK</label>
	</div>
	<div class="baris">
		<div class="kolom1">
			<input type="file" id="up15" name="up15" <?php if($status[15] == "Pending" || $status[15] == "Proses" || $status[15] == "Diterima") echo "disabled"?>>
		</div>
		<div class="kolom2">
			<input type="submit" value="Upload File" id="btn15" class="btnSubmitFile" <?php if($status[15] == "Pending" || $status[15] == "Proses" || $status[15] == "Diterima") echo "disabled"?>>
		</div>
	</div>
	<div id="progress-div15" class="progressDiv">
		<div id="progress-bar15" class="progressBar" <?php if($sudah[15] == "1") echo "style='width:100%'";?>>
			<?php
				if($sudah[15] == "1") echo "File Sudah Terupload";
				if($status[15] != "") echo ". Status Dokumen: <b>".$status[15]."</b>.";
			?>
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){

		$("#btn15").click(function(e){
			var file1 = document.getElementById('up15').files[0];
			if ($("#up15").val()==""){
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


		$('#uploadForm15').submit(function(e) {	
			if($('#up15').val()) {
				e.preventDefault();
				var re = /(?:\.([^.]+))?$/;
				var ext = $("#up15").val().toLowerCase();
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
						$("#progress-bar15").width('0%');
					},
					uploadProgress: function (event, position, total, percentComplete){	
						$("#progress-bar15").width(percentComplete + '%');
						$("#progress-bar15").html('<div id="progress-status">' + percentComplete +' %</div>')
					},
					success:function (){
						$("#progress-bar15").html("<b>Upload Selesai</b>");
					},
					resetForm: true
				}); 
				return false; 
			}
		});
	});
</script>