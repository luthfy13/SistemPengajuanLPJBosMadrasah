<?php
	include "headerPemeriksa.php";
	include_once "conn.php";
?>

<div id="main">
	<div id="tabelDiv" style="display:inline-block;">
		<div class="loadingGif" id="loadingDiv">
			<img src="picts/loading.gif">
		</div>
		<div id="paramDiv2" style="display:inline-block; margin-right: 30px;margin-top: 10px;">
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
		<div id="paramDiv1" style="display:inline-block; margin-right: 30px;margin-top: 10px;">
			<label class="styleLabel" style="display:inline-block;">Status LPJ</label>
			<select class="styleInput" id="optStatus">
				<option value="">Semua</option>
				<option value="Pending">Pending</option>
				<option value="Proses">Proses</option>
				<option value="Diterima">Diterima</option>
				<option value="Upload Ulang">Upload Ulang</option>
				<option value="Ditolak">Ditolak</option>
			</select>
		</div>
		<br><br>
	
<?php
	
	$sql = "SELECT
				count(*) +
				IF (a.jml_k7 IS NULL, 0, a.jml_k7) AS jml,
				a.jml_k7,
				tb_lpj.npsn,
				tb_lpj.tahun,
				tb_lpj.tahap,
				tb_madrasah.jenjang,
				tb_madrasah.`status`,
				tb_madrasah.nama AS nama_madrasah,
				tb_madrasah.nama_kepsek,
				tb_user.nama AS nama_operator,
				IF (tb_penilaian.`status` IS NULL, 'Belum Ada', tb_penilaian.`status`) AS status_penilaian 
			FROM
				tb_lpj
				INNER JOIN tb_madrasah ON tb_madrasah.npsn = tb_lpj.npsn
				INNER JOIN tb_kecamatan ON tb_madrasah.id_kec = tb_kecamatan.id
				INNER JOIN tb_user ON tb_madrasah.username = tb_user.username
				LEFT JOIN tb_penilaian ON tb_penilaian.npsn = tb_lpj.npsn 
				AND tb_penilaian.tahun = tb_lpj.tahun 
				AND tb_penilaian.tahap = tb_lpj.tahap
				LEFT JOIN (SELECT npsn, tahun, tahap,IF(count(*) > 0, 1, 0 ) AS jml_k7 FROM	tb_lpj WHERE id_lampiran = 19 GROUP BY npsn,tahun,tahap) AS a ON a.npsn = tb_lpj.npsn 
				AND a.tahun = tb_lpj.tahun 
				AND a.tahap = tb_lpj.tahap 
			WHERE
				tb_lpj.id_lampiran IN (1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 14, 15) 
				AND tb_lpj.STATUS <> 'pending' 
				and
				tb_kecamatan.`wilayah` = '".$_SESSION["wilayah"]."'
			GROUP BY
				npsn, a.jml_k7, tb_lpj.tahun, tb_lpj.tahap
			HAVING
				jml = 11";
	$hasil = $conn->query($sql);
	if ($hasil->num_rows > 0){
		echo "
			<table border='1' id='tblLPJ' class='tblStyle tblPenilaian'>
			<tr>
				<th>No.</th>
				<th id='col1' class='headSort'>Tahun</th>
				<th id='col2' class='headSort'>Tahap</th>
				<th id='col3' class='headSort'>NPSN</th>
				<th id='col4' class='headSort'>Nama Madrasah</th>
				<th id='col5' class='headSort'>Nama Kepala Sekolah</th>
				<th id='col6' class='headSort'>Jenjang</th>
				<th id='col7' class='headSort'>Status Madrasah</th>
				<th id='col8' class='headSort'>Nama Operator</th>
				<th>Hasil Penilaian</th>
				<th style='display:none'>Status</th>
			</tr>
		";
		$baris=0;
		while($row = $hasil->fetch_assoc()){
			$baris++;
			$idUnik = $row["npsn"].$row["tahun"].$row["tahap"];
			$idUnik = str_replace(" ", "", $idUnik);
			$idUnik = str_replace("/", "", $idUnik);
			echo "<tr>";
			echo "<td align='center'>".$baris.".</td>";
			echo "<td>".$row["tahun"]."</td>";
			echo "<td>".$row["tahap"]."</td>";
			echo "<td>".$row["npsn"]."</td>";
			echo "<td>".$row["nama_madrasah"]."</td>";
			echo "<td>".$row["nama_kepsek"]."</td>";
			echo "<td>".$row["jenjang"]."</td>";
			echo "<td>".$row["status"]."</td>";
			echo "<td>".$row["nama_operator"]."</td>";
			echo "<td align='center' id='td".$idUnik."'> ";
				if ($row["status_penilaian"] == 'Diterima') echo "Diterima";
				else if ($row["status_penilaian"] == 'Upload Ulang') echo "Upload Ulang";
				else if ($row["status_penilaian"] == 'Ditolak') echo "Ditolak";
				echo "<button type='button' class='btnOK' 
					data-idUnik='".$idUnik."' 
					data-npsn='".$row["npsn"]."' 
					data-tahun='".$row["tahun"]."' 
					data-tahap='".$row["tahap"]."' " ; //data-idUnik untuk modiv visibility tag div
					if ($row["status_penilaian"] != 'Pending') echo "style='display:none;'";
					echo ">Berikan Penilaian</button>
					
					<div id='div".$idUnik."' ";
					if ($row["status_penilaian"] != 'Proses') echo "style='display:none;'";
					echo ">
						<button type='button' class='btnDiterima'  
						data-idUnik='".$idUnik."' 
						data-npsn='".$row["npsn"]."' 
						data-tahun='".$row["tahun"]."' 
						data-tahap='".$row["tahap"]."' >Diterima</button>
						<br>	
						<button type='button' class='btnUploadUlang' 
						data-idUnik='".$idUnik."' 
						data-npsn='".$row["npsn"]."' 
						data-tahun='".$row["tahun"]."' 
						data-tahap='".$row["tahap"]."' >Upload Ulang</button>
						<br>
						<button type='button' class='btnDitolak' 
						data-idUnik='".$idUnik."' 
						data-npsn='".$row["npsn"]."' 
						data-tahun='".$row["tahun"]."' 
						data-tahap='".$row["tahap"]."' >Ditolak</button>
					<div>

				</td>"; //data-idUnik untuk modiv visibility tag td nya
			echo "<td style='display:none' id='".$idUnik."'>".$row["status_penilaian"]."</td>";
			echo "</tr>";
		}
		$conn->close();
	}
	else{
		echo "
			<table border='1' id='tblLPJ' class='tblStyle'>
			<tr>
				<th>Belum ada data untuk diverifikasi</th>
			</tr>
		";
	}
	echo "</table>";
