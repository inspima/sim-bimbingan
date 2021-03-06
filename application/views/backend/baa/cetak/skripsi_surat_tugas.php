<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<style type="text/css">
		body {
			margin: -30px 0px 0 0px;
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

<?php $this->load->view('backend/widgets/common/header_document') ?>

<table border="0" style="width:100%">

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="center">
						<b>SURAT TUGAS<br/>
							Nomor : <?php echo $dokumen->no_doc ?> </b>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:15%" align="left">
						Dekan dengan ini menugaskan kepada :
					</td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="1" style="width:100%;border-collapse: collapse;">
				<tr>
					<td style="width:15%" align="left"><strong>No</strong></td>
					<td style="width:40%" align="left"><strong>Nama Penguji </strong></td>
					<td style="width:40%" align="left"><strong>Keterangan</strong></td>
				</tr>

				<tr>
					<td style="width:15%" align="left">1</td>
					<td style="width:40%" align="left"><?= $penguji_ketua->nama ?></td>
					<td style="width:40%" align="left">(Ketua)</td>
				</tr>


				<tr>
					<td style="width:15%" align="left">2</td>
					<td style="width:40%" align="left"><?= $penguji_pembimbing->nama ?></td>
					<td style="width:40%" align="left">(Pembimbing & Penguji)</td>
				</tr>

				<?php
					$no = '3';
					foreach ($penguji_anggota as $list) {
						if ($list['usulan_dosbing'] != '2') {
							?>
							<tr>
								<td style="width:15%" align="left"><?= $no ?></td>
								<td style="width:40%" align="left"><?= $list['nama'] ?></td>
								<td style="width:40%" align="left">(Penguji)</td>
							</tr>
							<?php $no++;
						}
					} ?>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="left"><b>Nama</b></td>
					<td style="width:1%" align="left"><b>:</b></td>
					<td style="width:84%" align="left"><b><?= $proposal->nama ?></b></td>
				</tr>
				<tr>
					<td align="left"><b>NIM</b></td>
					<td align="left"><b>:</b></td>
					<td align="left"><b><?= $proposal->nim ?></b></td>
				</tr>
				<tr>
					<td align="left"><b>Judul Proposal</b></td>
					<td align="left"><b>:</b></td>
					<td align="left"><b><?= $judul->judul ?></b></td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:2%" align="left"></td>
					<td style="width:40%" align="left"></td>
					<td style="width:10%" align="left"></td>
					<td style="width:48%" align="left"></td>
				</tr>
				<tr>
					<td colspan="4" align="left">Demikian surat tugas ini diterbitkan agar dilaksanakan sebaik-baiknya.</td>
				</tr>

			</table>
			<br>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:60%;vertical-align: top" align="left">
						<img src="<?= $qr_dokumen ?>" width="80px">
					</td>
					<td style="width:40%" align="left">
						Surabaya, <?php echo tanggal_format_indonesia($dokumen->date_doc) ?><br>
						a.n. Dekan<br/>
						Wadek I<br/>
						<?php
							if (!empty($wadek->ttd)) {
								?>
								<br/><br/>
								<img src="<?= str_replace(base_url(), "", $wadek->ttd) ?>" width="80px"/>
								<br/>
								<?php
							} else {
								?>
								<br/><br/><br/>
								<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
								<br/><br/>
								<?php
							}
						?>
						<?= $wadek->nama ?><br/>
						NIP. <?= $wadek->nip ?>
					</td>
				</tr>
			</table>
			<br>
		</td>
	</tr>


</table>
</body>
</html>
