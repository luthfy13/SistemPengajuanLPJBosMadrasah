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
	$ps->prepare("update tb_user set status=? where username=?");
	$ps->bind_param("ss", $p1, $p2);
	$p1 = $_POST["nilai"];
	$p2 = $_POST["username"];
	$ps->execute();
	$ps->close();
	$conn->close();
?>