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
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Pengajuan LPJ BOS</title>
		<meta name="author" content="Lutfi Budi Ilmawan">
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
		<meta name="viewport" content="user-scalable = no">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="picts/icon.png">
		<link rel="stylesheet" type="text/css" href="scripts/main.css">
		<link rel="stylesheet" type="text/css" href="scripts/combobox-style.css">
		<link rel="stylesheet" type="text/css" href="scripts/progressbar.css">
		<style type="text/css">
			
			#daftarMadrasah option{
				color:red;
			}
			
					
			#tabelDiv, #divDetailPengajuanMadrasah, #divAktivasi{
				width: 85%;
				position: absolute;
				left:0; right:0;
				margin: auto;
				top: 15px;
			}
			
			.headSort:hover{
				background-color: darkgreen;
				cursor: pointer;
			}

			div#isiMain{
				width:85%;
				position: absolute;
				left:0; right:0;
				margin: auto;
				top: 20px;
				background-color: white;
				border-radius: 10px;
				box-shadow: 3px 3px 5px gray;
			}

			div.kolom1, div.kolom2, div.kolom3{
				float: left;
				margin-right: 2%; 
			}

			div.baris{
				overflow: hidden;
				padding: 20px;
			}

			.kolom1{
				width:22%;
			}
			.kolom2{
				width:50%;
			}
			.kolom3{
				width:22%;
			}


			div#isiMain label{
				display: block;
				width: 100%;

			}

			div#isiMain input{
				width: 100%;
			}

			div#isiMain select{
				width: 100%;
			}

			div#isiMain textarea {
			    resize: none;
			}

			table.tbInfoLPJ tr:hover{
				background-color: gray;
				color: white;
			}

			#isiDataPemeriksa{
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

			#isiDataPemeriksa input[type=text]{
				width: 100%;
			}
			#isiDataPemeriksa input[type=submit]{
				width: 100%;
			}

			.tblPenilaian tr td:nth-child(4):hover{
				cursor: pointer;
				color: #0072FF;
			}

			.tblPenilaian tr td:nth-child(4){
				color: #00750B;
			}

			@media screen and (max-width: 600px) {
				div.kolom1, div.kolom2, div.kolom3{
					width: 100%;
					margin-right: 0;
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
				//alert(totalLineWidth + "\n" +isiMain + "\n" + m)
				if (isiMain >= m-20) m = isiMain+50;
				$("#main").height(m); //jika main tidak overlap
			}
			
			$(document).ready(function(){

				var navbar = document.getElementById("navbar");
				var nama, lebar;
				nama = $("#mn6").html();
				lebar = $("#mn6").width();
				$("#mn6").width(lebar);
				
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
					setButtonWidth();
				});

				$(window).on("resize", function(){
					setUkuran();
					setButtonWidth();
				});

				setUkuran();
				//--------------end of sticky navbar---------------------------------

				function setButtonWidth(){
					var w = parseInt($("div#isiMain .styleButton").css("width")) || 0;
					if (w<=95){
						$("div#isiMain .btnFormUlang").attr("value", "+");
					}
					else{
						$("div#isiMain .btnFormUlang").attr("value", "Tambahkan");
					}
				}

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
			<a id="mn1" href="downloadLPJ.php">Periksa LPJ</a>
			<a id="mn2" href="penilaianLPJ.php">Penilaian LPJ</a>
			<a id="mn3" href="aktivasiUser.php">Aktivasi User</a>
			<a id="mn4" href="editDataPemeriksa.php">Data Pemeriksa</a>
			<a id="mn5" href="pdf/juknisBosMadrasah2018.pdf">Download JUKNIS BOS 2018</a>
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
				if (page == 'editDataPemeriksa.php') return;
				swal({
							title: 'Password Belum Diganti!',
							text: 'Anda masih menggunakan password default! Demi keamanan akun, silakan Ganti Password Anda!',
							type: 'warning',
							allowOutsideClick: false,
							allowEscapeKey: false,
							allowEnterKey: true,
							heightAuto: false
						}).then(function(){
							location.href = 'editDataPemeriksa.php';
						});
			});
			</script>
		";
	}

?>