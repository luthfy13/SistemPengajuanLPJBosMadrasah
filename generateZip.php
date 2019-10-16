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

	function create_zip($files = array(),$destination = '',$overwrite = false) {
		if(file_exists($destination) && !$overwrite) { return false; }
		$valid_files = array();
		if(is_array($files)) {
			foreach($files as $file) {
				if(file_exists($file)) {
					$valid_files[] = $file;
				}
			}
		}
		if(count($valid_files)) {
			$zip = new ZipArchive();
			if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			foreach($valid_files as $file) {
				$zip->addFile($file,$file);
			}
			$zip->close();
			return file_exists($destination);
		}
		else
		{
			return false;
		}
	}
	
	function refValues($arr){
		if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
		{
			$refs = array();
			foreach($arr as $key => $value)
				$refs[$key] = &$arr[$key];
				return $refs;
		}
		return $arr;
	}
	
	if (file_exists("FileLPJ-".$_SESSION["userLogin"].".zip")) unlink("FileLPJ-".$_SESSION["userLogin"].".zip");
	$arrayLink = json_decode($_POST['jsondata']);
	$hasil = create_zip($arrayLink, "FileLPJ-".$_SESSION["userLogin"].".zip");
	if($hasil == true){
		echo "Sukses";
	}
	else{
		echo "Gagal";
	}
	$hsl="";
	$sss="";
	foreach ($arrayLink as $value) {
		$hsl = $hsl."?,";
		$sss = $sss."s";
	}
	$hsl = substr($hsl, 0, strlen($hsl)-1);

// 	$ps = $conn->stmt_init();
// 	$ps->prepare("update tb_lpj set status='Proses' where path_file in (".$hsl.")");
// 	call_user_func_array(array($ps, 'bind_param'), $arrayLink);
// 	$ps->execute();
// 	$ps->close();
// 	$conn->close();
	array_unshift($arrayLink, $sss);
	$sql = "update tb_lpj set status='Proses' where path_file in (".$hsl.")";
	$stmt = $conn->prepare($sql);
	call_user_func_array(array($stmt, 'bind_param'), refValues($arrayLink));
	$stmt->execute();
	$conn->close();
	
?>