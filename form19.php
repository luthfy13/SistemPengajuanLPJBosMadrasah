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
	
	include "conn.php";
	$namaMadrasah = "";
	$ps = $conn->stmt_init();
	$ps->prepare("select nama from tb_madrasah where username = ?");
	$ps->bind_param("s", $username);
	$username = $_SESSION["userLogin"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		while($row = $hasil->fetch_assoc()){
			$namaMadrasah = $row["nama"];
		}
		$ps->close();
		$conn->close();
	}
	else{
		$ps->close();
		$conn->close();
		exit();
	}

	$tahun = str_replace("/", "", $_SESSION["tahun"]);
	$namaFolder = 'fileLPJ/'.$tahun."/".$_SESSION["tahap"]."/".$namaMadrasah;
	if (!file_exists($namaFolder)) {
		mkdir($namaFolder, 0777, true);
	}

	$ukuranFile = 0;
	for ($i=1; $i<=10; $i++) { 
		$nama = "FORMAT BOS-K7";
		if ($i < 10)
			$bulan = "0".$i;
		else
			$bulan = $i;
		$nama = $nama." Bulan ".$bulan;
		$namaFile = $tahun." - ".$_SESSION["tahap"]." - ".$namaMadrasah." - ".$nama;
		$targetPath = $namaFolder."/".$namaFile.".pdf";
		if (!file_exists($targetPath)) {
			$ukuranFile = $ukuranFile + 0;
		}
		else{
			$ukuranFile = $ukuranFile + filesize($targetPath);
		}
	}
	$sisaUkuran = 414187520 - $ukuranFile;	
	
?>

<form id="uploadForm19" class="uploadForm" method="post" action="uploadFile.php">
	<input type="text" name="inputName" value="up19" hidden="hidden">
	<div class="baris judul">
		<label style="font-weight: bold; font-size: 150%;">FORMAT BOS-K7</label><br>
		<label>KUITANSI/BUKTI PEMBAYARAN</label>
	</div>
	<div class="baris">
		<div class="kolom1">
			<select id="optBulan" name="optBulan" style="padding: 10px;border: 1px solid black;border-radius: 4px;width: 150px; margin-bottom: 10px;">
				<option value="0">Pilih Bulan</option>
				<option class="thp1" value="1">Januari</option>
				<option class="thp1" value="2">Februari</option>
				<option class="thp1" value="3">Maret</option>
				<option class="thp1" value="4">April</option>
				<option class="thp1" value="5">Mei</option>
				<option class="thp1" value="6">Juni</option>
				<option class="thp2" value="7">Juli</option>
				<option class="thp2" value="8">Agustus</option>
				<option class="thp2" value="9">September</option>
				<option class="thp2" value="10">Oktober</option>
				<option class="thp2" value="11">November</option>
				<option class="thp2" value="12">Desember</option>
			</select>
			<select id="optTambahan" name="optTambahan" style="padding: 10px;border: 1px solid black;border-radius: 4px;width: 150px; margin-bottom: 10px; display: none;">
				<option value="1">Ganti</option>
				<option value="2">Tambah</option>
			</select>
			<input type="button" value="Hapus" id="btnHapus" class="styleButton" style="display:none; width: 65px;">
			<label id="lblSize1" style="margin-right: 10px; display: inline-block; width: 180px;margin-bottom: 10px; padding: 10px; color: #007165;">
				<?php echo "Terupload: ".number_format(($ukuranFile/1024/1024),2)."MB"; ?>
			</label>
			<label id="lblSize2" style="margin-right: 10px; display: inline-block; width: 180px;margin-bottom: 10px; padding: 10px; color: #007165;">
				<?php echo "Tersisa: ".number_format(($sisaUkuran/1024/1024),2)."MB"; ?>
			</label>
			<input type="file" style="" id="up19" name="up19">
		</div>
		<div class="kolom2" style="margin-top:50px;">
			<input type="submit" value="Upload File" id="btn19" class="btnSubmitFile">
		</div>
	</div>
	<div id="progress-div19" class="progressDiv">
		<div id="progress-bar19" class="progressBar">
		</div>
	</div>
