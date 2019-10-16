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
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Pengajuan LPJ BOS</title>
		<meta name="author" content="Lutfi Budi Ilmawan">
		<meta name="viewport" content="user-scalable = no">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="picts/icon.png">
		<link rel="stylesheet" type="text/css" href="scripts/main.css">
		<link rel="stylesheet" type="text/css" href="scripts/combobox-style.css">
		<link rel="stylesheet" type="text/css" href="scripts/progressbar.css">
		<style type="text/css">
					
			#divForm {
				width:300px;
				margin:auto;
				position:absolute; /*it can be fixed too*/
				left:0; right:0;
				top: 100px;
				
			}
			
			#btnLanjut{
				width: 300px;
				padding: 8px 16px;
				font-size: 32px;
				background-color: Gray;
				color: white;
				border: 1px solid transparent;
				cursor: pointer;
			}
			
			#btnLanjut:hover{
				background-color: white;
				color: gray;
				box-shadow: 3px 3px 5px gray;
			}
			
			label, input{
				width: 100%;
			}
			
			input{
				background-color: white;
			}
			
			.baris{
				overflow: hidden;
				box-sizing: border-box;
			}
			
			.judul{
				text-align: center;
				font-size: 20px;
			}
			
			.kolom1{
				width: 80%;
				float: left;
				padding: 3px;
			}
			
			.kolom2{
				width: 20%;
				float: right;
				padding: 3px;
			}

			.kolom3{
				width: 20%;
				float: right;
				padding: 3px;
			}
			
			.kolomDM1{
				width: 30%;
				float: left;
				padding: 3px;
				box-sizing: border-box;
			}
			
			.kolomDM2{
				width: 70%;
				float: left;
				padding: 3px;
				box-sizing: border-box;
			}
			
			#isiLPJ{
				width: 60%;
				position: absolute;
				left:0; right:0;
				margin: auto;
			}
			
			#isiMainTbl{
				width: 85%;
				position: absolute;
				left:0; right:0;
				margin: auto;
				top: 15px;
			}
			
			#isiDataMadrasah{
				box-sizing: border-box;
				width: 70%;
				position: absolute;
				left:0; right:0;
				margin: auto;
				top: 15px;
				padding:40px 20px;
				margin-top: 20px;
				box-shadow: 3px 3px 5px gray;
				border: 1px solid black;
				border-radius: 5px;
				font-weight: bolder;
				color: black;
				background-color: white;
			}
			
			.uploadForm{
				padding: 15px;
				border: 1px solid green;
				background-color: #FFFFFF;
				border-radius: 5px;
				margin-top: 50px;
				box-shadow: 2px 2px 5px gray;
				color: darkred;
			}
			
			input[type=file]{
				border: 1px solid green;
				border-radius: 4px;
				padding: 8px;
			}
			
			.styleInput{
				width: 100%;
			}
			
			
			.btnSubmitFile{
				padding: 11px;
				border: 1px solid black;
				border-radius: 4px;
				background-color: gray;
				color: white;
			}
			
			.btnSubmitFile:hover:enabled{
				background-color: green;
				cursor: pointer;
			}
			
			.imgHelp:HOVER{
				filter: invert(100%);
				cursor: pointer;
			}

			#tblStatusLPJ a{
				text-decoration: none;
				color: #005528;
			}

			#tblStatusLPJ a:hover{
				color: #BA00B8;
			}
			
			@media screen and (max-width: 600px) {
			    .kolom1, .kolom2, .kolom3{
			        width: 100%;
			        margin-top: 0;
			        float: left;
			    }
			    .baris{
					padding: 5px;
				}
				
				input[type=file]{
					border: 1px solid black;
					border-radius: 4px;
					padding: 0px;
				}
				
				.btnSubmitFile{
					padding: 0px;
					height: 40px;
					border: 1px solid black;
					border-radius: 4px;
				}
				
				#isiDataMadrasah{
					width: 80%;
				}
				
				.kolomDM1,.kolomDM2{
					width: 100%;
					float: left;
					padding: 3px;
				}
				
			}
			
		</style>
		<script src="scripts/jquery-3.3.1.js"></script>
		<script src="scripts/jquery.form.min.js"></script>
		<script src="scripts/sweetalert2/dist/sweetalert2.js"></script>
		<link rel="stylesheet" href="scripts/sweetalert2/dist/sweetalert2.css">
		<script src="scripts/polyfill.min.js"></script>
		<script>

			var h, n, b, m, bw, pwt, pwb, mt, totalLineWidth;
			function setUkuran(){					
					
					h = parseInt($("#header").height())+20; //+20 krna padding header top+bottom=20px
					n = parseInt($("#navbar").height());
					b = parseInt($("body").height());

					$("#hiddenNavbar").height(n);
					$("#hiddenNavbar").css("display", "none");

					isiMain = parseInt($("#main > :first-child").height());
					bw = parseInt($("#main > :first-child").css("border-top-width")) || 0;
					pwt = parseInt($("#main > :first-child").css("padding-top")) || 0;
					pwb = parseInt($("#main > :first-child").css("padding-bottom")) || 0;
					mt = parseInt($("#main > :first-child").css("margin-top")) || 0;
					totalLineWidth = bw + pwt + pwb + mt;
					isiMain = isiMain + totalLineWidth;
					
					m = b - (h+n);
					
					if (isiMain >= m-20){
						// alert(mt + "\n" +isiMain + "\n" + m);
						m = isiMain+50;
					}
					$("#main").height(m); //jika main tidak overlap
				}
			
			$(document).ready(function(){
				var nama, lebar;
				nama = $("#mn6").html();
				lebar = $("#mn6").width();
				$("#mn6").width(lebar);

				//sticky navbar + mainheight by luthfy13
				
				var navbar = document.getElementById("navbar");
				
				function myFunction() {
					var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
					if (window.pageYOffset >= h) {
						navbar.classList.add("sticky");
						if (w > 600){
							$("#hiddenNavbar").css("display", "block");
						}
					}
					else {
						navbar.classList.remove("sticky");
						$("#hiddenNavbar").css("display", "none");
					}
				}
				
				window.onscroll = function() {myFunction()};

				$(window).on("load", function(){
					setUkuran();
				});

				$(window).on("resize", function(){
					setUkuran();
				});

				setUkuran();
				//--------------end of sticky navbar---------------------------------

				$(document).on("mouseenter", "#mn6", function(){
					$("#mn6").fadeOut(200, function() {
						$("#mn6").text("Logout \u25B2").fadeIn(200);
					});
				});

				$(document).on("mouseout", "#mn6", function(){
					$("#mn6").fadeOut(200, function() {
						$("#mn6").text(nama).fadeIn(200);
					});
				});
			});
		</script>
		
	</head>
	<body>
		<div id="header">
			<div id="kop">
				<a href="index.php"><img id="logo" src="picts/headerLpjBos.png" /></a>
			</div>
		</div>
		
		<div id="navbar">
			<a id="mn1" href="pengajuanLPJ.php">Pengajuan LPJ Dana BOS</a>
			<a id="mn2" href="cekStatusLPJ.php">Cek Status Pengajuan LPJ</a>
			<a id="mn3" href="editDataMadrasah.php">Data Madrasah</a>
			<a id="mn4" href="editDataOperator.php">Data Operator</a>
			<a id="mn5" href="menuDownloadOperator.php">Download</a>
			<a id="mn6" href="logout.php">
				Selamat datang<?php echo " ".$_SESSION["namaUser"]." "?> &#x25BC;
			</a>
		</div>
		<div id="hiddenNavbar"></div>

