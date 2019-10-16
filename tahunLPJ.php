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
	$jml = 0;
	$sql = "SELECT DISTINCT tahun from tb_lpj";
	$hasil = $conn->query($sql);
	while($row = $hasil->fetch_assoc()){
		echo "<option value='".$row["tahun"]."'>".$row["tahun"]."</option>";
	}
?>