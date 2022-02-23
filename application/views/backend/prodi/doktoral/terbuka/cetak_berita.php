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
					<td align="center"><h3>
							<b>BERITA ACARA UJIAN AKHIR DISERTASI TAHAP II
								<br/>(UJIAN TERBUKA)
							</b>
						</h3>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<table border="0" style="width:100%">
				<tr>
					<td>
						<p style="line-height: 2;margin: 5px">Pada hari ini <b><?php echo hari($jadwal->tanggal) ?></b> Tanggal
							<b> <?php echo woday_toindo($jadwal->tanggal) ?></b> pukul <b><?= substr($jadwal->jam, 0, 5); ?> - Selesai</b> WIB di
							<b>Ruang <?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?></b> Fakultas Hukum Universitas Airlangga, dilaksanakan Ujian Proposal :
						</p>
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
						<p style="line-height: 2">Yang dihadiri Tim Penyanggah Ujian Akhir Disertasi Tahap II (Ujian Terbuka) terdiri dari : </p>
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
							<td style="width: 65%"><?= $penguji['nama'] ?></td>
							<?php if ($no % 2 == 0):
								?>
								<td style="width: 16%"></td>
								<td style="width: 16%"><?= $no ?>..................</td>
							<?php
							else:
								?>
								<td style="width: 16%"><?= $no ?>..................</td>
								<td style="width: 16%"></td>
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
			<table border="0" style="width:100%;margin-top: 10px">
				<tr>
					<td>
						<p style="line-height: 2">
							Memutuskan bahwa Ujian Akhir Disertasi Tahap II (Ujian Terbuka) bagi mahasiswa tersebut : <br/>
							.................
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" style="width:100%;margin-top: 30px">
				<tr>
					<td style="width: 50%">

					</td>
					<td style="width: 50%">
						<p>
							Ketua Sidang.<br/><br/><br/><br/><br/><br/>
							..........................<br/>
							NIP. .............................
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>


</table>

</body>
</html>
