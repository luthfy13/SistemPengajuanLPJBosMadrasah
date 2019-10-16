<?php
	include "headerPemeriksa.php";
	include_once "conn.php";
	
	$ps = $conn->stmt_init();
	$ps->prepare("select * from tb_user where username = ?");
	$ps->bind_param("s", $p1);
	$p1 = $_SESSION["userLogin"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$rowHasil = $hasil->fetch_assoc();
	}
	else{
		echo "<script> location.replace('index.php'); </script>";
		exit();
	}

	$ps = $conn->stmt_init();
	$ps->prepare("select * from tb_user where username = ? and password=password(?)");
	$ps->bind_param("ss", $p1, $p2);
	$p1 = $_SESSION["userLogin"];
	$p2 = "userLPJ";
	$ps->execute();
	$adadeh = "";
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$adadeh = "engka";
	}
	else{
		$adadeh = "degaga";
	}
	
	
	$ps->close();
	$conn->close();
?>

<div id="main">
<div id="isiDataPemeriksa">
	<div class="loadingGif" id="loadingDiv">
			<img src="picts/loading.gif">
	</div>
	<form method="post" action="simpanDataPemeriksa.php">
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Nama Pemeriksa</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtNamaPemeriksa" name="txtNamaPemeriksa" value="<?php echo $rowHasil["nama"];?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Username</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtUser" name="txtUser" value="<?php echo $rowHasil["username"];?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">E-Mail</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="text" id="txtEmail" name="txtEmail" value="<?php echo $rowHasil["email"];?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="kolomDM1">
				<label class="styleLabel">Password</label>
			</div>
			<div class="kolomDM2">
				<input class="styleInput" type="password" id="txtPass" name="txtPass" style="width:80%; float:left; font-family: fontTipis;">
				<input class="styleButton" type="button" style="float:right;width:18%; padding:10px; background-color: gray; border: 1px solid black; color:white; border-radius:4px;font-family: fontTipis;" value="Lihat Password" id="btnLihat">
			</div>
		</div>
		
		<div class="baris" style="box-sizing: border-box;">
			<input class="styleButton" style="font-size: 120%; margin-top: 10px; width:100%; box-sizing: border-box; box-shadow: initial;" type="submit" value="Simpan Data Pemeriksa" name="btnSimpan" id="btnSimpan">
		</div>
		
	</form>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		var x;
		x = "<?php echo $adadeh; ?>";
		if (x == "engka"){
			$("#txtPass").focus();
		}
		else{
			$("#txtNamaPemeriksa").select();
			$("#txtNamaPemeriksa").focus();
		}


		$("#mn4").css({
			"background-color" : "green",
			"color" : "white"
		});
		
// 		$("#optKec").change(function(){
// 			var xmlhttp = new XMLHttpRequest();
// 			xmlhttp.onreadystatechange = function() {
// 			    if (this.readyState == 4 && this.status == 200) {
// 			        $("#optKel").html(this.responseText);
// 			    }
// 			};
// 			xmlhttp.open("POST", "namaKelurahan.php", false);
// 			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 			xmlhttp.send("idKec=" + $("#optKec").val());
// 		});

		$("#btnLihat").click(function(){
			var x = document.getElementById("txtPass");
			
		    if (x.type === "password") {
		    	$("#btnLihat").css("background-color", "red");
		    	$(this).attr("value", "Sembunyi Password");
		        x.type = "text";
		    } else {
		    	$("#btnLihat").css("background-color", "gray");
		    	$(this).attr("value", "Lihat Password");
		        x.type = "password";
		    }
		});

		$(document).on("click", "#btnSimpan", function(e){
			if ($("#txtUser").val() == ""){
				e.preventDefault();
				swal("Gagal Menyimpan", "Username belum dimasukkan!!!", "error");
			}
		});

		$(document).on("focusout", "#txtUser", function(){
			var userName = '<?php echo $_SESSION["userLogin"]?>';
			var userName2 = $("#txtUser").val();
			if (userName == userName2 || userName2 == "") return;
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			        if (this.responseText == "ada"){
			        	$("#txtUser").val("");
			        	$("#txtUser").attr("placeholder", userName2 + " telah digunakan oleh pengguna yang lain");
				    }
			        $("#loadingDiv").css("display","none");
			    }
			};
			xmlhttp.open("POST", "cekUsername.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("username=" + userName2);
		});

		$(document).on("focus", "#txtUser", function(){
			$("#txtUser").removeAttr("placeholder");
		});
	});
</script>


<?php 
	include "footer.php";
?>