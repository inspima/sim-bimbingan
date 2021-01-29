<?php if ($this->session->flashdata('msg')): ?>
	<?php
	$class_alert = 'alert ' . $this->session->flashdata('msg-title') . ' alert-dismissable';
	?>
	<div class='<?= $class_alert ?>'>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i> Notifikasi</h4>
		<?php echo $this->session->flashdata('msg'); ?>
	</div>
<?php endif; ?>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $subtitle ?></h3>
				<div class="pull-right">

				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<div class="col-md-4">
					<?php echo form_open('dashboardd/skripsi/kps_skripsi/filter_tahun'); ?>
					<div class="form-group">
						<label>Tahun</label>
						<?php echo formtext_angka('text', 'tahun', '', 'required') ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Tampil</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
			<!-- /.box-body -->
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Judul</th>
						<th>Pembimbing</th>
						<th>Departemen</th>
						<th>Gelombang / Semester</th>
						<th>Jadwal</th>
						<th>Penguji</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($skripsi as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['nama'] . '<br>' . $list['nim'] ?></td>
								<td><?php
										$judul = $this->skripsi->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?></td>
								<td><?php
										$pembimbing = $this->skripsi->read_pembimbing($list['id_skripsi']);
										echo $pembimbing->nama;
									?></td>
								<td><?php echo $list['departemen'] ?></td>
								<td><?= $list['gelombang'] . ' / ' . $list['semester'] ?></td>
								<td>
									<?php
										echo '<strong>Tanggal : </strong>' . toindo($list['tanggal']) . '<br>';
										echo '<strong>Jam     : </strong>' . $list['jam'] . '<br>';
										echo '<strong>Ruang   : </strong>' . $list['ruang'] . ' - ' . $list['gedung'] . '<br>';
									?>
								</td>
								<td>
									<?php
										$penguji = $this->skripsi->read_penguji($list['id_ujian']);
										foreach ($penguji as $show) {
											if ($show['status_tim'] == '1') {
												$ka = 'ketua';
											} else if ($show['status_tim'] == '2') {
												$ka = 'anggota';
											}

											if ($show['usulan_dosbing'] == '0') {
												$up = '';
											} else if ($show['usulan_dosbing'] == '1') {
												$up = '- usulan pembimbing';
											} else if ($show['usulan_dosbing'] == '2') {
												$up = '- pembimbing';
											}

											echo '- ' . $show['nama'] . '(' . $ka . $up . ')<br>';
										}
									?>
								</td>
								<td>
									<?php
										if ($list['status_skripsi'] == STATUS_SKRIPSI_UJIAN_SETUJUI_PENGUJI) {
											?>
											<?php echo form_open('dashboardd/skripsi/kps_skripsi/approve') ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
											<?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
											<?php echo formtext('hidden', 'status_skripsi', '4', 'required') ?>
											<button type="submit" class="btn btn-xs btn-primary"> Approve</button>
											<?php echo form_close() ?>
											<?php
										} else if ($list['status_skripsi'] >= STATUS_SKRIPSI_UJIAN_SETUJUI_KPS) {
											echo 'sudah approve';
										}
									?>
								</td>

							</tr>
							<?php
							$no++;
						}
					?>

					</tfoot>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
