<?php
	include "headerOperator.php";
?>

<div id="main">
<div id="isiDataMadrasah">
	<form method="POST" action="ambilFile.php">
		<div class="baris">
			<div class="kolomDM1" style="width: 100%;">
				<label class="styleLabel">PETUNJUK TEKNIS BANTUAN OPERASIONAL SEKOLAH PADA MADRASAH</label>
			</div>
			<div class="kolomDM2" style="width: 100%;margin-bottom: 25px;">
				<input type="text" name="txt1" value="juknisBosMadrasah2018.pdf" style="display: none;">
				<input class="styleButton" type="submit" name="btnJuknis" value="Download" style="width: 100%;">
			</div>
		</div>

		<div class="baris">
			<div class="kolomDM1"style="width: 100%;">
				<label class="styleLabel">PETUNJUK PENGGUNAAN UNTUK OPERATOR MADRASAH</label>
			</div>
			<div class="kolomDM2"style="width: 100%;margin-bottom: 25px;">
				<input type="text" name="txt2" value="Petunjuk penggunaan untuk operator sekolah.pdf" style="display: none;">
				<input class="styleButton" type="submit" name="btnPetunjuk" value="Download" style="width: 100%;">
			</div>
		</div>

		<div class="baris">
			<div class="kolomDM1"style="width: 100%;">
				<label class="styleLabel">PETUNJUK REDUKSI/KOMPRES FILE PDF</label>
			</div>
			<div class="kolomDM2"style="width: 100%;margin-bottom: 25px;">
				<input type="text" name="txt3" value="Langkah Kompresi PDF.pdf" style="display: none;">
				<input class="styleButton" type="submit" name="btnKompres" value="Download PDF" style="width: 100%;">
				<br><br>
				<input type="text" name="txt3" value="Langkah Kompresi PDF.mp4" style="display: none;">
				<input class="styleButton" type="submit" name="btnKompres" value="Download Video" style="width: 100%;">
			</div>
		</div>

		<div class="baris">
			<div class="kolomDM1"style="width: 100%;">
				<label class="styleLabel">PETUNJUK MEMPERBAIKI KUALITAS FILE PDF</label>
			</div>
			<div class="kolomDM2"style="width: 100%;margin-bottom: 25px;">
				<input type="text" name="txt2" value="Petunjuk memperbaiki kualitas gambar.pdf" style="display: none;">
				<input class="styleButton" type="submit" name="btnPetunjuk" value="Download" style="width: 100%;">
			</div>
		</div>
		
	</form>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#mn5").css({
			"background-color" : "green",
			"color" : "white"
		});
	});
</script>


<?php 
	include "footer.php";
?>