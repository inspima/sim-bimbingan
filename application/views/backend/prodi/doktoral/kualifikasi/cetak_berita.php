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
	<title>BERITA ACARA DISERTASI - UJIAN KUALIFIKASI - <?= $disertasi->nim ?></title>
</head>
<body>


<?php $this->load->view('backend/widgets/common/header_document') ?>

<table border="0" style="width:100%">

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="center"><h3><b>BERITA ACARA UJIAN KUALIFIKASI</b></h3></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td>
						<p style="line-height: 2;margin: 5px">Pada hari ini <b><?php echo hari($jadwal->tanggal) ?></b> Tanggal <b> <?php echo woday_toindo($jadwal->tanggal) ?></b> pukul
							<b><?= substr($jadwal->jam, 0, 5); ?> - Selesai</b> WIB
							dilaksanakan Ujian Kualifikasi
							<?php
								if ($jadwal->ruang == 'ON') {
								?>
								secara Online melalui Video Conference <br/>
								<?php
								if (!empty($jadwal->link_meeting)) {
									?>
									(Link meeting : <?= !empty($jadwal->link_meeting) ? '<span style="color: blue">' . $jadwal->link_meeting . '</span>' : '' ?>)
									<?php
								}
							} else {
							?>
							di <b>Ruang <?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?></b> Fakultas Hukum Universitas Airlangga</p>
						<?php

							}

						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:3%">

					</td>
					<td style="width:10%">
						NAMA
					</td>
					<td style="width:2%">:</td>
					<td style="width:85%">

						<b><?php echo $disertasi->nama ?></b>
					</td>
				</tr>
				<tr>
					<td style="width:3%">

					</td>
					<td style="width:10%">
						NIM
					</td>
					<td style="width:2%">:</td>
					<td style="width:85%">
						<b><?php echo $disertasi->nim ?></b>
					</td>
				</tr>
				<tr>
					<td style="width:3%">

					</td>
					<td style="width:10%">
						JUDUL
					</td>
					<td style="width:2%">:</td>
					<td style="width:85%">
						<b><?php echo $disertasi->judul ?></b>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" style="width:100%;margin-top: 10px">
				<tr>
					<td>
						Yang dihadiri Tim Penguji Ujian Kualifikasi terdiri dari :
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" style="width:80%;margin-left: 10px">
				<?php
					$no = 1;
					foreach ($pengujis as $penguji):
						?>
						<tr style="line-height: 2">
							<td style="width: 3%"><b><?= $no ?></b>.</td>
							<td style="width: 57%"><?= $penguji['nama'] ?></td>
							<td style="width: 15%">(<?= $penguji['status_tim'] == 1 ? 'Ketua' : 'Anggota' ?>)</td>
							<?php if ($no % 2 == 0):
								?>
								<td style="width: 13%"></td>
								<td style="width: 13%;text-align: left;vertical-align: center">
									<?php if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
										?>
										<?= $no ?>.
										<?php $this->load->view('backend/widgets/common/element_ttd_small', ['ttd' => $penguji['ttd']]) ?>
									<?php
									else:
										?>
										<?= $no ?>  .........
									<?php
									endif;
									?>
								</td>
							<?php
							else:
								?>
								<td style="width: 15%;text-align: left;vertical-align: center">
									<?php if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
										?>
										<?= $no ?>.
										<?php $this->load->view('backend/widgets/common/element_ttd_small', ['ttd' => $penguji['ttd']]) ?>
									<?php
									else:
										?>
										<?= $no ?>  ..........
									<?php
									endif;
									?>
								</td>
								<td style="width: 15%"></td>
							<?php
							endif;
							?>
						</tr>
						<?php
						$no++;
					endforeach;
				?>


			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%;margin-top: 5px">
				<tr>
					<td>
						Memutuskan bahwa Ujian Kualifikasi bagi mahasiswa tersebut :
					</td>
				</tr>

				<?php
					if ($jadwal->hasil_ujian == 0) {
						?>
						<tr>
							<td style="padding-left: 10px;line-height: 1.5">
								a.LULUS dengan Nilai : ……………
							</td>
						</tr>
						<tr>
							<td style="padding-left: 10px;line-height: 1.5">
								b.MENGULANG KEMBALI : ……………
							</td>
						</tr>
						<tr>
							<td style="padding-left: 10px;line-height: 1.5">
								c.GAGAL STUDI karena TIDAK LULUS pada UJIAN KEDUA : ……………
							</td>
						</tr>
						<?php
					} else if ($jadwal->hasil_ujian == HASIL_UJIAN_LANJUT) {
						?>
						<td style="padding-left: 10px;line-height: 1.5">
							a.LULUS dengan Nilai : <?= !empty($jadwal->hasil_nilai) ? ' ' . $jadwal->hasil_nilai . ' ' : ' - ' ?>
						</td>

						<?php
					} else if ($jadwal->hasil_ujian != HASIL_UJIAN_LANJUT && $jadwal->hasil_ujian > 0) {
						?>
						<tr>
							<td style="padding-left: 10px;line-height: 1.5">
								b.MENGULANG KEMBALI : ……………
							</td>
						</tr>
						<?php
					}else {
						?>

						<tr>
							<td style="padding-left: 10px;line-height: 1.5">
								c.GAGAL STUDI karena TIDAK LULUS pada UJIAN KEDUA : ……………
							</td>
						</tr>
						<?php
					}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" style="width:100%;margin-top: 10px">
				<tr>
					<td style="width: 50%">
						<img src="<?= $qr_dokumen ?>" width="100px">
					</td>
					<td style="width: 50%">
						<p>
							Ketua Penguji.
							<?php
								if ($setujui_semua):
									$this->load->view('backend/widgets/common/element_ttd', ['ttd' => $ketua_penguji->ttd]);
								else:
									?>
									<br/><br/><br/><br/><br/><br/>
								<?php
								endif;
							?>
							<?= $ketua_penguji->nama ?><br/>
							NIP. <?= $ketua_penguji->nip ?>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>


</table>

</body>
</html>
