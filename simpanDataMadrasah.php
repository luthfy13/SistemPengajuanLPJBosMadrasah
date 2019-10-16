<!DOCTYPE html>
<html>
	<head>
		<title>Pengajuan LPJ BOS</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style type="text/css">
			body,html{
				height: 100%;
				margin: 0;
			}
			#div1{
				min-height: 100%;
				background-image: url('picts/simpanBg.jpg');
				background-attachment: fixed;
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
			}
		</style>
		<script src="scripts/jquery-3.3.1.js"></script>
		<script src="scripts/sweetalert2/dist/sweetalert2.js"></script>
		<link rel="stylesheet" href="scripts/sweetalert2/dist/sweetalert2.css">
		<script src="scripts/polyfill.min.js"></script>
</head>
<body>
<div id="div1">Isi div</div>
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

	include_once 'conn.php';
	$ps = $conn->stmt_init();
	$sql = "
		update tb_madrasah set nsm = ?,jenjang = ?,status = ?,nama = ?,
		alamat = ?,nama_kepsek = ?,nama_bendahara = ?,
		no_telp = ?,id_kec = ?,id_kel = ? where npsn = ?	
	";
	$ps->prepare($sql);
	$ps->bind_param(
			"sssssssssss",
			$nsm, $jenjang, $status, $nama, $alamat, $nama_kepsek, $nama_bendahara, $no_telp, $id_kec, $id_kel, $npsn
			);
	
	$nsm = $_POST["txtNsm"];
	$jenjang = $_POST["optJenjang"];
	$status = $_POST["optStatus"];
	$nama = $_POST["txtNama"];
	$alamat = $_POST["txtAlamat"];
	$nama_kepsek = $_POST["txtNamaKepsek"];
	$nama_bendahara = $_POST["txtNamaBendahara"];
	$no_telp = $_POST["txtNoTelp"];
	$id_kec = $_POST["optKec"];
	$id_kel = $_POST["optKel"];
	$npsn = $_SESSION["npsn"];
	
if($ps->execute()){
		$ps->close();
		$conn->close();
		echo"
			
			<script>
				$(document).ready(function(){
					var b = $('body').height();
					$('#div1').height(b);
					swal('Data madrasah berhasil tersimpan..').then(function(){
						location.replace('editDataMadrasah.php');
					});
				});
			</script>
		";
	}
	else{
		echo $conn->error;
		$ps->close();
		$conn->close();
	}
	
?>
</body>
</html>
