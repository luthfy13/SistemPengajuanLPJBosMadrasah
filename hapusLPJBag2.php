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

	$a = $_POST["namaFile"];

	if (strpos($a, 'bag 2') !== false) {
	    unlink($a);
	}
?>