</form>

<script>
	$(document).ready(function(){
		var hasilPenilaian = "<?php echo $hasilPenilaian; ?>";
		var sisaUkuranFile = Number(<?php echo $sisaUkuran; ?>);
		var tahap = '<?php echo $_SESSION["tahap"]; ?>';

		if (tahap == "Tahap I"){
			$(".thp2").css('display', 'none');
		}
		else
			$(".thp1").css('display', 'none');

		//$("#optTambahan").val("2");		

		$("#btn19").click(function(e){
			var file1 = document.getElementById('up19').files[0];
			
			if ($("#optBulan").val()=="0"){
				e.preventDefault();
				swal({
					title: "Gagal Menyimpan Data",
					text: "Pilih bulan terlebih dahulu!!!",
					type: "error",
					allowOutsideClick: false
				});
				return;
			}
			if ($("#up19").val()==""){
				e.preventDefault();
				swal({
					title: "Gagal Menyimpan Data",
					text: "Lengkapi data Anda terlebih dahulu!!!",
					type: "error",
					allowOutsideClick: false
				});
			}
			else{
				var strSisa;
				xx = parseFloat(1024);
				strSisa = sisaUkuranFile/xx/xx;
				strSisa = parseFloat(Math.round(strSisa * 100) / 100).toFixed(2);
				strSisa = strSisa + "MB";
				if (file1.size > sisaUkuranFile){
					e.preventDefault();
					swal({
						title: "Gagal Menyimpan Data",
						html: "Ukuran file tidak boleh lebih dari " + strSisa + "<br>Kompresi file pdf Anda " +
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


		$('#uploadForm19').submit(function(e) {	
			if($('#up19').val()) {
				e.preventDefault();
				var re = /(?:\.([^.]+))?$/;
				var ext = $("#up19").val().toLowerCase();
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
						$("#progress-bar19").width('0%');
					},
					uploadProgress: function (event, position, total, percentComplete){	
						$("#progress-bar19").width(percentComplete + '%');
						$("#progress-bar19").html('<div id="progress-status">' + percentComplete +' %</div>')
					},
					success:function (text){
						$("#progress-bar19").html("<b>Upload Selesai</b>");
						if (text != "Berhasil"){
							var pesan = "";
							var bag2 = true;
							if (text.indexOf("bag 2") >= 0){
								pesan = "File yang baru-baru Anda upload tidak didukung";
							}
							else{
								pesan = "File bagian pertama yang Anda upload tidak didukung";
								bag2 = false;
							}

							swal({
								title: "Gagal Menggabungkan File!",
								html: pesan + ", gunakan PDF Producer yang lain!!! Atau Anda dapat mengupload file lampiran untuk bulan ini sekaligus dalam satu file (tidak dipisah)",
								type: "error",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: true
							}).then(function(){
								text = text.substring(0, text.indexOf(')'));
    							text = text.substr(text.indexOf('(')+1);
    							if (bag2 == false)
    								text = text.replace(".pdf", " bag 2.pdf")
								hapusLPJBag2(text);
							});
						}
						$("#optTambahan").val("1");
						$("#optTambahan").css('display', 'none');
						$("#btnHapus").css('display', 'none');
						var xmlhttp = new XMLHttpRequest();
						
						xmlhttp.onreadystatechange = function() {
						    if (this.readyState == 4 && this.status == 200) {
						    	var ukuran = this.responseText;
						    	var sisa = 414187520 - ukuran;
						    	sisaUkuranFile = sisa;
						    	xx = parseFloat(1024);
						    	ukuran = ukuran/xx/xx;
						    	sisa = sisa/xx/xx;
						    	ukuran = parseFloat(Math.round(ukuran * 100) / 100).toFixed(2);
						    	sisa = parseFloat(Math.round(sisa * 100) / 100).toFixed(2);
						        $("#lblSize1").html("Terupload: " + ukuran + "MB");
								$("#lblSize2").html("Tersisa: " + sisa + "MB");
						    }
						};
						xmlhttp.open("POST", "getSizeK7.php", true);
						xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xmlhttp.send();

					},
					resetForm: true
				}); 
				return false; 
			}
		});

		$(document).on("change", "#optBulan", function(){
			$("#loadingDiv").css("display","block");
			$("#optTambahan").css("display","none");
			$("#btnHapus").css('display', 'none');
			$("#optTambahan").val("1");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			        if (this.responseText=="Pending" || this.responseText=="Proses" || this.responseText=="Diterima"){
				        $("#up19, #btn19").attr("disabled", "disabled");
				        $("#progress-bar19").css("width","100%");
				        $("#progress-bar19").html("File Sudah Terupload. Status dokumen: <b>"+this.responseText+"</b>");
				    }
			        else if (this.responseText=="Belum Diajukan" || this.responseText=="Upload Ulang"){
				        $("#up19, #btn19").removeAttr("disabled");
				        $("#progress-bar19").css("width","100%");
				        $("#progress-bar19").html("File Sudah Terupload. Status dokumen: <b>"+this.responseText+"</b>");
				        $("#optTambahan").css("display","inline");
				        $("#btnHapus").css('display', 'inline');
				        if (this.responseText=="Upload Ulang"){
				        	$("#btnHapus").css('display', 'none');
				        	$("#optTambahan").css("display","none");
				        }
				    }
			        else if (this.responseText=="data sudah ada"){
			        	$("#up19, #btn19").attr("disabled", "disabled");
				        $("#progress-bar19").css("width","0%");
				        $("#progress-bar19").html("");
				    }
			        else{
			        	$("#up19, #btn19").removeAttr("disabled");
				        $("#progress-bar19").css("width","0%");
				        $("#progress-bar19").html("");
				    }
					if (hasilPenilaian == "Proses"){
						$(".uploadForm input").attr('disabled', 'disabled');
					}

			        $("#loadingDiv").css("display","none");
			    }
			};
			xmlhttp.open("POST", "cekBulanKuitansi.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("bulan=" + $("#optBulan").val());
		});

		function hapusLPJ(){
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	if (this.responseText == "NOT OK"){
			    		$("#uploadForm19").trigger("reset");
				    	$("#optBulan").trigger("change");
				        $("#loadingDiv").css("display","none");
			    		swal("Proses dibatalkan!!!", "Lampiran ini telah diajukan sebelumnya.","error")
			    		return;
			    	}
			    	var xmlhttp2 = new XMLHttpRequest();
			    	xmlhttp2.onreadystatechange = function() {
					    if (this.readyState == 4 && this.status == 200) {
					    	var ukuran = this.responseText;
					    	var sisa = 414187520 - ukuran;
					    	sisaUkuranFile = sisa;
					    	xx = parseFloat(1024);
					    	ukuran = ukuran/xx/xx;
					    	sisa = sisa/xx/xx;
					    	ukuran = parseFloat(Math.round(ukuran * 100) / 100).toFixed(2);
					    	sisa = parseFloat(Math.round(sisa * 100) / 100).toFixed(2);
					        $("#lblSize1").html("Terupload: " + ukuran + "MB");
							$("#lblSize2").html("Tersisa: " + sisa + "MB");

							$("#uploadForm19").trigger("reset");
					    	$("#optBulan").trigger("change");
					        $("#loadingDiv").css("display","none");
					    }
					};
					xmlhttp2.open("POST", "getSizeK7.php", true);
					xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp2.send();

			    }
			};
			xmlhttp.open("POST", "hapusLPJ.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("bulan=" + $("#optBulan").val());
		}

		function hapusLPJBag2(namaFile){
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	$("#loadingDiv").css("display","none");
			    }
			};
			xmlhttp.open("POST", "hapusLPJBag2.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("namaFile=" + namaFile);
		}

		$(document).on("click", "#btnHapus", function(){
			swal({
				  title: 'Apakah Anda yakin ingin menghapus lampiran ini?',
				  text: "LPJ yang telah dihapus tidak bisa dikembalikan lagi!!!",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya!',
				  cancelButtonText: 'Tidak'
				}).then((result) => {
				  if (result.value) {
					hapusLPJ();
				  }
				});
		});
	});
</script>