<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<style type="text/css">
		body {
			margin: 10px 0px 0 20px;
			font-family: "Times New Roman", Times, serif;
			font-size: 14px;
		}

		.line {
			background-image: url("assets/backend/cetak/line.png");
			background-repeat: repeat-x;
		}
	</style>
</head>
<body>

<table align="center" width="100%" border="0">
	<tr>
		<td width="15%">Lampiran</td>
		<td width="2%">:</td>
		<td width="30%">1 Berkas</td>
		<td width="20%"></td>
		<td width="42%;border:2px solid black;font-size:1.1em;font-weight:bold;padding:5px;text-align:center">Permohonan Ujian Kualifikasi</td>
	</tr>
	<tr>
		<td width="15%">Perihal</td>
		<td width="2%">:</td>
		<td width="30%">Permohonan Ujian Kualifikasi</td>
		<td></td>
		<td></td>
	</tr>
</table>
<?php echo generateNewLineHTML(4); ?>
<table align="center" width="100%" border="0">

	<tr>
		<td width="17%"></td>
		<td width="83%">Yth. Dekan</td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%"><?= ucfirst($this->setting->get_value('universitas_fakultas_txt')) ?> <?= ucfirst($this->setting->get_value('universitas_txt')) ?></td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%"><?= ucfirst($this->setting->get_value('universitas_alamat_kota_txt')) ?></td>
	</tr>
</table>
<?php echo generateNewLineHTML(2); ?>
<table align="center" width="100%" border="0">
	<tr>
		<td width="17%"></td>
		<td width="83%">Dengan ini kami beritahukan bahwa mahasiswa Program Doktor :</td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%">
			<table border="0"  style="width:100%;">
				<tr>
					<td width="15%">
						NAMA
					</td>
					<td width="2%">:</td>
					<td width="83%">
						<b><?php echo $disertasi->nama ?></b>
					</td>
				</tr>
				<tr>
					<td width="15%">
						NIM
					</td>
					<td width="2%">:</td>
					<td width="83%">
						<b><?php echo $disertasi->nim ?></b>
					</td>
				</tr>
				<tr style="vertical-align: text-top">
					<td width="15%">
						JUDUL
					</td>
					<td width="2%">:</td>
					<td width="83%">
						<b><?php echo $disertasi->judul ?></b>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo generateNewLineHTML(2); ?>
<table align="center" width="100%" border="0">
	<tr>
		<td width="17%"></td>
		<td width="83%">Sesuai dengan rekomendasi Program Doktor tentang Ujian Kualifikasi telah siap untuk melaksanakan Ujian Kualifikasi yang kami rencanakan pada :</td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%">
			<table border="0"  style="width:100%;">
				<tr>
					<td width="15%">
						Hari, Tanggal
					</td>
					<td width="2%">:</td>
					<td width="83%">
						<b></b>
					</td>
				</tr>
				<tr>
					<td width="15%">
						Pukul
					</td>
					<td width="2%">:</td>
					<td width="83%">
						<b></b>
					</td>
				</tr>
				<tr style="vertical-align: text-top">
					<td width="15%">
						Tempat
					</td>
					<td width="2%">:</td>
					<td width="83%">
						<b></b>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo generateNewLineHTML(2); ?>
<table align="center" width="100%" border="0">
	<tr>
		<td width="17%"></td>
		<td width="83%">Diusulkan dengan susunan Tim Penguji, sebagai berikut :</td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%"></td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%">1.................</td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%">2.................</td>
	</tr>
</table>

<?php echo generateNewLineHTML(2); ?>
<table align="center" width="100%" border="0">
	<tr>
		<td width="17%"></td>
		<td width="83%">Sehubungan dengan hal tersebut, dengan ini kami mohon bantuan Saudara memproses pelaksanaan Ujian Kualifikasi bagi yang bersangkutan.</td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%"><?php echo generateNewLineHTML(2); ?></td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%">Demikian atas bantuan Saudara, kami sampaikan terima kasih.</td>
	</tr>
</table>

<?php echo generateNewLineHTML(3); ?>
<table border="0" style="width:100%;">
	<tr>
		<td style="width: 60%;text-align: left;padding: 10px">
			Koordinator Program Doktor Ilmu Hukum.

			<br/>
			NIP.
		</td>
		<td style="width: 40%;text-align: left;padding: 10px">
			Penasehat Akademik.

			<br/>
			NIP.
		</td>
	</tr>
</body>
</html>
