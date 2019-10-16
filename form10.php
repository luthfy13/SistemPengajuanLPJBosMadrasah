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

<form id="uploadForm10" class="uploadForm" method="post" action="uploadFile.php" title="Lampirkan juga Surat Keputusan Kepala Madrasah jika ada.">
	<input type="text" name="inputName" value="up10" hidden="hidden">
	<div class="baris judul">
		<label style="font-weight: bold; font-size: 150%;">FORMULIR BOS-08</label><br>
		<label>LAPORAN PERTANGGUNGJAWABAN BANTUAN OPERASIONAL SEKOLAH</label> <img class="imgHelp" id="imgHelp10" src="picts/helpIcon.png" width="20">
	</div>
	<div class="baris">
		<div class="kolom1">
			<input type="file" id="up10" name="up10" <?php if($status[10] == "Pending" || $status[10] == "Proses" || $status[10] == "Diterima") echo "disabled"?>>
		</div>
		<div class="kolom2">
			<input type="submit" value="Upload File" id="btn10" class="btnSubmitFile" <?php if($status[10] == "Pending" || $status[10] == "Proses" || $status[10] == "Diterima") echo "disabled"?>>
		</div>
	</div>
	<div id="progress-div10" class="progressDiv">
		<div id="progress-bar10" class="progressBar" <?php if($sudah[10] == "1") echo "style='width:100%'";?>>
			<?php
				if($sudah[10] == "1") echo "File Sudah Terupload";
				if($status[10] != "") echo ". Status Dokumen: <b>".$status[10]."</b>.";
			?>
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){

		$("#imgHelp10").click(function(){
			swal({
				type: 'info',
				text: 'Lampirkan juga Surat Keputusan Kepala Madrasah jika ada.'
			});
		});

		$("#btn10").click(function(e){
			var file1 = document.getElementById('up10').files[0];
			if ($("#up10").val()==""){
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


		$('#uploadForm10').submit(function(e) {	
			if($('#up10').val()) {
				e.preventDefault();
				var re = /(?:\.([^.]+))?$/;
				var ext = $("#up10").val().toLowerCase();
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
						$("#progress-bar10").width('0%');
					},
					uploadProgress: function (event, position, total, percentComplete){	
						$("#progress-bar10").width(percentComplete + '%');
						$("#progress-bar10").html('<div id="progress-status">' + percentComplete +' %</div>')
					},
					success:function (){
						$("#progress-bar10").html("<b>Upload Selesai</b>");
					},
					resetForm: true
				}); 
				return false; 
			}
		});
	});
</script>