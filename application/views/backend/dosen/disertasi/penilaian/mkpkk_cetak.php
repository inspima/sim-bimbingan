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
</head>
<body>

<table align="center" width="100%" border="0">
	<tbody>
	<tr>
		<td width="10%"><img src="assets/backend/cetak/logo.png" width="100px"></td>
		<td width="90%" align="center">
			<strong><p style="font-size:17px;margin-bottom: 0px;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN REPUBLIK INDONESIA<br>
					UNIVERSITAS AIRLANGGA<br>
					FAKULTAS HUKUM<br></p>
			</strong><p style="font-size:14px;margin: 0px 0 0px 0;">Kampus B, Jl. Dharmawangsa Dalam Selatan Surabaya 60286 Telp. (031) 5023151, 5023152 Fax. (031) 5020454<br>
				Website: http://fh.unair.ac.id - Email: humas@fh.unair.ac.id </p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="line">&nbsp;
		</td>
	</tr>
	</tbody>
</table>

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
						<?php echo $mkpkk->nama ?>
					</td>
				</tr>
				<tr>
					<td style="width: 35%"><b style="margin-left: 100px">NILAI ANGKA</b></td>
					<td style="width: 3%">:</td>
					<td style="width: 62%">
						<?php echo number_format($disertasi_mkpkk->nilai_angka,2) ?>
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
							Surabaya, <?php echo toindo(date('Y-m-d')) ?><br/>
							Penanggung Jawab Mata Kuliah,
							<br/>
							<?php
								if (!empty($pjma_mkpd->ttd)) {
									?>
									<img style="margin-left: 20px" src="<?= str_replace(base_url(), "", $pjma_mkpd->ttd) ?>" width="60px"/>
									<br/>
									<?php
								} else {
									?>
									<br/><br/><font style="color: red;font-size: 9pt">TTD KOSONG</font><br/><br/>
									<?php
								}
							?>
							<br/>
							<?= $pjma_mkpkk->nama ?><br/>
							NIP. <?= $pjma_mkpkk->nip ?>
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
