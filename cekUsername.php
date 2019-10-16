<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();

	if (isset($_SESSION["loginStat"])){
		if ($_SESSION["loginStat"] != "operator LPJ login" && $_SESSION["loginStat"] != "pemeriksa login")
			exit();
	}
	else{
		echo "Kacian deh lu";
		exit();
	}
	
	include_once "conn.php";
	$ps = $conn->stmt_init();
	$ps->prepare("select username from tb_user where username=?");
	$ps->bind_param("s", $p1);
	$p1 = $_POST["username"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		echo "ada";
	}
	else{
		echo "belum ada";
	}
	$ps->close();
	$conn->close();
?>