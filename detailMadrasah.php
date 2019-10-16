<?php
	include "headerPemeriksa.php";
	include_once "conn.php";

	$npsn = "";
	$nsm = "";
	$jenjang = "";
	$status = "";
	$nama = "";
	$alamat = "";
	$nama_kepsek = "";
	$nama_bendahara = "";
	$no_telp = "";
	$kelurahan = "";
	$kecamatan = "";
	$sql = "
		SELECT
		tb_madrasah.npsn,
		tb_madrasah.nsm,
		tb_madrasah.jenjang,
		tb_madrasah.`status`,
		tb_madrasah.nama,
		tb_madrasah.alamat,
		tb_madrasah.nama_kepsek,
		tb_madrasah.nama_bendahara,
		tb_madrasah.no_telp,
		tb_kelurahan.`name` as kelurahan,
		tb_kecamatan.`name` as kecamatan
		FROM
		tb_madrasah
		INNER JOIN tb_kelurahan ON tb_madrasah.id_kel = tb_kelurahan.id
		INNER JOIN tb_kecamatan ON tb_madrasah.id_kec = tb_kecamatan.id
		WHERE tb_madrasah.npsn = ?
	";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $npsn);
	$npsn = $_GET["npsn"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$row = $hasil->fetch_assoc();
		$npsn = $row["npsn"];
		$nsm = $row["nsm"];
		$jenjang = $row["jenjang"];
		$status = $row["status"];
		$nama = $row["nama"];
		$alamat = $row["alamat"];
		$nama_kepsek = $row["nama_kepsek"];
		$nama_bendahara = $row["nama_bendahara"];
		$no_telp = $row["no_telp"];
		$kelurahan = $row["kelurahan"];
		$kecamatan = $row["kecamatan"];
	}
	else{

	}
?>

<style type="text/css">
	div.kolom1, div.kolom2{
		float: left;
		margin-right: 2%; 
	}

	div.baris{
		overflow: hidden;
		padding: 20px;
	}

	.kolom1{
		width:30%;
	}
	.kolom2{
		width:65%;
		border-bottom: 1px solid black;
	}
</style>

<div id="main">
	<div id="isiMain" style="width: 50%;">
		<div class="baris">
			<div class="kolom1">
				NPSN
			</div>
			<div class="kolom2">
				<?php
					echo $npsn;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				NSM
			</div>
			<div class="kolom2">
				<?php
					echo $nsm;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				Jenjang
			</div>
			<div class="kolom2">
				<?php
					echo $jenjang;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				Status
			</div>
			<div class="kolom2">
				<?php
					echo $status;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				Nama Madrasah
			</div>
			<div class="kolom2">
				<?php
					echo $nama;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				Alamat
			</div>
			<div class="kolom2">
				<?php
					echo $alamat;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				Nama Kepala Sekolah
			</div>
			<div class="kolom2">
				<?php
					echo $nama_kepsek;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				Nama Bendahara
			</div>
			<div class="kolom2">
				<?php
					echo $nama_bendahara;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				No. Telp.
			</div>
			<div class="kolom2">
				<?php
					echo $no_telp;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				Kecamatan
			</div>
			<div class="kolom2">
				<?php
					echo $kecamatan;
				?>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				Kelurahan
			</div>
			<div class="kolom2">
				<?php
					echo $kelurahan;
				?>
			</div>
		</div>
	</div>
</div>


<?php 
	include "footer.php";
?>