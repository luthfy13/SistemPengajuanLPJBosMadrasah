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
	
	if ($_POST["txtPass"] != ""){
		$sql = "update tb_user set username = ?, password = password(?), nama = ?, email=? where username = ?";
		$ps->prepare($sql);
		$ps->bind_param("sssss", $user, $password, $nama, $email, $username);
	}
	else{
		$sql = "update tb_user set username = ?, nama = ?, email=? where username = ?";
		$ps->prepare($sql);
		$ps->bind_param("ssss", $user, $nama, $email, $username);
	}
	
	
	$user = $_POST["txtUser"];
	$password = $_POST["txtPass"];
	$nama = $_POST["txtNamaOperator"];
	$email = $_POST["txtEmail"];
	$username = $_SESSION["userLogin"];
	
	$_SESSION["userLogin"] = $user;
	$_SESSION["namaUser"] = $nama;
	
	if($ps->execute()){
		$ps->close();
		$conn->close();
		echo"
			
			<script>
				$(document).ready(function(){
					var b = $('body').height();
					$('#div1').height(b);
					swal('Data operator berhasil tersimpan..').then(function(){
						location.replace('editDataOperator.php');
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
