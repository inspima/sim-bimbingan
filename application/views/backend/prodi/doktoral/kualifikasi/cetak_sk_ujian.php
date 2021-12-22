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
			font-size: 16px;
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
	<title>SURAT KEPUTUSAN - PENASEHAT AKADEMIK - <?= $disertasi->nim ?></title>
</head>
<body>

<?php $this->load->view('backend/widgets/common/header_document') ?>
<table border="0" style="width:100%">

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="center">
						<h3 style="margin: 5px;font-weight: bold">
							KEPUTUSAN DEKAN<br/>
							NOMOR : <?= strtoupper($dokumen->no_doc) ?><br/>
							TENTANG <br/>
							PENGUJI UJIAN KUALIFIKASI<br/>
							PROGRAM <?= strtoupper($this->setting->get_value('universitas_prodi_s3_txt')) ?><br/>
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
				<li>bahwa sehubungan dengan disertasi Saudara <?= $disertasi->nama ?> M.H./NIM.<?= $disertasi->nim ?> Program <?= ucfirst($this->setting->get_value('universitas_prodi_s3_txt')) ?> telah selesai ditulis, maka perlu dibentuk Penguji Disertasi tersebut;</li>
				<li>bahwa berdasarkan pertimbangan sebagaimana dimaksud pada huruf a, perlu menetapkan Keputusan Dekan tentang Penguji Ujian Kualifikasi Program <?= ucfirst($this->setting->get_value('universitas_prodi_s3_txt')) ?></li>
			</ol>
		</td>
	</tr>
	<tr>
		<td style="width: 23%">Mengingat</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			<ol style="margin: 0px;">
				<li>Undang-Undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional; (Lembaran Negara Republik Indonesia Tahun 2003 Nomor 78, Tambahan Lembaran Negara Republik Indonesia Nomor 4301);</li>
				<li>Undang-Undang Nomor 14 Tahun 2005 tentang Guru dan Dosen (Lembaran Negara Republik Indonesia Tahun 205 Nomor 157, Tambahan Lembaran Negara Republik Indonesia Nomor 45);</li>
				<li>Peraturan Pemerintah Republik Indonesia Nomor 57 Tahun 1954 (Lembaran Negara Tahun 1955 No. 99) tentang Pendirian <?= ucfirst($this->setting->get_value('universitas_txt')) ?>;</li>
				<li>Peraturan Pemerintah Republik Indonesia Nomor 30 Tahun 2006 (Lembaran Negara Nomor 66) tentang Penetapan Universitas Airlangga sebagai Badan Hukum Milik Negara;</li>
				<li>Keputusan Mendikbud Republik Indonesia Nomor 212/U/1999 tentang Pedoman Penyelenggaraan Program Doktor;</li>
				<li>Keputusan Dirjen Dikti Depdikbud RI Nomor : 33/Dikti/Kep./1993 tentang Pemberian Izin Penyelenggaraan Program Studi Magister dan Doktor di Universitas Airlangga;</li>
				<li>Peraturan Majelis Wali Amanat Universitas Airlangga Nomor : 12/MWA-UA/2008 tentang Anggaran Dasar Rumah Tangga Universitas Airlangga;</li>
				<li>Peraturan Rektor Universitas Airlangga Nomor : 318/JO3/HK/2008 tentang Perubahan Atas Peraturan Rektor Nomor : 057/JO3/HK/2006 tentang Struktur Organisasi Universitas Airlangga-Badan Hukum Milik Negara;</li>
				<li>Peraturan Rektor Universitas Airlangga Nomor : 9112/JO3/PT/2008 tentang Pendidikan Program Doktor Program Pascasarjana Universitas Airlangga;</li>
				<li>Keputusan Rektor Universitas Airlangga Nomor : 1289/H3/KR/2009 tentang Pelimpahan Pengelolahan Penyelenggara Pendidikan Program Doktor Ilmu Hukum dari Program Pascasarjana ke Fakultas Hukum Universitas Airlangga;</li>
				<li>Keputusan Rektor Universitas Airlangga Nomor : 762/UN3/2020 tentang pengangkatan Dekan pada Fakultas Hukum Universitas Airlangga;</li>
			</ol>
		</td>
	</tr>
	<tr>
		<td style="width: 23%">Meperhatikan</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			Berita Acara Ujian Kualifikasi tanggal <?= woday_toindo($jadwal->tanggal) ?>
		</td>
	</tr>
</table>

<div class="page_break"></div>

<?php $this->load->view('backend/widgets/common/header_document') ?>
<table border="0" style="width:100%">

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="center">
						<h3 style="margin: 5px;font-weight: bold">
							MEMUTUSKAN
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
			<b>KEPUTUSAN DEKAN TENTANG PENGUJI UJIAN KUALIFIKASI PROGRAM <?= strtoupper($this->setting->get_value('universitas_prodi_s3_txt')) ?> </b>
		</td>
	</tr>
	<tr>
		<td style="width: 23%">KESATU</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			Menetapkan Penguji Ujian Kualifikasi Program <?= strtoupper($this->setting->get_value('universitas_prodi_s3_txt')) ?> atas nama <?= $disertasi->nama ?> M.H./NIM.<?= $disertasi->nim ?> dengan susunan penguji sebagai berikut :
			<br/><br/>
			<table style="width: 100%">
				<tr>
					<td style="width: 15%">Ketua</td>
					<td style="width: 3%">:</td>
					<td style="width: 77%"><?= $ketua_penguji->nama ?></td>
				</tr>
				<tr>
					<td style="width: 15%">Anggota</td>
					<td style="width: 3%">:</td>
					<td style="width: 77%">
						<ol style="margin: 0px;">
							<?php
								foreach ($pengujis as $penguji) {
									?>
										<li><?=$penguji['nama']?></li>
									<?php
								}
							?>
						</ol>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="width: 23%">KEDUA</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			Dalam melaksanakan tugasnya Penguji sebagaimana dimaksud pada diktum KESATU berpedoman pada peraturan dan ketentuan-ketentuan yang berlaku serta mempertanggungjawabkan tugasnya kepada Dekan.
		</td>
	</tr>
	<tr>
		<td style="width: 23%">KETIGA</td>
		<td style="width: 2%">:</td>
		<td style="width: 75%">
			Keputusan ini berlaku sejak tanggal ditetapkan
		</td>
	</tr>
</table>


<table border="0" style="width:100%;margin-top: 100px">
	<tr>
		<td style="width: 35%">

		</td>
		<td style="width: 20%"></td>
		<td style="width: 35%">
			Ditetapkan di <?= ucfirst($this->setting->get_value('universitas_alamat_kota_txt')) ?><br/>
			Pada tanggal <?= woday_toindo($dokumen->date_doc) ?><br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<?=$dekan->nama_dosen?><br/>
			NIP:<?=$dekan->nip?><
		</td>
	</tr>
</table>

<table border="0" style="width:100%;">
	<tr>
		<td style="width: 40%">
			Salinan disampaikan kepada Yth. :<br/>
			1.Yang bersangkutan<br/>
			2.Kasubbag Keu.dan SDM
		</td>
	</tr>
</table>

<table border="0" style="width:100%;margin-top: 100px">
	<tr>
		<td style="width: 20%"></td>
		<td style="width: 35%">
			Salinan sesuai dengan Aslinya<br/>
			Koordinator Program,<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<?=$kps_s3->nama_dosen?><br/>
			NIP:<?=$kps_s3->nip?><
		</td>
		<td style="width: 20%"></td>
	</tr>
</table>



</body>
</html>
