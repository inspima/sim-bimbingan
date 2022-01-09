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
	<!-- left column -->
	<div class="col-md-4">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $subtitle ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="form-group">
					<label>NIM</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
					<input type="text" name="nim" class="form-control" value="<?php echo $skripsi->nim ?>" readonly>
				</div>
				<div class="form-group">
					<label>Nama</label>
					<input type="text" name="nama" class="form-control" value="<?php echo $skripsi->nama ?>" readonly>
				</div>
				<div class="form-group">
					<label>Judul</label>
					<?php
						$judul = $this->skripsi->read_judul($skripsi->id_skripsi);
					?>
					<textarea class="form-control" name="judul" readonly><?php echo $judul->judul ?></textarea>
				</div>
				<?php echo form_open('dashboardd/skripsi/kadep_blm_skripsi/update_pembimbing') ?>
				<div class="form-group">
					<label>Pembimbing</label>
					<?php
						$mdosen = $this->dosen->read_aktif($id_departemen);
						$pembimbing = $this->skripsi->read_pembimbing($skripsi->id_skripsi);
					?>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<input type="hidden" name="id_skripsi" class="form-control" value="<?php echo $skripsi->id_skripsi ?>">
					<select name="nip" class="form-control select2" style="width: 100%;" required>
						<option value="<?php echo $pembimbing->nip ?>"><?php echo $pembimbing->nama ?></option>
						<?php
							foreach ($mdosen as $list) {
								?>
								<option value="<?php echo $list['nip'] ?>"><?php echo $list['nama'] ?></option>
								<?php
							}
						?>
					</select>
					<br><br>
					<p>
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Ubah Pembimbing</button>
					</p>

				</div>
				<?php echo form_close() ?>

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>

	<div class="col-md-8">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Ujian</h3>
				<div class="pull-right">
					<?php
						if (count($ujian) == 0) {
							?>
							<?php echo form_open('dashboardd/skripsi/kadep_blm_skripsi/ujian_simpan'); ?>
							<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
							<?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
							<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah</button>
							<?php echo form_close() ?>
							<?php
						}
					?>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Ujian</th>
						<th>Jadwal</th>
						<th>Penguji</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($ujian as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?php if ($list['status_ujian'] == '1') {
										echo 'utama';
									} else {
										echo 'ulang';
									} ?></td>
								<td>
									<?php
										$jadwal = $this->skripsi->detail_ujian($list['id_ujian']);
										if ($jadwal) {
											echo '<strong>Tanggal : </strong>' . toindo($jadwal->tanggal) . '<br>';
											echo '<strong>Jam     : </strong>' . $jadwal->jam . '<br>';
											echo '<strong>Ruang   : </strong>' . $jadwal->ruang . ' - ' . $jadwal->gedung . '<br>';
										}
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
									<a class="btn btn-xs btn-primary pull-left" href="<?= base_url() ?>dashboardd/skripsi/kadep_blm_skripsi/ujian_plot/<?= $list['id_skripsi'] ?>/<?php echo $list['id_ujian'] ?>">
										<i class="fa fa-gear"></i> Setting Ujian</a>
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

</div>
