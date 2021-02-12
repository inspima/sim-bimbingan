<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<style type="text/css">
		body {
			margin: -30px -10px 0px -10px;
			font-family: "Times New Roman", Times, serif;
			font-size: 14px;
		}

		.line {
			background-image: url("assets/backend/cetak/line.png");
			background-repeat: repeat-x;
		}

		table.padded tr th, table.padded tr td {
			padding: 8px;
		}

		table tr td {
			vertical-align: text-top;
		}

		table.bordered {
			border-collapse: collapse;
		}

		.page_break {
			page-break-before: always;
		}
	</style>
</head>
<body>

<table align="center" width="100%" border="0">
	<tr>
		<td style="width:5%;vertical-align: middle"><img src="assets/backend/cetak/logo.png" width="70px" style=""></td>
		<td style="width:95%" align="center">
			<strong>
				<p style="font-size:17px;margin-bottom: 0px;">
					<?= strtoupper($this->setting->get_value('kementrian_txt')) ?><br>
					<?= strtoupper($this->setting->get_value('universitas_txt')) ?><br>
					<?= strtoupper($this->setting->get_value('universitas_fakultas_txt')) ?><br>
				</p>
			</strong>

			<p style="font-size:14px;margin: 0px 0 0px 0;">
				<?= $this->setting->get_value('universitas_alamat_txt') ?><br>
				<?= $this->setting->get_value('universitas_web_email_txt') ?>
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="line">&nbsp;
		</td>
	</tr>
</table>
<table border="0" style="width:100%">

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="center">
						<h3 style="margin: 5px;font-weight: normal">
							KEPUTUSAN DEKAN<br/>
							NOMOR : <?= strtoupper($no_sk) ?><br/>
							TENTANG <br/>
							PENGANGKATAN PROMOTOR DAN KO-PROMOTOR<br/>
							BAGI MAHASISWA <?= strtoupper($this->setting->get_value('universitas_prodi_s3_txt')) ?><br/>
							SEMESTER <?= strtoupper($semester->semester) ?><br/>
							<br/>
							<br/>
							DEKAN <?= strtoupper($this->setting->get_value('universitas_fakultas_txt')) ?> <?= strtoupper($this->setting->get_value('universitas_txt')) ?>,
						</h3>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table border="0" style="width:100%">
	<tr>
		<td style="width: 23%">Menimbang</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			<ol style="list-style: lower-alpha;margin: 0px;">
				<li>bahwa guna menunjang keberhasilan Pendidikan <?= ucfirst($this->setting->get_value('universitas_prodi_s3_txt')) ?> Semester <?= ucfirst($semester->semester) ?>, perlu diangkat Prommotor dan Ko-Promotor sebagai Pemandu dalam melaksanakan Penelitian;</li>
				<li>bahwa berdasarkan pertimbangan sebagaimana dimaksud pada huruf a, perlu diterbitkan Keputusan Dekan <?= ucfirst($this->setting->get_value('universitas_fakultas_txt')) ?> <?= ucfirst($this->setting->get_value('universitas_txt')) ?>.</li>
			</ol>
		</td>
	</tr>
	<tr>
		<td style="width: 23%">Mengingat</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			<ol style="margin: 0px;">
				<li>Undang-Undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional; (Lembaran Negara Republik Indonesia Tahun 2003 Nomor 78, Tambahan Lembaran Negara Republik Indonesia Nomor 4301);</li>
				<li>Undang-Undang Nomor 14 Tahun 2005 tentang Guru dan Dosen (Lembaran Negara Republik Indonesia Tahun 205 Nomor 157, Tambahan Lembaran Negara Republik Indonesia Nomor 45);.</li>
				<li>Peraturan Pemerintah Republik Indonesia Nomor 57 Tahun 1954 (Lembaran Negara Tahun 1955 No. 99) tentang Pendirian <?= ucfirst($this->setting->get_value('universitas_txt')) ?>;</li>
				<li>Peraturan Pemerintah Republik Indonesia Nomor 30 Tahun 2006 (Lembaran Negara Nomor 66) tentang Penetapan Universitas Airlangga sebagai Badan Hukum Milik Negara;</li>
				<li>Keputusan Mendikbud Republik Indonesia Nomor 212/U/1999 tentang Pedoman Penyelenggaraan Program Doktor;</li>
				<li>Keputusan Dirjen Dikti Depdikbud RI Nomor : 33/Dikti/Kep./1993 tentang Pemberian Izin Penyelenggaraan Program Studi Magister dan Doktor di Universitas Airlangga;</li>
				<li>Peraturan Majelis Wali Amanat Universitas Airlangga Nomor : 12/MWA-UA/2008 tentang Anggaran Dasar Rumah Tangga Universitas Airlangga;</li>
				<li>Peraturan Rektor Universitas Airlangga Nomor : 318/JO3/HK/2008 tentang Perubahan Atas Peraturan Rektor Nomor : 057/JO3/HK/2006 tentang Struktur Organisasi Universitas Airlangga-Badan Hukum Milik Negara;</li>
				<li>Peraturan Rektor Universitas Airlangga Nomor : 9112/JO3/PT/2008 tentang Pendidikan Program Doktor Program Pascasarjana Universitas Airlangga;</li>
				<li>Keputusan Rektor Universitas Airlangga Nomor : 1289/H3/KR/2009 tentang Pelimpahan Pengelolahan Penyelenggara Pendidikan Program Doktor Ilmu Hukum dari Program Pascasarjana ke Fakultas Hukum Universitas Airlangga;</li>
				<li>Keputusan Rektor Universitas Airlangga Nomor : 1790/H3/KR/2018 tanggal 18 Desember 2018 tentang pengangkatan Dekan pada Fakultas Hukum Universitas Airlangga;</li>
			</ol>
		</td>
	</tr>
