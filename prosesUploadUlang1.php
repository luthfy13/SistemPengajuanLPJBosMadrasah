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
	$ps->prepare("update tb_lpj set status=? where npsn=? and tahun=? and tahap=? and id_lampiran=? and bulan=?");
	$ps->bind_param("ssssss", $p1, $p2, $p3, $p4, $p5, $p6);
	$p1 = "Upload Ulang";
	$p2 = $_POST["npsn"];
	$p3 = $_POST["tahun"];
	$p4 = $_POST["tahap"];
	$p5 = $_POST["idLampiran"];
	$p6 = $_POST["bulan"];
	$ps->execute();
	$ps->close();
	$conn->close();
?>