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

	$sql = "select * from tb_lpj where npsn=? and tahun=? and tahap=? and (path_file is null or path_file = '')";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_SESSION["npsn"];
	$p2 = $_SESSION["tahun"];
	$p3 = $_SESSION["tahap"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$ps->close();
		$conn->close();
		echo "Data Belum Lengkap";
		exit();
	}

	$ada1=false; $ada2=false;
	$sql = "
		select count(npsn) as jml from tb_lpj where tb_lpj.npsn = ?
		AND tb_lpj.tahun = ? 
		AND tb_lpj.tahap = ?
		AND tb_lpj.STATUS <> 'upload ulang' 
		and id_lampiran <> '19'
		GROUP BY npsn having jml = 10
	";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_SESSION["npsn"];
	$p2 = $_SESSION["tahun"];
	$p3 = $_SESSION["tahap"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0)
		$ada1 = true;

	$sql = "
		select count(npsn) as jml from tb_lpj where tb_lpj.npsn = ?
		AND tb_lpj.tahun = ? 
		AND tb_lpj.tahap = ?
		and id_lampiran = '19'
		GROUP BY npsn
	";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_SESSION["npsn"];
	$p2 = $_SESSION["tahun"];
	$p3 = $_SESSION["tahap"];
	$ps->execute();
	$hasil = $ps->get_result();
	$row = $hasil->fetch_assoc();
	$jml=0;
	if ($hasil->num_rows > 0){
		$jml = $row["jml"];

		$sql = "
			select count(npsn) as jml from tb_lpj where tb_lpj.npsn = ?
			AND tb_lpj.tahun = ? 
			AND tb_lpj.tahap = ?
			AND tb_lpj.STATUS <> 'upload ulang' 
			and id_lampiran = '19'
			GROUP BY npsn
			having jml = ?
		";
		$ps = $conn->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("sssi", $p1, $p2, $p3, $p4);
		$p1 = $_SESSION["npsn"];
		$p2 = $_SESSION["tahun"];
		$p3 = $_SESSION["tahap"];
		$p4 = $jml;
		$ps->execute();
		$hasil = $ps->get_result();
		if ($hasil->num_rows > 0)
			$ada2 = true;
	}

	if ($ada1 && $ada2){
		//cek apakah sudah ada penilaian sebelumnya
		$ps = $conn->stmt_init();
		$ps->prepare("select * from tb_penilaian where npsn=? and tahun=? and tahap=?");
		$ps->bind_param("sss", $p1, $p2, $p3);
		$p1 = $_SESSION["npsn"];
		$p2 = $_SESSION["tahun"];
		$p3 = $_SESSION["tahap"];
		$ps->execute();
		$hasil = $ps->get_result();
		//jika sudah ada penilaian
		if ($hasil->num_rows > 0){
			$row = $hasil->fetch_assoc();
			//jika ada penilaian dan statusnya upload ulang, maka update kembali statusnya menjadi pending
			//dan status pada tb_lpj yg 'belum diajukan' menjadi 'pending'
			if ($row["status"] == "Upload Ulang"){
				$ps = $conn->stmt_init();
				$ps->prepare("update tb_penilaian set status='Pending' where npsn=? and tahun=? and tahap=?");
				$ps->bind_param("sss", $p1, $p2, $p3);
				$p1 = $_SESSION["npsn"];
				$p2 = $_SESSION["tahun"];
				$p3 = $_SESSION["tahap"];
				$ps->execute();
				
				$ps = $conn->stmt_init();
				$ps->prepare("update tb_lpj set status=? where npsn=? and tahun=? and tahap=? and status='Belum Diajukan'");
				$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
				$p1 = "Pending";
				$p2 = $_SESSION["npsn"];
				$p3 = $_SESSION["tahun"];
				$p4 = $_SESSION["tahap"];
				$ps->execute();
				echo "Sukses Upload Ulang";
			}
			else{
				echo $row["status"];
			}
		}
		//jika belum ada penilaian
		else{
			$ps = $conn->stmt_init();
			$ps->prepare("insert into tb_penilaian values(?,?,?,?,?)");
			$ps->bind_param("sssss", $p1, $p2, $p3, $p4, $p5);
			$p1 = $_SESSION["npsn"];
			$p2 = $_SESSION["tahun"];
			$p3 = $_SESSION["tahap"];
			$p4 = "Pending";
			$p5 = "";
			$ps->execute();
			
			$ps = $conn->stmt_init();
			$ps->prepare("update tb_lpj set status=? where npsn=? and tahun=? and tahap=?");
			$ps->bind_param("ssss", $p1, $p2, $p3, $p4);
			$p1 = "Pending";
			$p2 = $_SESSION["npsn"];
			$p3 = $_SESSION["tahun"];
			$p4 = $_SESSION["tahap"];
			$ps->execute();
			echo "Sukses";
		}
	}
	else{
		echo "Data Belum Lengkap";
	}
	$ps->close();
	$conn->close();
?>