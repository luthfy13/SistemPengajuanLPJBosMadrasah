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
	
	include_once "conn.php";
	$ps = $conn->stmt_init();
	$ps->prepare("select * from tb_lpj where npsn=? and tahun=? and tahap=? and id_lampiran=19 and bulan=?");
	$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
	$p1 = $_SESSION["npsn"];
	$p2 = $_SESSION["tahun"];
	$p3 = $_SESSION["tahap"];
	$p4 = $_POST["bulan"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$row = $hasil->fetch_assoc();
		echo $row["status"];
	}
	else{
		$ps = $conn->stmt_init();
		$ps->prepare("select * from tb_penilaian where npsn=? and tahun=? and tahap=?");
		$ps->bind_param("sss", $p1, $p2, $p3);
		$p1 = $_SESSION["npsn"];
		$p2 = $_SESSION["tahun"];
		$p3 = $_SESSION["tahap"];
		$ps->execute();
		$hasil = $ps->get_result();
		if ($hasil->num_rows > 0)
			echo "data sudah ada";
		else
			echo "tidak ada";
	}
	$ps->close();
	$conn->close();
?>