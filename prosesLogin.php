<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	function login() {
		include_once "conn.php";
		
		$sql = "
				SELECT
					tb_user.username,
					tb_user.`password`,
					tb_user.`level`,
					tb_user.nama,
					tb_user.`status`,
					tb_user.`wilayah`,
					tb_madrasah.npsn,
					tb_madrasah.jenjang 
				FROM
					tb_user
					LEFT JOIN tb_madrasah ON tb_madrasah.username = tb_user.username 
				WHERE
					tb_user.username = ? 
					AND `password` = PASSWORD ( ? ) 
					AND tb_user.`status` = 'aktif'
				";
		$ps = $conn->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("ss", $user, $pwd);
		$user = $_POST["txtUser"];
		$pwd = $_POST["txtPwd"];
		$ps->execute();
		$hasil = $ps->get_result();
		
		if ($hasil->num_rows > 0){
			$_SESSION["loginStat"] = "login berhasil";
			$row = $hasil->fetch_assoc();
			$_SESSION["userLogin"] = $row["username"];
			$_SESSION["namaUser"] = $row["nama"];
			$level = $row["level"];
			$_SESSION["wilayah"] = $row["wilayah"];
			$_SESSION["npsn"] = $row["npsn"];
			$_SESSION["jenjang"] = $row["jenjang"];
			
			$hasil = $conn->query("select * from tb_tahun_tahap");
			$row = $hasil->fetch_assoc();
			$_SESSION["tahun"] = $row["tahun"];
			$_SESSION["tahap"] = $row["tahap"];
			
			if($level == "operator"){
				$_SESSION["loginStat"] = "operator LPJ login";
			}
			else if($level == "pemeriksa"){
				$_SESSION["loginStat"] = "pemeriksa login";
			}
			echo "sukses";
		}
		else{
			$ps->close();
			$conn->close();
			$_SESSION["loginStat"] = "login gagal";
			echo "gagal";
		}
	}

	login();
 ?>