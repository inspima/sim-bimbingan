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

<table align="center" width="100%" border="0">
	<tbody>
	<tr>
		<td width="10%"><img src="assets/backend/cetak/logo.png" width="100px"></td>
		<td width="90%" align="center">
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
	</tbody>
</table>

<table border="0" style="width:100%">

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="center"><b>BERITA ACARA UJIAN SKRIPSI</b></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:15%" align="left">Berdasarkan Surat Keputusan Dekan Fakultas Hukum Universitas Airlangga tanggal <?php echo $gelombang->tgl_sk ?> Nomor : <?php echo $gelombang->no_sk ?> tentang Penguji Skripsi Semester <?php echo $gelombang->semester ?>, maka pada hari
						<b><?php echo hari($skripsi->tanggal) ?></b> tanggal
						<b><?php echo woday_toindo($skripsi->tanggal) ?></b> pukul <?= substr($skripsi->jam, 0, 5); ?> WIB di <?= $skripsi->ruang . ' ' . $skripsi->gedung ?>
						<br>
						Tim Penguji Skripsi yang terdiri atas :
					</td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:15%" align="left"><b>Ketua</b></td>
					<td style="width:5%" align="left">:</td>
					<td style="width:40%" align="left"><?= $penguji_ketua->nama ?></td>
					<td style="width:40%" align="left">(Penguji)</td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">:</td>
					<td align="left">1. <b><?= $penguji_pembimbing->nama ?></b></td>
					<td align="left">(Pembimbing & Penguji)</td>
				</tr>
				<?php
					$no = '2';
					foreach ($penguji_anggota as $list) {
						?>
						<tr>
							<td align="left"></td>
							<td align="left"></td>
							<td align="left"><?= $no ?>. <?= $list['nama'] ?></td>
							<td align="left">(Penguji)</td>
						</tr>
						<?php $no++;
					} ?>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:15%" align="left"><b>Nama</b></td>
					<td style="width:1%" align="left"><b>:</b></td>
					<td style="width:84%" align="left"><b><?= $skripsi->nama ?></b></td>
				</tr>
				<tr>
					<td align="left"><b>NIM</b></td>
					<td align="left"><b>:</b></td>
					<td align="left"><b><?= $skripsi->nim ?></b></td>
				</tr>
				<tr>
					<td align="left"><b>Judul Skripsi</b></td>
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
					<td colspan="4" align="left">Setelah Ujian dilaksanakan Tim Penguji Skripsi memutuskan bahwa mahasiswa tersebut diatas dinyatakan :</td>
				</tr>
				<tr>
					<td style="width:2%" align="left">1.</td>
					<td style="width:30%" align="left">Lulus dengan nilai</td>
					<td style="width:1%" align="left">:</td>
					<td style="width:67%" align="left"></td>
				</tr>
				<tr>
					<td align="left">2.</td>
					<td align="left">masih harus diuji kembali pada hari</td>
					<td align="left">:</td>
					<td align="left">,tanggal</td>
				</tr>
				<tr>
					<td colspan="2" align="left">Berita acara ini dibuat kembali pada hari</td>
					<td align="left">:</td>
					<td align="left"></td>
				</tr>

			</table>
			<br>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:10%" align="left"></td>
					<td style="width:5%" align="left"></td>
					<td style="width:85%" align="left"></td>
				</tr>
				<tr>
					<td colspan="3" align="left">Tanda tangan Panitia Penguji :<br><br><br></td>
				</tr>
				<tr>
					<td align="left">Ketua</td>
					<td align="left">:</td>
					<td align="left">..........................................................................</td>
				</tr>
				<tr>
					<td align="left"><br><br><br></td>
					<td align="left"></td>
					<td align="left"></td>
				</tr>
				<tr>
					<td align="left">Anggota</td>
					<td align="left">:</td>
					<td align="left">1. ......................................................................</td>
				</tr>
				<tr>
					<td align="left"><br><br><br></td>
					<td align="left"></td>
					<td align="left"></td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">:</td>
					<td align="left">2. ......................................................................</td>
				</tr>
				<tr>
					<td align="left"><br><br><br></td>
					<td align="left"></td>
					<td align="left"></td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">:</td>
					<td align="left">3. ......................................................................</td>
				</tr>
				<tr>
					<td align="left"><br><br><br></td>
					<td align="left"></td>
					<td align="left"></td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">:</td>
					<td align="left">4. ......................................................................</td>
				</tr>


			</table>
			<br>
		</td>
	</tr>


</table>

</body>
</html>
