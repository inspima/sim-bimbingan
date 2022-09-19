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
	<title>SURAT KEPUTUSAN - PENGAJAR MKPKK - <?= $disertasi->nim ?></title>
</head>
<body>
<?php $this->load->view('backend/widgets/common/header_document') ?>
<table border="0" style="width:100%">

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="center">
						<h3 style="margin: 5px;font-weight: normal">
							<b><u>SURAT PENUGASAN</u></b><br/>
							Nomor : <?= strtoupper($no_sk) ?>
						</h3>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table style="width: 100%">
	<tr>
		<td>Dekan <?= ucfirst($this->setting->get_value('universitas_fakultas_txt')) ?> <?= ucfirst($this->setting->get_value('universitas_txt')) ?>,
			dengan ini menugaskan Tenaga Pengajar yang namanya tersebut dibawah ini sebagai Tenaga Pengajar Mata Kuliah Penunjang Disertasi (MKPD)
			pada <?= ucfirst($this->setting->get_value('universitas_prodi_s3_txt')) ?> Semester <?= ucfirst($semester->semester) ?> dengan Judul Disertasi “<?= $disertasi->judul ?>”.
		</td>
	</tr>
</table>
<table class="bordered padded" border="1" style="width:100%;margin-top: 20px">
	<tr>
		<th>NO</th>
		<th>DOSEN</th>
		<th>KODE MK</th>
		<th>NAMA TOPIK MKPD</th>
		<th>SKS</th>
		<th>NIM</th>
		<th>NAMA</th>
	</tr>
	<?php
		foreach ($disertasi_mkpds as $index => $disertasi_mkpd) {
			$mkpd_pengampus = $this->disertasi->read_disertasi_mkpd_pengampu($disertasi_mkpd['id_disertasi_mkpd']);
			$mkpd = $this->disertasi->detail_disertasi_mkpd($disertasi_mkpd['id_disertasi_mkpd']);
			?>
			<tr>
				<td><?= $index + 1 ?></td>
				<td style="width: 32%">
						<?php
							foreach ($mkpd_pengampus as $index_pengampu => $mkpd_pengampu) {
								?>
								<?php echo $mkpd_pengampu['nama'] ?> <br/>
								<?php
							}
						?>
				</td>
				<?php
					if ($index == 0) {
						?>
						<td rowspan="<?= count($disertasi_mkpds) ?>"><?= $disertasi_mkpd['kode'] ?></td>
						<?php
					}
				?>
				<td><?= $disertasi_mkpd['mkpd'] ?></td>
				<?php
					if ($index == 0) {
						?>
						<td rowspan="<?= count($disertasi_mkpds) ?>"><?= $disertasi_mkpd['sks'] ?></td>
						<?php
					}
				?>
				<?php
					if ($index == 0) {
						?>
						<td rowspan="<?= count($disertasi_mkpds) ?>"><?= $disertasi->nim ?></td>
						<td rowspan="<?= count($disertasi_mkpds) ?>"><?= $disertasi->nama ?></td>
						<?php
					}
				?>
			</tr>
			<?php
		}
	?>
</table>

<table border="0" style="width:100%;margin-top: 100px">
	<tr>
		<td style="width: 35%">
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			Tembusan Yth :<br/>
			1. Kasubbag Keuangan dan SDM<br/>
			2. Dosen yang bersangkutan<br/>
		</td>
		<td style="width: 20%"></td>
		<td style="width: 35%">
			Ditetapkan di <?= ucfirst($this->setting->get_value('universitas_alamat_kota_txt')) ?><br/>
			Pada tanggal <?= strtoupper(woday_toindo(date('Y-m-d'))) ?><br/>
			<?php $this->load->view('backend/widgets/common/element_ttd',['ttd'=>$wadek->ttd]) ?>

			<?= $wadek->nama_dosen ?><br/>
			NIP:<?= $wadek->nip ?><
		</td>
	</tr>
</table>

</body>
</html>
