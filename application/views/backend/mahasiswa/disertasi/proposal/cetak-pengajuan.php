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
	<title>FORM PENGAJUAN DISERTASI - UJIAN PROPOSAL</title>
</head>
<body>

<table align="center" width="100%" border="0">
	<tr>
		<td width="15%">Lampiran</td>
		<td width="2%">:</td>
		<td width="30%">1 Berkas</td>
		<td width="20%"></td>
		<td width="42%;border:2px solid black;font-size:1.1em;font-weight:bold;padding:5px;text-align:center">Permohonan Ujian Proposal</td>
	</tr>
	<tr>
		<td width="15%">Perihal</td>
		<td width="2%">:</td>
		<td width="30%">Permohonan Ujian Proposal</td>
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
			<table border="0" style="width:100%;">
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
		<td width="83%">Sesuai dengan rekomendasi Program Doktor tentang Ujian Proposal telah siap untuk melaksanakan Ujian Proposal yang kami rencanakan pada :</td>
	</tr>
	<tr>
		<td width="17%"></td>
		<td width="83%">
			<table border="0" style="width:100%;">
				<tr>
					<td width="15%">
						Hari, Tanggal
					</td>
					<td width="2%">:</td>
					<td width="83%">
						<b><?php echo hari($jadwal->tanggal) ?></b>,<b> <?php echo woday_toindo($jadwal->tanggal) ?></b>
					</td>
				</tr>
				<tr>
					<td width="15%">
						Pukul
					</td>
					<td width="2%">:</td>
					<td width="83%">
						<b><?= substr($jadwal->jam, 0, 5); ?> - Selesai</b> WIB
					</td>
				</tr>
				<tr style="vertical-align: text-top">
					<td width="15%">
						Tempat
					</td>
					<td width="2%">:</td>
					<td width="83%">
						<b>Ruang <?= $jadwal->ruang . ', ' . $jadwal->gedung ?></b> <?= ucfirst($this->setting->get_value('universitas_fakultas_txt')) ?> <?= ucfirst($this->setting->get_value('universitas_txt')) ?>
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
	<?php
		foreach ($pengujis as $no=>$penguji) {
			?>

			<tr>
				<td width="17%"></td>
				<td width="83%"><?=$no+1?>. <?=$penguji['nama']?></td>
			</tr>
			<?php
		}
	?>
</table>

<?php echo generateNewLineHTML(2); ?>
<table align="center" width="100%" border="0">
	<tr>
		<td width="17%"></td>
		<td width="83%">Sehubungan dengan hal tersebut, dengan ini kami mohon bantuan Saudara memproses pelaksanaan Ujian Proposal bagi yang bersangkutan.</td>
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
			Koordinator <?= ucfirst($this->setting->get_value('universitas_prodi_s3_txt')) ?>.
			<?php echo generateNewLineHTML(7); ?>
			<?=$kps_s3->nama_dosen ?><br/>
			NIP.<?=$kps_s3->nip ?><br/>
		</td>
		<td style="width: 40%;text-align: left;padding: 10px">
			<?= ucfirst($this->setting->get_value('universitas_alamat_kota_txt')) ?>
			Penasehat Akademik.
			<?php echo generateNewLineHTML(7); ?>
			<?=$disertasi->nama_penasehat ?><br/>
			NIP.<?=$disertasi->nip_penasehat ?><br/>
		</td>
	</tr>
</body>
</html>
