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

	include_once "conn.php";
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
			where
				tb_lpj.`status` <> 'Upload Ulang'
				and
				tb_lpj.`status` <> 'Belum Diajukan'
				and
				tb_kecamatan.`wilayah` = '".$_SESSION["wilayah"]."'
				and
				tb_lpj.`status` like ? AND
				tb_madrasah.jenjang like ?
			ORDER BY
				nama,
				id_lampiran";
	
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("ss", $p1, $p2);
	$p1 = "%".$_POST["optStatus"]."%";
	$p2 = "%".$_POST["optJenjang"]."%";
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		echo "
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
					<a href='".$row["path_file"]."' class='linkLPJ' id='link".$idUnik."' ";
						if ($row["status"] == "Pending") echo "style='display:none;'";
						echo ">Download</a>
				</td>";
			echo "</tr>";
		}
		$conn->close();
	}
	else{
		echo "
			<tr>
				<th colspan='10'>Belum ada data untuk diverifikasi</th>
			</tr>
		";
	}
?>