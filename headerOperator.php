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
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	$userAgent = "Desktop";
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
	$userAgent = "Mobile";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Pengajuan LPJ BOS</title>
		<meta name="author" content="Lutfi Budi Ilmawan">
		<?php
			if ($userAgent == "Desktop")
				echo '<meta name="viewport" content="user-scalable = no">';
			else if ($userAgent == "Mobile")
				echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		?>
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
				background-color: green!important;
				cursor: pointer!important;
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
		<script src="scripts/jquery.scrollintoview.js"></script>
		<script>
			
			$(document).ready(function(){
				var nama, lebar;
				nama = $("#mn6").html();
				lebar = $("#mn6").width();
				$("#mn6").width(lebar);

				var userAgent = "<?php echo $userAgent; ?>";
				if (userAgent == "Desktop"){
					$("#sideMenu").fadeIn(500);
					$("#sideMenuKanan").fadeIn(500);
				}

				//sticky navbar + mainheight by luthfy13
				var h, n, b, m, bw, pwt, pwb, mt, totalLineWidth;
				var navbar = document.getElementById("navbar");
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
				
				function myFunction() {
					var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
					if (window.pageYOffset >= h) {
						navbar.classList.add("sticky");
						if (userAgent == "Mobile"){
							$("#sideMenu").fadeIn(500);
							$("#sideMenuKanan").fadeIn(500);
						}
						
						if (w > 600){
							$("#hiddenNavbar").css("display", "block");
						}
					}
					else {
						navbar.classList.remove("sticky");
						if (userAgent == "Mobile"){
							$("#sideMenu").fadeOut(500);
							$("#sideMenuKanan").fadeOut(500);
						}
						
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
				//--------------end of sticky navbar--------------------------------

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

				//--------------------------------------------------------------------

				    $('a.navSide').on('click', function(event) {
				        var target = $(this.getAttribute('href'));
				        if( target.length ) {
				            event.preventDefault();
				            $('html, body').stop().animate({
				                scrollTop: target.offset().top-50
				            }, 400);
				        }
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