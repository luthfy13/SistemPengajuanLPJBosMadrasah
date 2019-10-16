<?php
	include "headerOperator2.php";

	function getNumPagesInPDF($file) {
		$max=0;
		$pdftext = file_get_contents($file);
		$max = preg_match_all("/\/Page\W/", $pdftext, $dummy);

		if ($max == 0){
			if(!file_exists($file))return null;
			if (!$fp = @fopen($file,"r"))return null;
			while(!feof($fp)) {
					$line = fgets($fp,255);
					if (preg_match('/\/Count [0-9]+/', $line, $matches)){
							preg_match('/[0-9]+/',$matches[0], $matches2);
							if ($max<$matches2[0]) $max=$matches2[0];
					}
			}
			fclose($fp);
		}

		return (int)$max;
	}

	// function getNumPagesInPDF($filename)
	// {
	// 	require_once('scripts/PDFMerger/fpdi/fpdi.php');
	// 	$pdf = new FPDI();
	// 	$pageCount = $pdf->setSourceFile($filename);

	// 	unlink($filename);
	// 	return $pageCount;
	// }

	// function execEnabled() 
	// {
	//   $arrDisabled = explode(',', ini_get('disable_functions'));
	//   return (!in_array('exec', $arrDisabled));
	// }


	// echo execEnabled();

	// function getNumPagesInPDF($document)
	// {
	//			  // Linux
	//	 $cmd = "pdfinfo.exe";  // Windows

	//	 // Parse entire output
	//	 // Surround with double quotes if file name has spaces
	//	 exec("$cmd \"$document\"", $output);

	//	 // Iterate through lines
	//	 $pagecount = 0;
	//	 foreach($output as $op)
	//	 {
	//		 // Extract the number
	//		 if(preg_match("/Pages:\s*(\d+)/i", $op, $matches) === 1)
	//		 {
	//			 $pagecount = intval($matches[1]);
	//			 break;
	//		 }
	//	 }

	//	 return $pagecount;
	// }
?>

<div id="main">
<div id="isiMainTbl">

	<table id="tblStatusLPJ" border="1" class="tblStyle">
		<tr>
			<th>Tahun</th>
			<th>Tahap</th>
			<th>Tanggal Upload</th>
			<th>Nama Format Lampiran</th>
			<th>Info Lampiran</th>
			<th>Jenis Lampiran</th>
			<th>Status</th>
		</tr>
		
<?php
	include_once "conn.php";
	$sql = "
			SELECT
			tb_lpj.tahun,
			tb_lpj.tahap,
			tb_lpj.tanggal,
			tb_lampiran.nama,
			tb_lampiran.jenis,
			tb_lpj.`status`,
			tb_lpj.bulan,
			tb_lpj.path_file,
			if(tb_lpj.bulan = 0, '', concat('Bulan ', tb_lpj.bulan)) as bln 
			FROM
			tb_lpj
			INNER JOIN tb_lampiran ON tb_lampiran.id = tb_lpj.id_lampiran
			WHERE
			npsn = ?
			ORDER BY
			id, bulan ASC	
		";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $npsn);
	$npsn = $_SESSION["npsn"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		while($row = $hasil->fetch_assoc()){
			echo "<tr>";
			echo "<td>".$row["tahun"]."</td>";
			echo "<td>".$row["tahap"]."</td>";
			echo "<td>".$row["tanggal"]."</td>";
			echo "<td><a href='".$row["path_file"]."' >".$row["nama"]." ".$row["bln"]."</a></td>";
			echo "<td>".getNumPagesInPDF($row["path_file"])." hal. - ".number_format((filesize($row["path_file"])/1024/1024),2)."MB</td>";
			echo "<td>".$row["jenis"]."</td>";
			echo "<td "; if ($row["status"] == "Upload Ulang") echo "style='color:red;cursor:pointer;' title='Anda harus mengupload ulang lampiran ini.'";
				echo"><b>".$row["status"]."<b></td>";
			echo "</tr>";
		}
		
	}
	else{
		echo "
			<tr>
				<th colspan='7'>Belum ada data yang dimasukkan</th>
			</tr>
		";
	}

	$sql = "select * from tb_penilaian where npsn=? and tahun=? and tahap=?";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_SESSION["npsn"];
	$p2 = $_SESSION["tahun"];
	$p3 = $_SESSION["tahap"];
	$ps->execute();
	$hasil = $ps->get_result();
	$row = $hasil->fetch_assoc();
	$statusPenilaian = $row["status"];
	if ($statusPenilaian == "") $statusPenilaian = "-";
	$keteranganPenilaian = $row["keterangan"];
	if ($keteranganPenilaian == "") $keteranganPenilaian = "-";

	$jmlKarakter = strlen($keteranganPenilaian);

	$ps->close();
	$conn->close();
?>
	</table>
	<div id="divPenilaian">
		<div id="divStatus" style="margin: auto; text-align: center; margin-top: 25px; width: 50%;">
			Status:<br>
			<label style="font-size: 30px; font-weight: bold;">
				<?php echo $statusPenilaian; ?>
			</label>
		</div>
		<div id="divKeterangan" style="margin: auto; text-align: center; margin-top: 20px;  width: 50%;">
			Keterangan:<br>
			<label style="font-size: 30px;">
				<?php echo nl2br($keteranganPenilaian); ?>
			</label>
		</div>
	</div>
</div>
	
</div>

<script>
	$(document).ready(function(){
		$("#mn2").css({
			"background-color":"green",
			"color":"white"
		});

		var statusPenilaian = "<?php echo $statusPenilaian; ?>";
		var jmlChar = Number("<?php echo $jmlKarakter; ?>");
		if (statusPenilaian == "Upload Ulang" && jmlChar > 85){
			$("#divKeterangan").css({
				"text-align": 'left',
				"font-size": '22px',
				"font-weight": "bold",
				"width": "85%"
			});
			$("#divKeterangan label").css({
				"text-align": 'left',
				"font-size": '20px',
				"font-weight": "normal"
			});
			setUkuran();
		}
	});
</script>

<?php 
	include "footer.php";
?>