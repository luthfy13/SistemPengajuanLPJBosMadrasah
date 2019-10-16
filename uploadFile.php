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
	
	function namaMadrasah(){
		include "conn.php";
		$nama = "";
		$ps = $conn->stmt_init();
		$ps->prepare("select nama from tb_madrasah where username = ?");
		$ps->bind_param("s", $username);
		$username = $_SESSION["userLogin"];
		$ps->execute();
		$hasil = $ps->get_result();
		if ($hasil->num_rows > 0){
			while($row = $hasil->fetch_assoc()){
				$nama = $row["nama"];
			}
			$ps->close();
			$conn->close();
		}
		else{
			$ps->close();
			$conn->close();
			exit();
		}
		return $nama;
	}
	
	function uploadFileLPJ($idInputFile, $idLampiran, $bulan){
		$targetPath = "";
		if(!empty($_FILES)) {
			if(is_uploaded_file($_FILES[$idInputFile]['tmp_name'])) {
				$sourcePath = $_FILES[$idInputFile]['tmp_name'];
				$targetPath = $_FILES[$idInputFile]['name'];
				$ext = pathinfo($targetPath, PATHINFO_EXTENSION);
				$ext = strtolower((string)$ext);
				if ($ext != "pdf") exit();
				$tahun = str_replace("/", "", $_SESSION["tahun"]);
				
				$namaMadrasah = namaMadrasah();
				$namaFolder = 'fileLPJ/'.$tahun."/".$_SESSION["tahap"]."/".$namaMadrasah;
				if (!file_exists($namaFolder)) {
					mkdir($namaFolder, 0777, true);
				}
				
				include 'conn.php';
				$ps = $conn->stmt_init();
				$ps->prepare("select nama from tb_lampiran where id = ?");
				$ps->bind_param("s", $p1);
				$p1 = $idLampiran;
				$ps->execute();
				$hasil = $ps->get_result();
				$row = $hasil->fetch_assoc();
				$nama = $row["nama"];
				if ($idLampiran == "19"){
					if ((int)$bulan < 10){
						$bulan = "0".$bulan;
					}
					$nama = $nama." Bulan ".$bulan;
				}
				
				$namaFile = $tahun." - ".$_SESSION["tahap"]." - ".$namaMadrasah." - ".$nama;
				
				$targetPath1 = $namaFolder."/".$namaFile.".".$ext;
				$targetPath2 = $namaFolder."/".$namaFile." bag 2.".$ext;

				if ($_POST["optTambahan"] == "2")
					$targetPath = $targetPath2;
				else
					$targetPath = $targetPath1;
				
				$ps = $conn->stmt_init();
				$ps->prepare("delete from tb_lpj where npsn=? and tahun=? and tahap=? and id_lampiran=? and bulan=?");
				$ps->bind_param("sssss", $p1, $p2, $p3, $p4, $p5);
				$p1 = $_SESSION["npsn"];
				$p2 = $_SESSION["tahun"];
				$p3 = $_SESSION["tahap"];
				$p4 = $idLampiran;
				$p5 = (int)$bulan;
				$ps->execute();
				
				$ps = $conn->stmt_init();
				$ps->prepare("insert into tb_lpj values (?,?,?,?,?,?,?,?,?)");
				$ps->bind_param("sssssssss", $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9);
				$p1 = $_SESSION["npsn"];
				$p2 = $_SESSION["tahun"];
				$p3 = $_SESSION["tahap"];
				$p4 = $idLampiran;
				$p5 = "Belum Diajukan";
				$p6 = "";
				$p7 = $targetPath1;
				$p8 = (int)$bulan;
				$p9 = date("Ymd");
				
				$ps->execute();
				
				$ps->close();
				$conn->close();
		
				if(move_uploaded_file($sourcePath,$targetPath)) {
					if ($_POST["optTambahan"] == "2"){
						ini_set('memory_limit', '-1');
						include "scripts/PDFMerger/PDFMerger.php";
						$pdf = new PDFMerger;

						$pdf->addPDF($targetPath1, 'all');
						$pdf->addPDF($targetPath2, 'all');
						$pdf->merge('file', 'hasil.pdf');
						unlink($targetPath1);
						unlink($targetPath2);
						rename("hasil.pdf",$targetPath1);
					}
					echo "Berhasil";
				}
			}
		}
	}
	
	$idL ="";
	$inputName = $_POST["inputName"];
	switch($inputName){
		case "up1": $idL ="1"; break;
		case "up2": $idL ="2"; break;
		case "up3": $idL ="3"; break;
		case "up4": $idL ="4"; break;
		case "up5": $idL ="5"; break;
		case "up6": $idL ="6"; break;
		case "up7": $idL ="7"; break;
		case "up8": $idL ="8"; break;
		case "up9": $idL ="9"; break;
		case "up10": $idL ="10"; break;
		case "up11": $idL ="11"; break;
		case "up12": $idL ="12"; break;
		case "up13": $idL ="13"; break;
		case "up14": $idL ="14"; break;
		case "up15": $idL ="15"; break;
		case "up16": $idL ="16"; break;
		case "up17": $idL ="17"; break;
		case "up18": $idL ="18"; break;
		case "up19": $idL ="19"; break;
	}
	if (isset($_POST["optBulan"])){
		uploadFileLPJ($inputName, $idL, $_POST["optBulan"]);
	}
	else{
		uploadFileLPJ($inputName, $idL, "0");
	}
	
	
?>