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

	$output = "OK";

	$ps = $conn->stmt_init();
	$ps->prepare("select npsn from tb_penilaian where npsn = ?");
	$ps->bind_param("s", $p1);
	$p1 = $_SESSION["npsn"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$output = "NOT OK";
	}
	else{
		$ps = $conn->stmt_init();
		$ps->prepare("select path_file from tb_lpj where npsn=? and tahun=? and tahap=? and id_lampiran=? and bulan=?");
		$ps->bind_param("sssss", $p1, $p2, $p3, $p4, $p5);
		$p1 = $_SESSION["npsn"];
		$p2 = $_SESSION["tahun"];
		$p3 = $_SESSION["tahap"];
		$p4 = "19";
		$p5 = $_POST["bulan"];
		$ps->execute();
		$hasil = $ps->get_result();
		$row = $hasil->fetch_assoc();
		$alamatFile = $row["path_file"];
		unlink($alamatFile);

		$ps = $conn->stmt_init();
		$ps->prepare("delete from tb_lpj where npsn=? and tahun=? and tahap=? and id_lampiran=? and bulan=?");
		$ps->bind_param("sssss", $p1, $p2, $p3, $p4, $p5);
		$p1 = $_SESSION["npsn"];
		$p2 = $_SESSION["tahun"];
		$p3 = $_SESSION["tahap"];
		$p4 = "19";
		$p5 = $_POST["bulan"];
		$ps->execute();
	}	
	
	$ps->close();
	$conn->close();

	echo $output;
?>