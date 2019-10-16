<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if (isset($_SESSION["loginStat"])){
		if ($_SESSION["loginStat"] != "pemeriksa login")
			exit();
	}
	else{
		echo "Kacian deh lu";
		exit();
	}
	
	include_once "conn.php";
	
	$ps = $conn->stmt_init();
	$ps->prepare("update tb_penilaian set keterangan=? where npsn=? and tahun=? and tahap=?");
	$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
	$p1 = $_POST["nilai"];
	$p2 = $_POST["npsn"];
	$p3 = $_POST["tahun"];
	$p4 = $_POST["tahap"];
	$ps->execute();
	$ps->close();
	$conn->close();
?>