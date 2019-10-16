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

<form id="uploadForm9" class="uploadForm" method="post" action="uploadFile.php">
	<input type="text" name="inputName" value="up9" hidden="hidden">
	<div class="baris judul">
		<label style="font-weight: bold; font-size: 150%;">FORMULIR BOS-07</label><br>
		<label>SURAT PERNYATAAN TANGGUNG JAWAB BELANJA</label>
	</div>
	<div class="baris">
		<div class="kolom1">
			<input type="file" id="up9" name="up9" <?php if($status[9] == "Pending" || $status[9] == "Proses" || $status[9] == "Diterima") echo "disabled"?>>
		</div>
		<div class="kolom2">
			<input type="submit" value="Upload File" id="btn9" class="btnSubmitFile" <?php if($status[9] == "Pending" || $status[9] == "Proses" || $status[9] == "Diterima") echo "disabled"?>>
		</div>
	</div>
	<div id="progress-div9" class="progressDiv">
		<div id="progress-bar9" class="progressBar" <?php if($sudah[9] == "1") echo "style='width:100%'";?>>
			<?php
				if($sudah[9] == "1") echo "File Sudah Terupload";
				if($status[9] != "") echo ". Status Dokumen: <b>".$status[9]."</b>.";
			?>
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){

		$("#btn9").click(function(e){
			var file1 = document.getElementById('up9').files[0];
			if ($("#up9").val()==""){
				e.preventDefault();
				swal({
					title: "Gagal Menyimpan Data",
					text: "Lengkapi data Anda terlebih dahulu!!!",
					type: "error",
					allowOutsideClick: false
				});
			}
			else{
				if (file1.size > 262144){
					e.preventDefault();
					swal({
						title: "Gagal Menyimpan Data",
						html: "Ukuran <b>file</b> tidak boleh lebih dari 256KB!<br>Kompresi file pdf Anda " +
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


		$('#uploadForm9').submit(function(e) {	
			if($('#up9').val()) {
				e.preventDefault();
				var re = /(?:\.([^.]+))?$/;
				var ext = $("#up9").val().toLowerCase();
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
						$("#progress-bar9").width('0%');
					},
					uploadProgress: function (event, position, total, percentComplete){	
						$("#progress-bar9").width(percentComplete + '%');
						$("#progress-bar9").html('<div id="progress-status">' + percentComplete +' %</div>')
					},
					success:function (){
						$("#progress-bar9").html("<b>Upload Selesai</b>");
					},
					resetForm: true
				}); 
				return false; 
			}
		});
	});
</script>