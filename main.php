<div id="main">
	<div id="caption">
		SELAMAT DATANG DI WEBSITE<br>PENGAJUAN LPJ DANA BOS<br>KABUPATEN WAJO
	</div>
	<div id="logoFooter">
		<img id="logo" src="picts/logofooter.png" width="300" />
	</div>
</div>

<div id="batas1">
	<h3 style="text-align:center;font-size: 28px; color:black;letter-spacing: 10px;">DANA BOS</h3>
	<p style="text-align:justify;font-size: 16px; color:#777;">
		BOS adalah program pemerintah yang pada dasarnya adalah untuk
		penyediaan pendanaan biaya operasional non personalia bagi satuan
		pendidikan dasar sebagai pelaksana program wajib belajar. Menurut
		PP 48 Tahun 2008 Tentang Pendanaan Pendidikan, biaya non
		personalia adalah biaya untuk bahan atau peralatan pendidikan habis
		pakai, dan biaya tidak langsung berupa daya, air, jasa, telekomunikasi,
		pemeliharaan sarana dan prasarana, uang lembur, transportasi,
		konsumsi, pajak, asuransi, dll. Namun demikian, ada beberapa jenis
		pembiayaan personalia yang diperbolehkan dibiayai dengan dana BOS.
		Secara detail jenis kegiatan yang boleh dibiayai dari dana BOS dibahas
		pada bagian penggunaan dana BOS.
	</p>
</div>

<div id="main2">
	<div id="divLogin">
		<form id="formLogin">
			<table>
				<tr>
					<td width="400">Username</td>
					<td><input type="text" id="txtUser" name="txtUser" autocomplete="off"></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="txtPwd" id="txtPwd"></td>
				</tr>
				<tr>
					<td></td>
					<td align="right">
						<button id="btnLogin" type="submit">
							Login
							<div style="position: absolute; left: 2; top:2px;display: none" id="loadingSmall">
									<img src="picts/loading-small.gif">
							</div>
						</button>
						<input id="btnBatal" type="button" value="Batal">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		function login(){
			if ($("#txtUser").val() == "") return;
			else if ($("#txtPwd").val() == "") return;
			var isi = $("#btnLogin").html();
			$("#btnLogin").html("&ensp;&ensp;"+isi);
			$("#loadingSmall").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	$("#btnLogin").html(isi);
			        $("#loadingSmall").css("display","none");
			        if (this.responseText == "sukses"){
			        	swal({
							title: "Login berhasil!",
							type: "success",
							allowOutsideClick: false,
							showConfirmButton: false,
							timer: 1000,
							heightAuto: false
						}).then(function(){
							location.href = "index.php";
						});
				    }
				    else{
				    	swal({
							title: "Login gagal!",
							text: "Username atau Password salah!",
							type: "error",
							allowOutsideClick: false,
							heightAuto: false
						}).then(function(){
							setTimeout(function() {
								$("#txtUser").val("");
								$("#txtPwd").val("");
								$("#txtUser").focus();
							}, 500);
						});
				    }
			    }
			};
			xmlhttp.open("POST", "prosesLogin.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("txtUser=" + $("#txtUser").val() + "&txtPwd=" + $("#txtPwd").val());
		}

		$(document).on("click", "#btnLogin", function(e){
			e.preventDefault();
			login();
		});

		
	});
</script>