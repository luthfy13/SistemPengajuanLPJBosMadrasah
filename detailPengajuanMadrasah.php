<?php
	include "headerPemeriksa.php";
	include_once "conn.php";
?>

<div id="main">
	<div id="divDetailPengajuanMadrasah" style="display:inline-block;margin:auto;">
		<div class="loadingGif" id="loadingDiv">
			<img src="picts/loading.gif">
		</div>

		<div id="paramDiv2" style="float:left; margin-right: 30px;margin-top: 10px; border:1px solid #4859FF; border-radius: 5px; padding:10px; background-color: white; color:#484848;">
			<table style="margin:auto;" class='tbInfoLPJ'>
				<tr>
					<th colspan='3' align='left'>Madrasah yang telah mengajukan LPJ:</th>
				</tr>
				
<?php
	$sql = "SELECT
				npsn,
				nama,
				jenjang 
			FROM
				tb_madrasah 
			WHERE
				npsn IN ( SELECT distinct npsn FROM tb_lpj) 
			ORDER BY
				jenjang = 'madrasah aliyah',
				jenjang = 'madrasah tsanawiyah',
				jenjang = 'madrasah ibtidaiyah'";
	$hasil = $conn->query($sql);
	if ($hasil->num_rows > 0){
		$baris = 0;
		while($row = $hasil->fetch_assoc()){
			$baris++;
			echo "<tr>";
			echo "<td>".$baris.".</td>";
			echo "<td>".$row["npsn"]."</td>";
			echo "<td>".$row["nama"]."</td>";
			echo "</tr>";
		}
	}
	else{
		echo "
			<tr>
				<th colspan='3'>-</th>
			</tr>
		";
	}
?>

			</table>
		</div>

		<div id="paramDiv3" style="float:left; margin-right: 30px;margin-top: 10px; border:1px solid #4859FF; border-radius: 5px; padding:10px; background-color: white; color:#484848;"">
			<table style="margin:auto;" class='tbInfoLPJ'>
				<tr>
					<th colspan='3' align='left'>Madrasah yang belum mengajukan LPJ:</th>
				</tr>
				
<?php
	$sql = "SELECT
				npsn,
				nama,
				jenjang 
			FROM
				tb_madrasah 
			WHERE
				npsn NOT IN ( SELECT distinct npsn FROM tb_lpj ) 
			ORDER BY
				jenjang = 'madrasah aliyah',
				jenjang = 'madrasah tsanawiyah',
				jenjang = 'madrasah ibtidaiyah'";
	$hasil = $conn->query($sql);
	if ($hasil->num_rows > 0){
		$baris = 0;
		while($row = $hasil->fetch_assoc()){
			$baris++;
			echo "<tr>";
			echo "<td>".$baris.".</td>";
			echo "<td>".$row["npsn"]."</td>";
			echo "<td>".$row["nama"]."</td>";
			echo "</tr>";
		}
	}
	else{
		echo "
			<tr>
				<th colspan='3'>-</th>
			</tr>
		";
	}
	$conn->close();
?>

			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#mn1").css({
			"background-color" : "green",
			"color" : "white"
		});
		

	});
// 	var list = $(".asu").map(function() {
// 		return $(this).attr("data-asu");
// 	}).get();
</script>


<?php 
	include "footer.php";
?>