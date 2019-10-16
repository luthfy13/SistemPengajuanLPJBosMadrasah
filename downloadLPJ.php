<?php
	include "headerPemeriksa.php";
	include_once "conn.php";
	
?>

<div id="main">
	<div id="tabelDiv" style="overflow: auto">
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
		<div id="paramDiv1" style="display:inline-block; margin-right: 30px;margin-top: 10px;">
			<label class="styleLabel" style="display:inline-block;">Status LPJ</label>
			<select class="styleInput" id="optStatus">
				<option value="">Semua</option>
				<option value="Pending">Pending</option>
				<option value="Proses">Proses</option>
				<option value="Diterima">Diterima</option>
			</select>
		</div>
		<div id="paramDiv4" style="display:inline-block; margin-right: 30px;margin-top: 10px;">
			<input id="btnDl" type="button" value="Download Semua File" class="styleButton" style="display:inline-block; width:auto;">
		</div>
		<div id="paramDiv5" style="display:inline-block; margin-right: 30px;margin-top: 10px;">
			<input id="btnInfo" type="button" value="Info Pengajuan LPJ" class="styleButton" style="display:inline-block; width:auto;">
		</div>
		<div id="paramDiv6" style="display:inline-block; margin-right: 30px;margin-top: 10px;">
			<input id="btnForceDl" type="button" title="Download Semua File (status: belum diajukan, pending, dan proses)" class="styleButton" style="display:inline-block; width:auto; background-color: #6E0000;" value="Force Download">
		</div>
		
		
		<br><br>
	
<?php
	
	$sql = "SELECT
				tb_lpj.npsn,
				tb_lpj.tahun,
				tb_lpj.tahap,
				tb_lpj.id_lampiran,
				tb_lpj.`status`,
				if(tb_lpj.keterangan is null, '-', tb_lpj.keterangan) as keterangan,
				tb_lpj.path_file,
				if(tb_lpj.bulan = 0, '', concat(' Bulan ',tb_lpj.bulan)) as bulan_panjang,
				tb_lpj.bulan,
				tb_lpj.tanggal,
				tb_madrasah.nsm,
				tb_madrasah.nama,
				tb_madrasah.`status` AS status_madrasah,
				tb_lampiran.nama AS nama_lampiran 
			FROM
				tb_lpj
				INNER JOIN tb_madrasah ON tb_madrasah.npsn = tb_lpj.npsn
				INNER JOIN tb_lampiran ON tb_lampiran.id = tb_lpj.id_lampiran 
				INNER JOIN tb_kecamatan ON tb_madrasah.id_kec = tb_kecamatan.id
			WHERE
				tb_lpj.`status` <> 'Upload Ulang'
				and
				tb_lpj.`status` <> 'Belum Diajukan'
				and
				tb_kecamatan.`wilayah` = '".$_SESSION["wilayah"]."'
			ORDER BY
				nama,
				id_lampiran";
	$hasil = $conn->query($sql);
	if ($hasil->num_rows > 0){
		echo "
			<table border='1' id='tblLPJ' class='tblStyle'>
			<thead>
			<tr>
				<th>No.</th>
				<th id='col1' class='headSort'>Tahun</th>
				<th id='col2' class='headSort'>Tahap</th>
				<th id='col3' class='headSort'>NPSN</th>
				<th id='col4' class='headSort'>NSM</th>
				<th id='col5' class='headSort'>Nama Madrasah</th>
				<th id='col6' class='headSort'>Status Madrasah</th>
				<th>Nama Lampiran</th>
				<th id='col8' class='headSort'>Taggal Upload</th>
				<th id='col9' class='headSort'>Status Lampiran</th>
				<th id='col10'>Periksa Lampiran</th>
			</tr>
			</thead>
			<tbody>
		";
		$baris = 0;
		while($row = $hasil->fetch_assoc()){
			$baris++;
			$idUnik = $row["npsn"].$row["tahun"].$row["tahap"].$row["id_lampiran"].$row["bulan"];
			$idUnik = str_replace(" ", "", $idUnik);
			$idUnik = str_replace("/", "", $idUnik);
			echo "<tr class='linkLPJ'>";
			echo "<td align='center'>".$baris.".</td>";
			echo "<td>".$row["tahun"]."</td>";
			echo "<td>".$row["tahap"]."</td>";
			echo "<td>".$row["npsn"]."</td>";
			echo "<td>".$row["nsm"]."</td>";
			echo "<td>".$row["nama"]."</td>";
			echo "<td>".$row["status_madrasah"]."</td>";
			echo "<td>".$row["nama_lampiran"].$row["bulan_panjang"]."</td>";
			echo "<td>".$row["tanggal"]."</td>";
			echo "<td class='tdStatus' id='".$idUnik."'>".$row["status"]."</td>";
			echo "<td align='center'>
					<button type='button' class='btnPeriksa' id='button".$idUnik."' 
					data-idUnik='".$idUnik."' 
					data-npsn='".$row["npsn"]."' 
					data-tahun='".$row["tahun"]."' 
					data-tahap='".$row["tahap"]."' 
					data-bulan='".$row["bulan"]."' 
					data-idLampiran='".$row["id_lampiran"]."' " ; //data-idUnik untuk modiv visibility tag td dan tag link
						if ($row["status"] != "Pending") echo "style='display:none;'";
						echo ">Periksa</button>
					<a href='".$row["path_file"]."' id='link".$idUnik."' ";
						if ($row["status"] == "Pending") echo "style='display:none;'";
						echo ">Download</a>
				</td>";
			echo "</tr>";
		}
		$conn->close();
	}
	else{
		echo "
			<table border='1' id='tblLPJ' class='tblStyle'>
			<tbody>
			<tr>
				<th>Belum ada data untuk diverifikasi</th>
			</tr>
		";
	}
	echo "</tbody></table>";
