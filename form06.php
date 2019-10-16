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

<form id="uploadForm6" class="uploadForm" method="post" action="uploadFile.php" title="Lampirkan juga fotokopi/scan dari buku rekening.">
	<input type="text" name="inputName" value="up6" hidden="hidden">
	<div class="baris judul">
		<label style="font-weight: bold; font-size: 150%;">FORMULIR BOS-04</label><br>
		<label>SURAT PERNYATAAN PENGIRIMAN NOMOR REKENING MADRASAH</label> <img class="imgHelp" id="imgHelp6" src="picts/helpIcon.png" width="20">
	</div>
	<div class="baris">
		<div class="kolom1">
			<input type="file" id="up6" name="up6" <?php if($status[6] == "Pending" || $status[6] == "Proses" || $status[6] == "Diterima") echo "disabled"?>>
		</div>
		<div class="kolom2">
			<input type="submit" value="Upload File" id="btn6" class="btnSubmitFile" <?php if($status[6] == "Pending" || $status[6] == "Proses" || $status[6] == "Diterima") echo "disabled"?>>
		</div>
	</div>
	<div id="progress-div6" class="progressDiv">
		<div id="progress-bar6" class="progressBar" <?php if($sudah[6] == "1") echo "style='width:100%'";?>>
			<?php
				if($sudah[6] == "1") echo "File Sudah Terupload";
				if($status[6] != "") echo ". Status Dokumen: <b>".$status[6]."</b>.";
			?>
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){

		$("#imgHelp6").click(function(){
			swal({
				type: 'info',
				text: 'Lampirkan juga fotokopi/scan buku rekening madrasah.'
			});
		});

		$("#btn6").click(function(e){
			var file1 = document.getElementById('up6').files[0];
			if ($("#up6").val()==""){
				e.preventDefault();
				swal({
					title: "Gagal Menyimpan Data",
					text: "Lengkapi data Anda terlebih dahulu!!!",
					type: "error",
					allowOutsideClick: false
				});
			}
			else{
				if (file1.size > 524288){
					e.preventDefault();
					swal({
						title: "Gagal Menyimpan Data",
						html: "Ukuran <b>file</b> tidak boleh lebih dari 512KB!<br>Kompresi file pdf Anda " +
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


		$('#uploadForm6').submit(function(e) {	
			if($('#up6').val()) {
				e.preventDefault();
				var re = /(?:\.([^.]+))?$/;
				var ext = $("#up6").val().toLowerCase();
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
						$("#progress-bar6").width('0%');
					},
					uploadProgress: function (event, position, total, percentComplete){	
						$("#progress-bar6").width(percentComplete + '%');
						$("#progress-bar6").html('<div id="progress-status">' + percentComplete +' %</div>')
					},
					success:function (){
						$("#progress-bar6").html("<b>Upload Selesai</b>");
					},
					resetForm: true
				}); 
				return false; 
			}
		});
	});
</script>