<?php
	include_once "conn.php";

	$ps = $conn->stmt_init();
	$ps->prepare("select * from tb_user where username = ? and password=password(?)");
	$ps->bind_param("ss", $p1, $p2);
	$p1 = $_SESSION["userLogin"];
	$p2 = "userLPJ";
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		echo"
			<script>
			$(document).ready(function(){
				var path = window.location.pathname;
				var page = path.split('/').pop();
				if (page == 'editDataOperator.php' || page == 'editDataMadrasah.php') return;
				swal({
							title: 'Password Belum Diganti!',
							text: 'Anda masih menggunakan password default! Demi keamanan akun, silakan Ganti Password Anda!',
							type: 'warning',
							allowOutsideClick: false,
							allowEscapeKey: false,
							allowEnterKey: true,
							heightAuto: false
						}).then(function(){
							location.href = 'editDataOperator.php';
						});
			});
			</script>
		";
	}

	$ps = $conn->stmt_init();
	$ps->prepare("select npsn from tb_madrasah where npsn = ? and (id_kel is null or id_kel = ? or id_kel = ?)");
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_SESSION["npsn"];
	$p2 = "";
	$p3	 = "0";
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		echo"
			<script>
			$(document).ready(function(){
				var path = window.location.pathname;
				var page = path.split('/').pop();
				if (page == 'editDataMadrasah.php' || page == 'editDataOperator.php') return;
				swal({
							title: 'Data Madrasah belum lengkap!',
							text: 'Silakan isi data kelurahan dan kecamatan terlebih dahulu!',
							type: 'warning',
							allowOutsideClick: false,
							allowEscapeKey: false,
							allowEnterKey: true,
							heightAuto: false
						}).then(function(){
							location.href = 'editDataMadrasah.php';
						});
			});
			</script>
		";
	}

?>