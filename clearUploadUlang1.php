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
	
	$sql = "
			update tb_lpj set status = 'Proses'
			WHERE npsn = ? AND tahun = ? AND tahap = ? AND status = ? and (path_file is not null or path_file = '')
			";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
	$p1 = $_POST["npsn"];
	$p2 = $_POST["tahun"];
	$p3 = $_POST["tahap"];
	$p4 = "Upload Ulang";
	$ps->execute();
	$ps->close();
	$conn->close();
?>