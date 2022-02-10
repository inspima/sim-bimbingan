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

		table .padded tr th, table .padded tr td {
			padding: 8px;
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
					<td align="center"><h3 style="margin: 5px"><b>PENILAIAN UJIAN KUALIFIKASI</b></h3></td>
				</tr>
			</table>
		</td>
	</tr>


	<tr>
		<td>
			<table border="1" class="padded" style="width:100%;border-collapse: collapse;font-size: 1.2em">
				<tr>
					<td style="width:25%" align="left">NAMA</td>
					<td style="width:2%" align="left">:</td>
					<td style="width:50%" align="left"><?= $disertasi->nama ?></td>
				</tr>
				<tr>
					<td style="width:25%" align="left">NIM</td>
					<td style="width:2%" align="left">:</td>
					<td style="width:50%" align="left"><?= $disertasi->nim ?></td>
				</tr>

				<tr>
					<td style="width:25%" align="left">PROGRAM STUDI</td>
					<td style="width:2%" align="left">:</td>
					<td style="width:50%" align="left"><?= $disertasi->nm_prodi ?></td>
				</tr>

				<tr>
					<td style="width:25%" align="left">HARI, TANGGAL</td>
					<td style="width:2%" align="left">:</td>
					<td style="width:50%" align="left"><?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?></td>
				</tr>
				<tr>
					<td style="width:20%" align="left">PUKUL</td>
					<td style="width:2%" align="left">:</td>
					<td style="width:50%" align="left"><?= substr($jadwal->jam, 0, 5); ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="1" class="padded" style="width:100%;border-collapse: collapse;font-size: 1.2em;margin-top: 20px">
				<tr style="background-color: #ffffcc">
					<th style="text-align: center">PENGUJI</th>
					<th style="width: 55%;text-align: center">NAMA</th>
					<th style="width: 15%;text-align: center">NILAI <br/>(ANGKA)</th>
				</tr>
				<?php
					$index = 1;
					$total_nilai = 0;
					$sudah_menilai = 0;
					foreach ($pengujis as $penguji) {
						if(!empty($dokumen)){

							$persetujuan = $this->dokumen->read_persetujuan_by_identitas($dokumen->id_dokumen, $penguji['nip']);
							if (!empty($persetujuan)) {
								if(!empty($persetujuan->nilai)){
									$total_nilai += $persetujuan->nilai;
									$sudah_menilai = $sudah_menilai + 1;
								}
							}
						}
						?>
						<tr>
							<td>PENGUJI <?= $index++ ?></td>
							<td style="width: 55%"><?= $penguji['nama'] ?></td>
							<td style="width: 15%;text-align: center"><b> <?= !empty($persetujuan) ? $persetujuan->nilai : '' ?></b></td>
						</tr>
						<?php
					}
				?>
				<tr>
					<td></td>
					<td style="width: 55%">JUMLAH</td>
					<td style="width: 15%;text-align: center">
						<b><?= (count($pengujis) == $sudah_menilai) ? $total_nilai : '' ?> </b>
					</td>
				</tr>
				<tr>
					<td></td>
					<td style="width: 55%">NILAI RATA-RATA</td>
					<td style="width: 15%;text-align: center">
						<b><?= (count($pengujis) == $sudah_menilai) ? number_format($total_nilai / $sudah_menilai) : '' ?></b>
					</td>
				</tr>
			</table>
		</td>
	</tr>


</table>

<table border="0" style="width:100%">
	<tr>
		<td style="width:25%">
			<?= generateNewLineHTML(10) ?>
			<b>Keterangan :</b>
			<table border="1" style="width:100%; border: 1px solid black;border-collapse: collapse;text-align:center;">
				<tr>
					<td style="width:50%">NILAI ANGKA</td>
					<td style="width:50%">NILAI HURUF</td>
				</tr>
				<tr>
					<td>75-100</td>
					<td>A</td>
				</tr>
				<tr>
					<td>70-74,9</td>
					<td>AB</td>
				</tr>
				<tr>
					<td>65-69,9</td>
					<td>B</td>
				</tr>
				<tr>
					<td>60-64,9</td>
					<td>BC</td>
				</tr>
				<tr>
					<td>55-59,9</td>
					<td>C</td>
				</tr>
				<tr>
					<td>40-54,9</td>
					<td>Tidak Lulus</td>
				</tr>
			</table>
		</td>
		<td style="width: 30%"></td>
		<td style="width: 40%;vertical-align: top">
			<table border="0" style="width:100%;">
				<tr>
					<td align="left">Surabaya, <?php echo woday_toindo(date('Y-m-d')) ?></td>
				</tr>
				<tr>
					<td align="left">Ketua Tim Penguji Skripsi,</td>
				</tr>
				<tr>
					<td align="left">
						<?php
							if (!empty($ketua_penguji->ttd)) {
								?>
								<img src="<?= str_replace(base_url(), "", $ketua_penguji->ttd) ?>" width="70px"/>
								<?php
							} else {
								?>
								<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
								<?php
							}
						?>
					</td>
				</tr>
				<tr>
					<td align="left"><?php echo $ketua_penguji->nama ?></td>
				</tr>
				<tr>
					<td align="left">NIP. <?php echo $ketua_penguji->nip ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>
