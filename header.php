<!DOCTYPE html>
<html>
	<head>
		<title>Pengajuan LPJ BOS</title>
		<meta name="author" content="Lutfi Budi Ilmawan">
		<meta name="viewport" content="user-scalable = no">
		<link rel="shortcut icon" type="image/x-icon" href="picts/icon.png">
		<link rel="stylesheet" type="text/css" href="scripts/main.css">
		<style type="text/css">

			#navbar a{
				font-family: fontBiasa!important;
			}

			#caption {
				width: 600px;
				height: 130px;
				background: red;
				background: linear-gradient(to bottom right, red, green);
				box-shadow: 2px 2px 8px gray;
				opacity: 1;
				
				position:absolute; /*it can be fixed too*/
				left:0; right:0;
				top:0; bottom:0;
				margin:auto;
				
				font-size: 25px;
				font-weight: bold;
				color: white;
				text-align:center;
				padding-top: 30px;
				padding-bottom: 30px;
				line-height: 25px;
				letter-spacing: 5px;
			}
			
			#logoFooter{
				position: absolute;;
				bottom: 20px;
				right: 20px;
			}
			
			#batas1{
				padding: 40px 60px;
				background: white;
				line-height: 25px;
			}
			
			#main2{
				height: 100%; /* Used in this example to enable scrolling */
				background-image: url("picts/bglpjbos2.jpg");
				background-attachment: fixed;
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
				position: relative;
			}
			
			#divLogin{
				width: 450px;
				height: 185px;
				border-radius: 2px;
				background-color: white;
				box-shadow: 2px 2px 8px gray;
				opacity: 1;
				
				position:absolute; /*it can be fixed too*/
				left:0; right:0;
				top:0; bottom:0;
				margin:auto;
				
				font-size: 25px;
				color: gray;
				padding: 30px;
			}
			
			input[type=text], input[type=password]{
				width: 240px;
				height: 30px;
				border-radius: 2px;
				border: 1px solid lightgray;
				background: white;
				text-indent: 10px;
				font-size: 16px;
				box-shadow: 2px 2px 3px lightgray;
			}
			
			input[type=text]:HOVER,
			input[type=password]:HOVER,
			input[type=text]:FOCUS,
			input[type=password]:FOCUS{
				box-shadow: 3px 3px 4px gray;
			}
			#btnLogin, #btnBatal{
				border: 1px solid transparent;
				background-color: #4285f4;
				color: white;
				border-radius: 5px;
				margin-left: 10px;
				margin-top:10px;
				padding: 10px;
				width: 100px;
				cursor: pointer;
				position: relative;
			}
			#btnLogin:HOVER, #btnBatal:HOVER {
				background-color: #0b55cf;
				box-shadow: 3px 3px 4px gray;
				font-weight: bold;
			}
			#btnLogin:ACTIVE, #btnBatal:ACTIVE{
				background-color: #ea4335;
				font-weight: bold;
			}
			
		</style>
		<script src="scripts/jquery-3.3.1.js"></script>
		<script src="scripts/jquery.scrollintoview.js"></script>
		<script src="scripts/sweetalert2/dist/sweetalert2.js"></script>
		<link rel="stylesheet" href="scripts/sweetalert2/dist/sweetalert2.css">
		<script src="scripts/polyfill.min.js"></script>
		<script>

			
			$(document).ready(function(){

				function clrConsole(){
					console.API;

					if (typeof console._commandLineAPI !== 'undefined') {
					    console.API = console._commandLineAPI; //chrome
					} else if (typeof console._inspectorCommandLineAPI !== 'undefined') {
					    console.API = console._inspectorCommandLineAPI; //Safari
					} else if (typeof console.clear !== 'undefined') {
					    console.API = console;
					}
					console.API.clear();
				}

				//sticky navbar by luthfy13
				var h, n, b, m;
				var navbar = document.getElementById("navbar");
				function setUkuran(){					
					
					h = parseInt($("#header").height())+20; //+20 krna padding header top+bottom=20px
					n = parseInt($("#navbar").height());
					b = parseInt($("body").height());
					$("#hiddenNavbar").height(n);
 					$("#hiddenNavbar").css("display", "none");
					m = b - (h+n);
					$("#main").height(m); //jika main tidak overlap
				}
				
				function myFunction() {
					//var h = parseInt($("#header").height()) + 20;
					// clrConsole();
					// console.log(navbar);
					if (window.pageYOffset >= h) {
						navbar.classList.add("sticky");
						$("#hiddenNavbar").css("display", "block");
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
				
				$("#aLogin").click(function(){
					$("#main2").scrollintoview({
					 	duration: 500,
						direction: "vertical",
						complete: function() {
							$("#txtUser").focus();
						}
					});
				});

				$("#btnBatal").click(function(){
					$("#header").scrollintoview({
					 	duration: 500,
						direction: "vertical"
					});
				});

				function doc_keyUp(e) {
				    if (e.ctrlKey && e.altKey && e.keyCode == 76) {
				        $("#main2").scrollintoview({
						 	duration: 500,
							direction: "vertical",
							complete: function() {
								$("#txtUser").focus();
							}
						});
				    }
				    else if (e.ctrlKey && e.shiftKey && e.keyCode == 76) {
				        $("#header").scrollintoview({
						 	duration: 500,
							direction: "vertical",
							complete: function() {
								$("#txtUser").focus();
							}
						});
				    }
				}
				document.addEventListener('keyup', doc_keyUp, false);
			});
		</script>
	</head>
	<body>
		<div id="header">
			<div id="kop">
				<a href="index.php"><img id="logo" src="picts/headerLpjBos.png"></a>
			</div>
		</div>
		<div id="navbar">
			<a id="aLogin" title="CTRL + ALT + L">Login</a>
		</div>
		<div id="hiddenNavbar"></div>
		