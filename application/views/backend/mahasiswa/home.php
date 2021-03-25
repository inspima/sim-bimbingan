<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header bg-gray-active">
				<h3 class="box-title">Biodata</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table class="table table-striped table-condensed">
					<tr>
						<td style="width: 170px">Nama</td>
						<td style="width: 10px">:
						</th>
						<td>
						<?php echo $biodata->nama ?></th>
					</tr>
					<tr>
						<td>NIM</td>
						<td style="width: 10px">:
						</th>
						<td>
						<?php echo $biodata->nim ?></th>
					</tr>
					<?php if ($biodata->id_prodi != null) { ?>
						<tr>
							<td>Program Studi</td>
							<td style="width: 10px">:
							</th>
							<td>
							<?php echo $biodata->nm_prodi ?></th>
						</tr>
					<?php } ?>
					<tr>
						<td>Alamat</td>
						<td style="width: 10px">:
						</th>
						<td>
						<?php echo $biodata->alamat ?></th>
					</tr>
					<tr>
						<td>Telp</td>
						<td style="width: 10px">:
						</th>
						<td>
						<?php echo $biodata->telp ?></th>
					</tr>
					<tr>
						<td>No HP / Whatsapp</td>
						<td style="width: 10px">:
						</th>
						<td>
						<?php echo $biodata->no_hp ?></th>
					</tr>
					<tr>
						<td>Email</td>
						<td style="width: 10px">:
						</th>
						<td>
						<?php echo $biodata->email ?></th>
					</tr>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header bg-green-gradient">
				<h3 class="box-title">Pengumuman</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th style="width: 5%">No</th>
						<th style="width: 75%">Pengumuman</th>
						<th>Tanggal</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($berita as $list) {
							$tanggal = DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime($list['tanggal_berita'])));
							$sekarang = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
							$diff = $tanggal->diff($sekarang)->format("%a");
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?=$diff<60?'<span class="label label-primary ">BARU</span><br/>':''?> <?= $list['isi_berita'] ?></td>
								<td><?= timespan(strtotime($list['tanggal_berita']), now(), 1) . ' ago' ?> </td>
							</tr>
							<?php
							$no++;
						}
					?>
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header bg-blue-gradient">
				<h3 class="box-title">Alur Pengajuan</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<ul class="timeline">
					<?php $this->view('backend/widgets/common/alur_pengajuan_tugas_akhir', ['jenjang' => $id_jenjang, 'tugas_akhir' => $tugas_akhir, 'prodi' => $biodata->id_prodi]); ?>
				</ul>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