?>
		
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#mn2").css({
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

		function cariStatus(){
			var filter, table, tr, td, i;
				filter = $("#optStatus").val();
			table = document.getElementById("tblLPJ");
			tr = table.getElementsByTagName("tr");
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[10];
				if (td) {
					if (td.innerHTML.indexOf(filter) > -1) {
						tr[i].style.display = "";
					} else {
						tr[i].style.display = "none";
					}
				}			 
			}
		}

		function cariJenjang(){
			var filter, table, tr, td, i;
			filter = $("#optJenjang").val();
			table = document.getElementById("tblLPJ");
			tr = table.getElementsByTagName("tr");
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[6];
				if (td) {
					if (td.innerHTML.indexOf(filter) > -1) {
						tr[i].style.display = "";
					} else {
						tr[i].style.display = "none";
					}
				}			 
			}
		}
		
		function cariNmr(){
			var input, filter, table, tr, td, i;
			input = document.getElementById("txtCari");
			filter = input.value.toUpperCase();
			table = document.getElementById("tblLPJ");
			tr = table.getElementsByTagName("tr");
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[3];
				if (td) {
					if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
						tr[i].style.display = "";
					} else {
						tr[i].style.display = "none";
					}
				}			 
			}
		}

		function cariNama(){
			var input, filter, table, tr, td, i, j=0;
			input = document.getElementById("txtCari");
			filter = input.value.toUpperCase();
			table = document.getElementById("tblLPJ");
			tr = table.getElementsByTagName("tr");
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[4];
				if (td) {
					if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
						tr[i].style.display = "";
					} else {
						tr[i].style.display = "none";
						j++;
					}
					
				}			 
			}
			//edited by luthfy13 for multiple search
			if (i==j+1) cariNmr();
				
		}

		$("#txtCari").on("input", function(){
			cariNama();
			setUkuran();
		});

		$(document).on("change", "#optJenjang", function(){
			$("#optStatus").val("");
			cariJenjang();
		});

		$(document).on("change", "#optStatus", function(){
			$("#optJenjang").val("");
			cariStatus();
		});
		
		$(document).on("click", ".btnOK", function(){
			$("#loadingDiv").css("display","block");

			var idDiv, plainID;
			plainID = $(this).attr("data-idUnik");
			plainID = plainID.replace(" ","");
			plainID = plainID.replace("/","");
			idDiv = "#div" + plainID;
			$(this).css("display", "none");
			$(idDiv).css("display", "inline");
			
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$("#"+plainID).html("Proses");
					$("#loadingDiv").css("display","none");
				}
			};
			xmlhttp.open("POST", "updateStatusPenilaian.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("nilai=Proses" +
						"&npsn=" + $(this).attr("data-npsn") + 
						"&tahun=" + $(this).attr("data-tahun") + 
						"&tahap=" + $(this).attr("data-tahap")
						);
		});

		$(document).on("click", ".btnDiterima", function(){
			swal({
				  title: 'Apakah Anda yakin ingin memberikan penilaian DITERIMA?',
				  text: "LPJ yang telah diberi penilaian tidak bisa dibatalkan!",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya!',
				  cancelButtonText: 'Tidak'
				}).then((result) => {
				  if (result.value) {
					$("#loadingDiv").css("display","block");

					var idTd, plainID;
					plainID = $(this).attr("data-idUnik");
					plainID = plainID.replace(" ","");
					plainID = plainID.replace("/","");
					idTd = "#td" + plainID;
					
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							$(idTd).html("Diterima");
							$("#"+plainID).html("Diterima");
							$("#loadingDiv").css("display","none");
						}
					};
					xmlhttp.open("POST", "updateStatusPenilaian.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send("nilai=Diterima" +
								"&npsn=" + $(this).attr("data-npsn") + 
								"&tahun=" + $(this).attr("data-tahun") + 
								"&tahap=" + $(this).attr("data-tahap")
								);
				  }
				});
		});

		$(document).on("click", ".btnDitolak", function(){
			swal({
				  title: 'Apakah Anda yakin ingin memberikan penilaian DITOLAK?',
				  text: "LPJ yang telah diberi penilaian tidak bisa dibatalkan!",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Ya!',
				  cancelButtonText: 'Tidak'
				}).then((result) => {
				  if (result.value) {
					$("#loadingDiv").css("display","block");
					var idTd, plainID;
					plainID = $(this).attr("data-idUnik");
					plainID = plainID.replace(" ","");
					plainID = plainID.replace("/","");
					idTd = "#td" + plainID;
					
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							$(idTd).html("Ditolak");
							$("#"+plainID).html("Ditolak");
							$("#loadingDiv").css("display","none");
						}
					};
					xmlhttp.open("POST", "updateStatusPenilaian.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send("nilai=Ditolak" +
								"&npsn=" + $(this).attr("data-npsn") + 
								"&tahun=" + $(this).attr("data-tahun") + 
								"&tahap=" + $(this).attr("data-tahap")
								);
				  }
				});
		});

		$(document).on("click", ".btnUploadUlang", function(){
			location.href="alasanUploadUlang.php" +
						"?npsn=" + $(this).attr("data-npsn") + 
						"&tahun=" + $(this).attr("data-tahun") + 
						"&tahap=" + $(this).attr("data-tahap");
		});

		$(document).on("click", "#tblLPJ tr td:nth-child(4)", function(){
			location.href = 'detailMadrasah.php?npsn='+$(this).text();
		});

	});
// 	var list = $(".asu").map(function() {
// 		return $(this).attr("data-asu");
// 	}).get();
</script>


<?php 
	include "footer.php";
?>