</table>

<div class="page_break"></div>

<table align="center" width="100%" border="0">
	<tr>
		<td style="width:5%;vertical-align: middle"><img src="assets/backend/cetak/logo.png" width="70px" style=""></td>
		<td style="width:95%" align="center">
			<strong>
				<p style="font-size:17px;margin-bottom: 0px;">
					<?= strtoupper($this->setting->get_value('kementrian_txt')) ?><br>
					<?= strtoupper($this->setting->get_value('universitas_txt')) ?><br>
					<?= strtoupper($this->setting->get_value('universitas_fakultas_txt')) ?><br>
				</p>
			</strong>

			<p style="font-size:14px;margin: 0px 0 0px 0;">
				<?= $this->setting->get_value('universitas_alamat_txt') ?><br>
				<?= $this->setting->get_value('universitas_web_email_txt') ?>
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="line">&nbsp;
		</td>
	</tr>
</table>

<table border="0" style="width:100%">

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="center">
						<h3 style="margin: 5px;font-weight: bold">
							MENETAPKAN
						</h3>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table border="0" style="width:100%">
	<tr>
		<td style="width: 23%">Menetapkan</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
		</td>
	</tr>
	<tr>
		<td style="width: 23%">PERTAMA</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			Mengangkat Promotor dan Ko-Promotor bagi Mahasiswa <?= ucfirst($this->setting->get_value('universitas_prodi_s3_txt')) ?>, dengan susunan nama-nama sebagaimana tercantum dalam lampiran keputusan ini;
		</td>
	</tr>
	<tr>
		<td style="width: 23%">KEDUA</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			Dalam melaksanakan tugasnya sebagai Promotor dan Ko-Promotor sebagaimana dimaksud pada diktum PERTAMA berpedoman pada peraturan dan ketentuan-ketentuan yang berlaku serta mempertanggungjawabkan tugasnya kepada Dekan.
		</td>
	</tr>
	<tr>
		<td style="width: 23%">KETIGA</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			Biaya untuk keperluan pelaksanaan keputusan ini dibebankan pada Anggaran POPA Universitas Airlangga Tahun Anggaran <?= $semester->tahun ?>;
		</td>
	</tr>
	<tr>
		<td style="width: 23%">KEEMPAT</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			Keputusan ini berlaku sejak tanggal ditetapkan.
		</td>
	</tr>
</table>


