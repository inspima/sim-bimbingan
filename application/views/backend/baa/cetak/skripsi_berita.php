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
						<b><?php echo hari($jadwal->tanggal) ?></b> tanggal
						<b><?php echo woday_toindo($jadwal->tanggal) ?></b> pukul <?= substr($jadwal->jam, 0, 5); ?> WIB di <?= $jadwal->ruang . ' ' . $jadwal->gedung ?>
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
						if ($list['usulan_dosbing'] != '2') {
							?>
							<tr>
								<td align="left"></td>
								<td align="left"></td>
								<td align="left"><?= $no ?>. <?= $list['nama'] ?></td>
								<td align="left">(Penguji)</td>
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
				<?php
					if ($jadwal->hasil_ujian == 0) {
						?>
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
						<?php
					} else if ($jadwal->hasil_ujian == HASIL_UJIAN_LANJUT) {
						?>
						<tr>
							<td align="left">1.</td>
							<td align="left">Lulus dengan nilai : <?=!empty($jadwal->hasil_nilai)?' '.$jadwal->hasil_nilai.' ':' - '?></td>
							<td align="left"></td>
							<td align="left"></td>
						</tr>
						<?php
					} else if ($jadwal->hasil_ujian != HASIL_UJIAN_LANJUT && $jadwal->hasil_ujian > 0) {
						?>
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
						<?php
					}
				?>


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
				<?php
					foreach ($dokumen_persetujuan_ketua as $dpk) {
						?>

						<tr>
							<td align="left">Ketua</td>
							<td align="left">:</td>
							<td align="left">
								<?php if (!empty($dpk['waktu'])) {
									if (!empty($penguji_ketua->ttd)) {
										?>
										<img style="margin-left: 20px" src="<?= str_replace(base_url(), "", $penguji_ketua->ttd) ?>" width="60px"/>
										<br/>
										<?= $dpk['nama'] ?>
										<?php
									} else {
										?>
										<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
										<?php
									}
								} else {
									?>
									..........................................................................<br/>
									<?php
								} ?>
							</td>
						</tr>
						<?php
					}
				?>
				<tr>
					<td align="left"><br><br><br></td>
					<td align="left"></td>
					<td align="left"></td>
				</tr>
				<?php
					$no = 1;
					foreach ($dokumen_persetujuan_anggota as $dpa) {
						if ($no == 1) {
							?>

							<tr>
								<td align="left">Anggota</td>
								<td align="left">:</td>
								<td align="left"><?= $no ?>.
									<?php if (!empty($dpa['waktu'])) {
										if (!empty($penguji_anggota[$no - 1]['ttd'])) {
											?>
											<img style="margin-left: 20px" src="<?= str_replace(base_url(), "", $penguji_anggota[$no - 1]['ttd']) ?>" width="60px"/>
											<br/>
											<?= $dpa['nama'] ?>
											<?php
										} else {
											?>
											<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
											<?php
										}
									} else {
										?>
										..........................................................................<br/>
										<?php
									} ?>
								</td>
							</tr>

							<tr>
								<td align="left"><br><br><br></td>
								<td align="left"></td>
								<td align="left"></td>
							</tr>
							<?php
						} else {
							?>

							<tr>
								<td align="left"></td>
								<td align="left">:</td>
								<td align="left"><?= $no ?>.
									<?php if (!empty($dpa['waktu'])) {
										if (!empty($penguji_anggota[$no - 1]['ttd'])) {
											?>
											<img style="margin-left: 20px" src="<?= str_replace(base_url(), "", $penguji_anggota[$no - 1]['ttd']) ?>" width="60px"/>
											<br/>
											<?= $dpa['nama'] ?>
											<?php
										} else {
											?>
											<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
											<?php
										}
									} else {
										?>
										..........................................................................<br/>
										<?php
									} ?>
								</td>
							</tr>
							<tr>
								<td align="left"><br><br><br></td>
								<td align="left"></td>
								<td align="left"></td>
							</tr>
							<?php
						}
						$no++;
					}
				?>

				<tr>
					<td colspan="3">
						<img src="<?= $qr_dokumen ?>" width="80px">
					</td>
				</tr>
			</table>
		</td>
	</tr>


</table>

</body>
</html>