?>
		
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#mn1").css({
			"background-color" : "green",
			"color" : "white"
		});

		function createPagination(){
			$('#tblLPJ').after('<div id="nav"></div>');
			var rowsShown = 4;
			var rowsTotal = $('#tblLPJ tbody tr').length;
			var numPages = rowsTotal/rowsShown;
			for(i = 0;i < numPages;i++) {
			    var pageNum = i + 1;
			    $('#nav').append('<a href="#" rel="'+i+'">'+pageNum+'</a> ');
			}
			$('#tblLPJ tbody tr').hide();
			$('#tblLPJ tbody tr').slice(0, rowsShown).show();
			$('#nav a:first').addClass('active');
			$('#nav a').bind('click', function(){

			    $('#nav a').removeClass('active');
			    $(this).addClass('active');
			    var currPage = $(this).attr('rel');
			    var startItem = currPage * rowsShown;
			    var endItem = startItem + rowsShown;
			    $('#tblLPJ tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
			    css('display','table-row').animate({opacity:1}, 300);
			});
		}
		
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
				
					td = tr[i].getElementsByTagName("td")[5];
					if (td) {
						if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
							tr[i].style.display = "";
							tr[i].classList.add('linkLPJ');
						} else {
							tr[i].style.display = "none";
							tr[i].classList.remove('linkLPJ');
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
		
		$(document).on("click", ".btnPeriksa", function(){
			$("#loadingDiv").css("display","block");

			var idTd, idLink, plainID;
			plainID = $(this).attr("data-idUnik");
			plainID = plainID.replace(" ","");
			plainID = plainID.replace("/","");
			idTd = "#" + plainID;
			idLink = "#link" + plainID;
			$(idTd).text('Proses');
			$(this).css("display", "none");
			$(idLink).css("display", "inline");

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$("#loadingDiv").css("display","none");
				}
			};
			xmlhttp.open("POST", "updateStatusLPJ.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("npsn=" + $(this).attr("data-npsn") + 
						"&tahun=" + $(this).attr("data-tahun") + 
						"&tahap=" + $(this).attr("data-tahap") + 
						"&id_lampiran=" + $(this).attr("data-idLampiran") +
						"&bulan=" + $(this).attr("data-bulan")
						);
		});

		$("#btnReset").click(function(){
			location.reload();
		});

		$("#optStatus").change(function(){
			$("#txtCari").val("");
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				$("#tblLPJ").html(this.responseText);
					$("#loadingDiv").css("display","none");
					setUkuran();
				}
			};
			xmlhttp.open("POST", "tampilPengajuanLPJ.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("optStatus=" + $("#optStatus").val() + "&optJenjang=" + $("#optJenjang").val());
		});

		$("#optJenjang").change(function(){
			$("#txtCari").val("");
			$("#loadingDiv").css("display","block");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				$("#tblLPJ").html(this.responseText);
					$("#loadingDiv").css("display","none");
					setUkuran();
				}
			};
			xmlhttp.open("POST", "tampilPengajuanLPJJenjang.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("optStatus=" + $("#optStatus").val() + "&optJenjang=" + $("#optJenjang").val());
		});

		$(document).on("click", "#btnDl", function(){
			$("#loadingDiv").css("display","block");
			var daftarDownload = $("tr.linkLPJ a").map(function() {
				return $(this).attr("href");
			}).get();
			if (daftarDownload == ""){
				if ($("#optStatus").val() == "Semua")
					swal("Belum ada data yang diupload oleh madrasah!!!");
				else
					swal("Belum ada data dengan status " + $("#optStatus").val());
				$("#loadingDiv").css("display","none");
				return;
			}
			var objLink = JSON.stringify(daftarDownload);

			var daftarIdStatus = $("tr.linkLPJ td.tdStatus").map(function() {
				return $(this).attr("id");
			}).get();
			var i=0;
			
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$("#loadingDiv").css("display","none");
					if(this.responseText == "Sukses"){
						for(i=0; i<daftarIdStatus.length; i++){
							$(daftarIdStatus[i]).html("Proses");
							$("#button"+daftarIdStatus[i]).css("display", "none");
							$("#link"+daftarIdStatus[i]).css("display", "inline");
						}
						var namaUser = '<?php echo $_SESSION["userLogin"]; ?>';
						location.href = './FileLPJ-'+namaUser+'.zip';
						$("#loadingDiv").css("display","none");
						// setTimeout(function() {
						// 	location.reload();
						// }, 2000);
					}
					else
						swal(this.responseText);
				}
			};
			xmlhttp.open("POST", "generateZip.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("jsondata=" + objLink);
		});

		$(document).on("click", "#btnInfo", function(){
			location.href = "detailPengajuanMadrasah.php";
		});

		$("#txtCari").click(function () {
		   $("#txtCari").select();
		});

		$(document).on("click", "#col1", function(){
			sortTable("tblLPJ", 1);
		});
		$(document).on("click", "#col2", function(){
			sortTable("tblLPJ", 2);
		});
		$(document).on("click", "#col3", function(){
			sortTable("tblLPJ", 3);
		});
		$(document).on("click", "#col4", function(){
			sortTable("tblLPJ", 4);
		});
		$(document).on("click", "#col5", function(){
			sortTable("tblLPJ", 5);
		});
		$(document).on("click", "#col6", function(){
			sortTable("tblLPJ", 6);
		});
		$(document).on("click", "#col8", function(){
			sortTable("tblLPJ", 8);
		});
		$(document).on("click", "#col9", function(){
			sortTable("tblLPJ", 9);
		});

		$(document).on("click", "#btnForceDl", function(){
			window.open('fileLPJ/','_blank');	
		});
	});
// 	var list = $(".asu").map(function() {
// 		return $(this).attr("data-asu");
// 	}).get();
</script>


<?php 
	include "footer.php";
?>