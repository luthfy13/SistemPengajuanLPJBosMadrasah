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

	echo $ukuranFile;
?>