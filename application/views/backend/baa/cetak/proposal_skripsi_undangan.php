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
					<td align="right"><?php echo woday_toindo($dokumen->date_doc); ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:15%" align="left">Nomor</td>
					<td style="width:1%" align="left">:</td>
					<td style="width:84%" align="left"><?= $dokumen->no_doc; ?></td>
				</tr>
				<tr>
					<td align="left">Lampiran</td>
					<td align="left">:</td>
					<td align="left">1 (satu) jilid naskah proposal skripsi</td>
				</tr>
				<tr>
					<td align="left">Perihal</td>
					<td align="left">:</td>
					<td align="left"><strong>Pemberitahuan ujian proposal skripsi</strong></td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="left">Kepada Yth.</td>
				</tr>
				<tr>
					<td align="left">Sdr. <strong><?= $proposal->nama ?></strong></td>
				</tr>
				<tr>
					<td align="left">NIM. <strong><?= $proposal->nim ?></strong></td>
				</tr>
				<tr>
					<td align="left"><?= str_replace('+62','0',$proposal->no_hp) ?></td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="justify">Dengan ini diberitahukan bahwa pelaksanaan ujian proposal skripsi yang anda ajukan akan diselenggarakan pada:</td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:15%" align="left">Hari/ tanggal</td>
					<td style="width:1%" align="left">:</td>
					<td style="width:84%" align="left"><?php echo wday_toindo($jadwal->tanggal) ?></td>
				</tr>
				<tr>
					<td align="left">Jam</td>
					<td align="left">:</td>
					<td align="left"><?php echo $jadwal->jam . ' WIB' ?></td>
				</tr>
				<tr>
					<td align="left">Tempat</td>
					<td align="left">:</td>
					<td align="left"><?php echo $jadwal->ruang . ' - ' . $jadwal->gedung ?></td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="justify">Dengan Tim Penguji adalah Dosen sebagaimana disebutkan pada bagian tembusan surat ini.</td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td align="justify">Dimohon agar Saudara untuk mempersiapkan diri sebagaimana mestinya.</td>
				</tr>
			</table>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td style="width:70%" align="left">

					</td>
					<td style="width:30%" align="left">
						a.n. Dekan<br/>
						Wakil Dekan I
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

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td colspan="2" style="width:50%" align="left">Tembusan Yth.</td>
				</tr>
				<?php
					$no = 1;
					foreach ($penguji as $list) {
						?>
						<tr>
							<td style="width:70%;" align="left"><?= $no . '. ' . $list['nama'] ?></td>
							<td style="width:30%;" align="right">
								<?php
									if ($list['status_tim'] == '2') {
										$tim = 'Anggota';
									} else if ($list['status_tim'] == '1') {
										$tim = 'Ketua';
									}
									echo '( ' . $tim . ' )';
								?>
							</td>
						</tr>
						<?php
						$no++;
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
					<td align="left"><strong>Catatan</strong></td>
				</tr>
				<tr>
					<td align="left">Kepada mahasiswa agar mengenakan busana sebagai berikut:</td>
				</tr>
				<tr>
					<td align="left">- atasan kemeja warna putih dengan dasi hitam;</td>
				</tr>
				<tr>
					<td align="left">- bawahan celana panjang warna hitam untuk pria, rok warna hitam untuk wanita;</td>
				</tr>
				<tr>
					<td align="left">- sepatu formal warna hitam.</td>
				</tr>
				<tr>
					<td><img src="<?= $qr_dokumen ?>" width="80px"></td>
				</tr>
			</table>
		</td>
	</tr>

</table>

</body>
</html>
