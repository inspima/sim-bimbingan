<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<style type="text/css">
		body {
			margin: -30px 0px 0 0px;
			font-family: "Times New Roman", Times, serif;
			font-size: 12pt;
		}
		.line {
			background-image: url("assets/backend/cetak/line.png");
			background-repeat: repeat-x;
		}
	</style>
	<title>PENILAIAN MKPD - <?=$disertasi->nim?> - <?=$disertasi_mkpd->mkpd?></title>
</head>
<body>
<?php $this->load->view('backend/widgets/common/header_document') ?>
<table border="0" style="width:100%">
	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="center" colspan="3">
						<b style="font-weight: bold;font-size: 1.5em">DAFTAR NILAI</b><br/>
						<b style="font-weight: bold;font-size: 1.2em">MATA KULIAH PENGEMBANGAN KEILMUAN DAN KEAHLIAN <br/>(MKPKK)</b>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="line">&nbsp;</td>
				</tr>
				<tr>
					<td style="width: 35%"><b style="margin-left: 100px">NAMA</b></td>
					<td style="width: 3%">:</td>
					<td style="width: 62%">
						<?php echo $disertasi->nama ?>
					</td>
				</tr>
				<tr>
					<td style="width: 35%"><b style="margin-left: 100px">NIM</b></td>
					<td style="width: 3%">:</td>
					<td style="width: 62%">
						<?php echo $disertasi->nim ?>
					</td>
				</tr>
				<tr>
					<td style="width: 35%"><b style="margin-left: 100px">MATA KULIAH</b></td>
					<td style="width: 3%">:</td>
					<td style="width: 62%">
						<?php echo $disertasi_mkpd->mkpd ?>
					</td>
				</tr>
				<tr>
					<td style="width: 35%"><b style="margin-left: 100px">NILAI ANGKA</b></td>
					<td style="width: 3%">:</td>
					<td style="width: 62%">
						<?php echo number_format($disertasi_mkpd->nilai_angka,2) ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" style="width:100%;margin-top: 30px">
				<tr>
					<td style="width: 50%">

					</td>
					<td style="width: 50%">
						<p>
							Surabaya, <?php echo woday_toindo(date('Y-m-d')) ?><br/>
							Penanggung Jawab Mata Kuliah,
							<br/><br/><br/><br/><br/><br/>
							<?= $pjma_mkpd->nama ?><br/>
							NIP. <?= $pjma_mkpd->nip ?>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" style="width:100%;margin-top: 30px">
				<tr style="width: 30%">
					<td style="width: 60%">
						Mahasiswa angkatan 2014 dan selanjutnya<br/>
						Mengikuti grade nilai sebagai berikut :<br/><br/>
						<table border="1" style="border-collapse: collapse;font-size: 0.9em">
							<tr>
								<td>Nilai Huruf</td>
								<td>Nilai Mutu</td>
								<td>Nilai Angka</td>
							</tr>
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
							</tr>
							<tr>
								<td>A</td>
								<td>4</td>
								<td>86-100</td>
							</tr>
							<tr>
								<td>AB</td>
								<td>3.5</td>
								<td>78-86</td>
							</tr>
							<tr>
								<td>B</td>
								<td>3</td>
								<td>70-78</td>
							</tr>
							<tr>
								<td>BC</td>
								<td>2.5</td>
								<td>62-70</td>
							</tr>
							<tr>
								<td>C</td>
								<td>2</td>
								<td>54-62</td>
							</tr>
							<tr>
								<td>D</td>
								<td>1</td>
								<td>40-54</td>
							</tr>
							<tr>
								<td>E</td>
								<td>0</td>
								<td>&#60;40</td>
							</tr>
						</table>
					</td>
					<td style="width: 40%">

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>
