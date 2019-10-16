<?php
	include "headerPemeriksa.php";
	include_once "conn.php";
?>

<div id="main">
	<div id="divAktivasi">
		<div class="loadingGif" id="loadingDiv">
			<img src="picts/loading.gif">
		</div>
		<div id="paramDiv2" style="display:inline-block;margin-right: 30px;margin-top: 10px;">
			<label class="styleLabel" style="display:inline-block;">Cari Data</label>
			<input style="display:inline-block; width:250px;" list="daftarMadrasah" placeholder="NPSN atau Nama Madrasah" name="txtCari" id="txtCari" autocomplete="off" class="styleInput">
				<datalist id="daftarMadrasah">
					<?php include 'namaMadrasahSudahUpload.php';?>
				</datalist>
			<input id="btnReset" type="button" value="Reset" class="styleButton" style="display:inline-block; padding:8px 10px;width:auto; font-family: arial" title="Reset Pencarian/Refresh Data">
		</div>
		<div id="paramDiv3" style="display:inline-block; margin-right: 30px;margin-top: 10px;">
			<label class="styleLabel" style="display:inline-block;">Jenjang</label>
			<select id="optJenjang" class="styleInput">
				<option value="">Semua</option>
				<option value="Madrasah Ibtidaiyah">MI</option>
				<option value="Madrasah Tsanawiyah">MTs</option>
				<option value="Madrasah Aliyah">MA</option>
			</select>
		</div>

		<br><br>
<?php
	
	$sql = "
				SELECT
					tb_madrasah.npsn,
					tb_madrasah.nsm,
					tb_madrasah.jenjang,
					tb_madrasah.`status`,
					tb_madrasah.nama,
					tb_madrasah.alamat,
					tb_madrasah.no_telp,
					tb_user.username,
					tb_user.`status` AS status_aktivasi 
				FROM
					tb_madrasah
					INNER JOIN tb_user ON tb_madrasah.username = tb_user.username
	";
	$hasil = $conn->query($sql);
	if ($hasil->num_rows > 0){
		echo "
			<table border='1' id='tblAktivasi' class='tblStyle'>
			<tr>
				<th>No.</th>
				<th id='col1' class='headSort'>NPSN</th>
				<th id='col2' class='headSort'>NSM</th>
				<th id='col3' class='headSort'>Nama Madrasah</th>
				<th id='col4' class='headSort'>Jenjang</th>
				<th id='col5' class='headSort'>Status</th>
				<th id='col6' class='headSort'>Alamat</th>
				<th id='col7' class='headSort'>Username</th>
				<th id='col8' class='headSort'>Aktivasi</th>
			</tr>
		";
		$baris = 0;
		while($row = $hasil->fetch_assoc()){
			$baris++;
			echo "<tr>";
			echo "<td align='center'>".$baris.".</td>";
			echo "<td>".$row["npsn"]."</td>";
			echo "<td>".$row["nsm"]."</td>";
			echo "<td>".$row["nama"]."</td>";
			echo "<td>".$row["jenjang"]."</td>";
			echo "<td>".$row["status"]."</td>";
			echo "<td>".$row["alamat"]."</td>";
			echo "<td style='font-family: courier new; font-weight:bold'>".$row["username"]."</td>";
			echo "<td align='center'>
					<button type='button' class='btnAktivasi' id='button".$row["username"]."' 
					data-username='".$row["username"]."' " ;
						if ($row["status_aktivasi"] != "belum aktif") echo "style='display:none;'";
						echo ">Aktifkan</button>
					<div class='divStatusAktivasi' id='div".$row["username"]."' title='klik untuk deaktivasi akun' 
					data-username='".$row["username"]."' style='cursor:pointer; ";
						if ($row["status_aktivasi"] == "belum aktif") echo "display:none;'";
						else echo "'";
						echo ">Aktif</div>
				</td>";
			echo "</tr>";
		}
		$conn->close();
	}
	else{
		echo "
			<table border='1' id='tblAktivasi' class='tblStyle'>
			<tr>
				<th>Belum ada data untuk diverifikasi</th>
			</tr>
		";
	}
	echo "</table>";
?>

	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#mn3").css({
			"background-color" : "green",
			"color" : "white"
		});

		function sortTable(namaTabel, n) {
		    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
		    table = document.getElementById(namaTabel);
		    switching = true;
		    //Set the sorting direction to ascending:
		    dir = "asc";
		    /*Make a loop that will continue until
		    no switching has been done:*/
		    while (switching) {
		        //start by saying: no switching is done:
		        switching = false;
		        rows = table.getElementsByTagName("TR");
		        /*Loop through all table rows (except the
		        first, which contains table headers):*/
		        for (i = 1; i < (rows.length - 1); i++) {
		            //start by saying there should be no switching:
		            shouldSwitch = false;
		            /*Get the two elements you want to compare,
		            one from current row and one from the next:*/
		            x = rows[i].getElementsByTagName("TD")[n];
		            y = rows[i + 1].getElementsByTagName("TD")[n];
		            /*check if the two rows should switch place,
		            based on the direction, asc or desc:*/
		            if (dir == "asc") {
		                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
		                    //if so, mark as a switch and break the loop:
		                    shouldSwitch = true;
		                    break;
		                }
		            } else if (dir == "desc") {
		                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
		                    //if so, mark as a switch and break the loop:
		                    shouldSwitch = true;
		                    break;
		                }
		            }
		        }
		        if (shouldSwitch) {
		            /*If a switch has been marked, make the switch
		            and mark that a switch has been done:*/
		            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
		            switching = true;
		            //Each time a switch is done, increase this count by 1:
		            switchcount++;
		        } else {
		            /*If no switching has been done AND the direction is "asc",
		            set the direction to "desc" and run the while loop again.*/
		            if (switchcount == 0 && dir == "asc") {
		                dir = "desc";
		                switching = true;
		            }
		        }
		    }
		}

		$(document).on("click", ".btnAktivasi", function(){
			$("#loadingDiv").css("display","block");

			var plainID;
			plainID = $(this).attr("data-username");
			$(this).css("display", "none");

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$("#div"+plainID).css("display", "inline");
					$("#loadingDiv").css("display","none");
				}
			};
			xmlhttp.open("POST", "updateAktivasi.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("username=" + $(this).attr("data-username") + "&nilai=aktif");
		});

		$(document).on("click", ".divStatusAktivasi", function(){
			$("#loadingDiv").css("display","block");

			var plainID;
			plainID = $(this).attr("data-username");
			$(this).css("display", "none");

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$("#button"+plainID).css("display", "inline");
					$("#loadingDiv").css("display","none");
				}
			};
			xmlhttp.open("POST", "updateAktivasi.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("username=" + $(this).attr("data-username") + "&nilai=belum aktif");
		});

		$(document).on("click", "#col1", function(){
			sortTable("tblAktivasi", 1);
		});
		$(document).on("click", "#col2", function(){
			sortTable("tblAktivasi", 2);
		});
		$(document).on("click", "#col3", function(){
			sortTable("tblAktivasi", 3);
		});
		$(document).on("click", "#col4", function(){
			sortTable("tblAktivasi", 4);
		});
		$(document).on("click", "#col5", function(){
			sortTable("tblAktivasi", 5);
		});
		$(document).on("click", "#col6", function(){
			sortTable("tblAktivasi", 6);
		});
		$(document).on("click", "#col7", function(){
			sortTable("tblAktivasi", 7);
		});
		$(document).on("click", "#col8", function(){
			sortTable("tblAktivasi", 8);
		});

	});
</script>

<?php 
	include "footer.php";
?>