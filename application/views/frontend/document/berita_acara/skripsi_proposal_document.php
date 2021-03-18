<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>

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
					<td align="center"><u><b>BERITA ACARA UJIAN <?= $jadwal->status_ujian == 2 ? 'ULANG' : '' ?> PROPOSAL SKRIPSI</b></u></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:15%" align="left">Pada Hari ini <?php echo hari($jadwal->tanggal) ?> tanggal <?php echo woday_toindo($jadwal->tanggal) ?> telah dilaksanakan ujian proposal skripsi atas nama mahasiswa:</td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:15%" align="left">Nama</td>
					<td style="width:1%" align="left">:</td>
					<td style="width:84%" align="left"><?= $skripsi->nama ?></td>
				</tr>
				<tr>
					<td align="left">NIM</td>
					<td align="left">:</td>
					<td align="left"><?= $skripsi->nim ?></td>
				</tr>
				<tr>
					<td align="left">Minat Studi</td>
					<td align="left">:</td>
					<td align="left"><?= $skripsi->departemen ?></td>
				</tr>
				<tr>
					<td align="left">Judul Proposal</td>
					<td align="left">:</td>
					<td align="left"><?= $skripsi->judul ?></td>
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
					<td style="width:98%" align="left"></td>
				</tr>

				<tr>
					<td colspan="2" align="left">Berdasarkan hasil musyawarah Tim Penguji Proposal Skripsi diputuskan sebagai berikut:</td>
				</tr>
				<tr>
					<td align="left" style="vertical-align: top;">1.</td>
					<td align="left">Proposal skripsi yang diajukan oleh mahasiswa tersebut(pilih salah satu)</td>
				</tr>
				<?php
					if ($jadwal->hasil_ujian == 0) {
						?>
						<tr>
							<td align="left" style="vertical-align: top;"></td>
							<td align="left">
								<img src="assets/backend/cetak/kotak.png" width="10px"> LAYAK dan dapat dilanjutkan untuk penulisan skripsi.<br><br></td>
						</tr>
						<tr>
							<td align="left"></td>
							<td align="left">
								<img src="assets/backend/cetak/kotak.png" width="10px"> LAYAK dengan catatan perbaikan dan dapat dilanjutkan untuk penulisan skripsi.<br><br>
							</td>
						</tr>
						<tr>
							<td align="left"></td>
							<td align="left">
								<img src="assets/backend/cetak/kotak.png" width="10px"> TIDAK LAYAK dan harus diuji kembali pada hari _____________ tanggal ____________________.<br><br>
							</td>
						</tr>
						<?php
					} else if ($jadwal->hasil_ujian == HASIL_UJIAN_LANJUT) {
						if (!empty($jadwal->hasil_keterangan)) {
							?>
							<tr>
								<td align="left"></td>
								<td align="left">
									<img src="assets/backend/cetak/kotak_check.png" width="10px"> LAYAK dengan catatan perbaikan dan dapat dilanjutkan untuk penulisan skripsi.<br>
									Catatan : <i><b><?= $jadwal->hasil_keterangan ?></b></i><br><br>
								</td>
							</tr>
							<?php
						} else {
							?>
							<tr>
								<td align="left" style="vertical-align: top;"></td>
								<td align="left">
									<img src="assets/backend/cetak/kotak_check.png" width="10px"> LAYAK dan dapat dilanjutkan untuk penulisan skripsi.<br><br>
								</td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr>
							<td align="left"></td>
							<td align="left">
								<img src="assets/backend/cetak/kotak_check.png" width="10px"> TIDAK LAYAK dan harus diuji kembali pada hari _____________ tanggal ____________________.<br><br>
							</td>
						</tr>
						<?php
					}
				?>

				<tr>
					<td align="left" style="valign:top;">2.</td>
					<td align="left">Merekomendasikan dosen berikut ini sebagai Pembimbing Skripsi (diisi apabila dinyatakan LAYAK atau LAYAK DENGAN PERBAIKAN) :</td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">
						<?php if (!empty($pembimbing)) {
							?>
							- <?= $pembimbing->nama . ' (' . $pembimbing->nip . ')' ?>;
							<?php
						} else {
							?>
							- _____________________________________________________ ;
							<?php
						}
						?>

					</td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">(Mohon Ketua Departemen memberi lingkaran pada Pembimbing Skripsi yang dipilih dan diberi paraf.)</td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:40%" align="left">Tim Penguji Proposal Skripsi</td>
					<td style="width:20%" align="left"></td>
					<td style="width:40%" align="left"></td>
				</tr>
				<tr>
					<td align="left">Nama</td>
					<td align="left"></td>
					<td align="left">Tandatangan</td>
				</tr>
				<?php
					$no = 1;
					foreach ($pengujis as $penguji):
						?>
						<tr style="line-height: 2">
							<td align="left"><?php echo $no . '. ' . $penguji['nama']; ?></td>
							<td align="left"></td>
							<td align="left">
								<?php if (!empty($dokumen_persetujuan[$no - 1]['waktu'])) {
									if (!empty($penguji['ttd'])) {
										?>
										<img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="40px"/>
										<?php
									} else {
										?>
										<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
										<?php
									}
								} else {
									?>
									________________________________<br/>
									<?php
								} ?>
							</td>
						</tr>
						<?php
						$no++;
					endforeach;
				?>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="1" style="width:100%; border: 1px solid black;border-collapse: collapse;">
				<tr>
					<td style="width:33%" align="left">Tanggal :</td>
					<td style="width:33%" align="left">Tanggal :</td>
					<td style="width:33%" align="left">Tanggal :</td>
				</tr>
				<tr>
					<td align="left">
						Mengusulkan
						<br>
						Ketua Bagian,
						<?php
							if ($setujui_semua):
								if (!empty($kadep->ttd)) {
									?>
									<br/><br/>
									<img src="<?= str_replace(base_url(), "", $kadep->ttd) ?>" width="80px"/>
									<br/>
									<?php
								} else {
									?>
									<br/><br/><br/>
									<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
									<br/><br/>
									<?php
								}
							else:
								?>
								<br><br><br><br><br>
							<?php
							endif;
						?>
						<?= $kadep->nama_dosen . '<br>NIP. ' . $kadep->nip ?>
					</td>
					<td align="left">
						Menerima<br>
						<? if (!empty($pembimbing)) {
							?>
							<?= $pembimbing->status == '1' ? 'Usulan' : '' ?> Dosen Pembimbing,
							<?php
							if ($setujui_semua):
								if (!empty($pembimbing->ttd)) {
									?>
									<br/><br/>
									<img src="<?= str_replace(base_url(), "", $pembimbing->ttd) ?>" width="80px"/>
									<br/>
									<?php
								} else {
									?>
									<br/><br/><br/>
									<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
									<br/><br/>
									<?php
								}
							else:
								?>
								<br><br><br><br><br>
							<?php
							endif;
							?>
							<?= $pembimbing->nama . '<br>NIP. ' . $pembimbing->nip ?>
							<?php
						} else {
							?>
							Dosen Pembimbing,
							<br><br><br><br><br>
							(Belum diusulkan)
							<?php
						}
						?>
					</td>
					<td align="left">
						Menyetujui<br>
						KPS,
						<?php
							if ($setujui_semua):
								if (!empty($kps->ttd)) {
									?>
									<br/><br/>
									<img src="<?= str_replace(base_url(), "", $kps->ttd) ?>" width="80px"/>
									<br/>
									<?php
								} else {
									?>
									<br/><br/><br/>
									<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
									<br/><br/>
									<?php
								}
							else:
								?>
								<br><br><br><br><br>
							<?php
							endif;
						?>
						<?= $kps->nama_dosen . '<br>NIP. ' . $kps->nip ?></td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:20%" align="left"><br>Catatan :</td>
					<td style="width:50%" align="left"><br>Berita acara dibuat dalam enam rangkap untuk:</td>
					<td style="width: 30%" rowspan="5">
						<img src="<?= $qr_dokumen ?>" width="80px">
					</td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">- Sub Bagian Akademik</td>

				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">- Sub Bagian Keuangan</td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">- Ketua Departemen</td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">- Koordinator Program Studi</td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">- Dosen Pembimbing Skripsi yang ditunjuk</td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left">- Mahasiswa yang bersangkutan</td>
				</tr>
			</table>
		</td>
	</tr>

</table>

</body>
</html>
