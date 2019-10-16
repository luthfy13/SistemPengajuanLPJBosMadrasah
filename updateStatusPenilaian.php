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

	if ($_POST["nilai"] == "Diterima"){
		$ps = $conn->stmt_init();
		$ps->prepare("update tb_penilaian set status=?, keterangan=? where npsn=? and tahun=? and tahap=?");
		$ps->bind_param("sssss", $p1, $p2, $p3, $p4, $p5);
		$p1 = $_POST["nilai"];
		$p2 = "Selamat LPJ Anda diterima, Madrasah Anda berhak menerima dana BOS untuk tahap selanjutnya.";
		$p3 = $_POST["npsn"];
		$p4 = $_POST["tahun"];
		$p5 = $_POST["tahap"];
		$ps->execute();

		$ps = $conn->stmt_init();
		$ps->prepare("update tb_lpj set status=? where npsn=? and tahun=? and tahap=?");
		$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
		$p1 = $_POST["nilai"];
		$p2 = $_POST["npsn"];
		$p3 = $_POST["tahun"];
		$p4 = $_POST["tahap"];
		$ps->execute();
	}
	else{
		$ps = $conn->stmt_init();
		$ps->prepare("update tb_penilaian set status=? where npsn=? and tahun=? and tahap=?");
		$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
		$p1 = $_POST["nilai"];
		$p2 = $_POST["npsn"];
		$p3 = $_POST["tahun"];
		$p4 = $_POST["tahap"];
		$ps->execute();
	}

	$ps->close();
	$conn->close();
?>