<table border="0" style="width:100%;margin-top: 100px">
	<tr>
		<td style="width: 35%">
			Salinan sesuai dengan Aslinya<br/>
			Koordinator Program,<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<?= $kps_s3->nama_dosen ?><br/>
			NIP:<?= $kps_s3->nip ?><
		</td>
		<td style="width: 20%"></td>
		<td style="width: 35%">
			Ditetapkan di <?= ucfirst($this->setting->get_value('universitas_alamat_kota_txt')) ?><br/>
			Pada tanggal <?= strtoupper(woday_toindo(date('Y-m-d'))) ?><br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<?= $wadek->nama_dosen ?><br/>
			NIP:<?= $wadek->nip ?><
		</td>
	</tr>
</table>

<table border="0" style="width:100%;">
	<tr>
		<td style="width: 40%">
			Salinan disampaikan kepada Yth. :<br/>
			1. Kasubbag. Keuangan dan Sumber Daya Manusia<br/>
			2. Yang bersangkutan
		</td>
	</tr>
</table>


<div class="page_break"></div>

<table align="center" width="100%" border="0">
	<tr>
		<td style="width:5%;vertical-align: middle"><img src="assets/backend/cetak/logo.png" width="70px" style=""></td>
		<td style="width:95%" align="center">
			<strong>
				<p style="font-size:17px;margin-bottom: 0px;">
					<?= strtoupper($this->setting->get_value('kementrian_txt')) ?><br>
					<?= strtoupper($this->setting->get_value('universitas_txt')) ?><br>
					<?= strtoupper($this->setting->get_value('universitas_fakultas_txt')) ?><br>
				</p>
			</strong>

			<p style="font-size:14px;margin: 0px 0 0px 0;">
				<?= $this->setting->get_value('universitas_alamat_txt') ?><br>
				<?= $this->setting->get_value('universitas_web_email_txt') ?>
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="line">&nbsp;
		</td>
	</tr>
</table>
<table border="0" style="width:100%">
	<tr>
		<td colspan="3">Keputusan Dekan Fakultas Hukum Universitas Airlangga</td>
		</td>
	</tr>
	<tr>
		<td style="width: 23%">Nomor</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			<?= $no_sk ?>
		</td>
	</tr>
	<tr>
		<td style="width: 23%">Tentang</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			Pengangkatan Promotor dan Ko-Promotor bagi Mahasiswa <?= ucfirst($this->setting->get_value('universitas_prodi_s3_txt')) ?> <?= ucfirst($this->setting->get_value('universitas_fakultas_txt')) ?> <?= ucfirst($this->setting->get_value('universitas_txt')) ?> Semester <?= ucfirst($semester->semester) ?>
		</td>
	</tr>
</table>
<?php
	$promotors = $this->disertasi->read_promotor_kopromotor($disertasi->id_disertasi);

?>
<table class="bordered padded" border="1" style="width:100%;margin-top: 20px">
	<tr>
		<th>No</th>
		<th>NIM</th>
		<th>Nama</th>
		<th>Promotor</th>
		<th>Ko-Promotor</th>
	</tr>
	<tr>
		<td>1</td>
		<td><?= $disertasi->nim ?></td>
		<td><?= $disertasi->nama ?></td>
		<td>
			<?php
				foreach ($promotors as $promotor) {
					if ($promotor['status_tim'] == '1') {
						echo $promotor['nama'];
					}
				}
			?>
		</td>
		<td>
			<?php
				$num = 1;
				foreach ($promotors as $promotor) {
					if ($promotor['status_tim'] != '1') {
						echo $num++.'. '.$promotor['nama'].generateNewLineHTML(3);
					}
				}
			?>
		</td>
	</tr>
</table>

<table border="0" style="width:100%;margin-top: 100px">
	<tr>
		<td style="width: 35%">
			Salinan sesuai dengan Aslinya<br/>
			Koordinator Program,<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<?= $kps_s3->nama_dosen ?><br/>
			NIP:<?= $kps_s3->nip ?><
		</td>
		<td style="width: 20%"></td>
		<td style="width: 35%">
			Ditetapkan di <?= ucfirst($this->setting->get_value('universitas_alamat_kota_txt')) ?><br/>
			Pada tanggal <?= strtoupper(woday_toindo(date('Y-m-d'))) ?><br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<?= $wadek->nama_dosen ?><br/>
			NIP:<?= $wadek->nip ?><
		</td>
	</tr>
</table>

</body>
</html>
