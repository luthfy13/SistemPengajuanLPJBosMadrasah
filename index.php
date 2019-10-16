<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_SESSION["loginStat"])){
		if($_SESSION["loginStat"] == "operator LPJ login"){
			include 'pengajuanLPJ.php';
		}
		else if($_SESSION["loginStat"] == "pemeriksa login"){
			include "downloadLPJ.php";
		}
		else{
			include 'header.php';
			include 'main.php';
			include 'footer.php';
		}
	}
	else{
		include 'header.php';
		include 'main.php';
		include 'footer.php';
	}
?>