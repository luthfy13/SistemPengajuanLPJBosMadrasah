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
	$ps->prepare("insert into tb_lpj (npsn, tahun, tahap, id_lampiran, status, bulan) values(?,?,?,?,?,?)");
	$ps->bind_param("ssssss", $p1, $p2, $p3, $p4, $p5, $p6);
	$p1 = $_POST["npsn"];
	$p2 = $_POST["tahun"];
	$p3 = $_POST["tahap"];
	$p4 = $_POST["idLampiran"];
	$p5 = 'Upload Ulang';
	$p6 = $_POST["bulan"];
	$ps->execute();
	$ps->close();
	$conn->close();
?>