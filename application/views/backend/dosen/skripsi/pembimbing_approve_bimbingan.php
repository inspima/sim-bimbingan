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
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $subtitle ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="form-group">
					<label>Nama</label>
					<p>
						<?php
							echo $skripsi->nama;
						?>
					</p>
				</div>
				<div class="form-group">
					<label>Judul</label>
					<textarea class="form-control" name="judul"><?php
							$judul = $this->pembimbing->read_judul($skripsi->id_skripsi);
							echo $judul->judul;
						?></textarea>
				</div>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>

	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Bimbingan</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Materi</th>
							<th>Status</th>
							<th>Opsi</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($bimbingan as $list) {
								?>
								<tr>
									<td><?= $no ?></td>
									<td><?php echo toindo($list['tanggal']) ?>
									</td>
									<td style="max-width: 220px;"><p style="width:200px;white-space: pre-wrap"><?php echo $list['hal'] ?></p></td>
									<td>
										<?php
											if ($list['status'] == '1') {
												echo 'Belum disetujui';
											} else if ($list['status'] == '2') {
												echo 'Disetujui';
											}
										?>
									</td>
									<td>
										<?php
											if ($list['status'] == '1') {
												?>
												<?php echo form_open('dashboardd/skripsi/pembimbing_approve/bimbingan_update') ?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
												<?php echo formtext('hidden', 'id_bimbingan', $list['id_bimbingan'], 'required') ?>
												<?php echo formtext('hidden', 'status', '2', 'required') ?>
												<button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check-circle"></i> Approve</button>
												<?php echo form_close() ?>
												<?php echo form_open('dashboardd/skripsi/pembimbing_approve/bimbingan_update') ?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
												<?php echo formtext('hidden', 'id_bimbingan', $list['id_bimbingan'], 'required') ?>
												<?php echo formtext('hidden', 'status', '3', 'required') ?>
												<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Tolak</button>
												<?php echo form_close() ?>
												<?php
											} else {

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
			</div>

		</div>
		<!-- /.box -->
	</div>

</div>


<div class="row">
	<!-- left column -->
	<div class="col-md-6">
		&nbsp;
	</div>

	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Pengajuan Penguji</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<?php echo form_open('dashboardd/skripsi/pembimbing_approve/save_penguji') ?>
				<div class="form-group">
					<label>Penguji</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
					<select name="nip" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($mdosen as $list) {
								?>
								<option value="<?php echo $list['nip'] ?>"><?php echo $list['nama'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
				</div>
				<?php echo form_close() ?>
				<div class="form-group">
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>Nama</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td><?php
									if ($penguji_temp) {
										echo $penguji_temp->nama . '<br/>' . $penguji_temp->nip;
									} else {

									}
								?>
							</td>
						</tr>
						</tfoot>
					</table>
				</div>
			</div>

		</div>
		<!-- /.box -->
	</div>
</div>

<div class="row">
	<!-- left column -->
	<div class="col-md-6">
		&nbsp;
	</div>

	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Approve Skripsi</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="form-group">
					<label>Status</label>
					<?php
						if ($skripsi->status_skripsi == '0') {
							$sttsk = 'Mahasiswa belum daftar';
						} else if ($skripsi->status_skripsi == '1') {
							$sttsk = 'Mahasiswa sudah daftar / BAA Belum Approve';
						} else if ($skripsi->status_skripsi == '2') {
							$sttsk = 'BAA Approved / Pembimbing Belum Approve';
						} else if ($skripsi->status_skripsi == '3') {
							$sttsk = 'Pembimbing Approved / Setting Kadep';
						} else if ($skripsi->status_skripsi == '4') {
							$sttsk = 'KPS Approved';
						} else if ($skripsi->status_skripsi == '5') {
							$sttsk = 'KPS Approved';
						} else {
							$sttsk = '';
						}
					?>
					<p><?php echo $sttsk; ?></p>
				</div>
				<?php
					if ($skripsi->status_skripsi == STATUS_SKRIPSI_UJIAN_SETUJUI_BAA) {
						?>
						<?php echo form_open('dashboardd/skripsi/pembimbing_approve/approve_skripsi') ?>
						<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
						<?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
						<div class="form-group">
							<p>
								<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-ok"></i> Setujui</button>
							</p>
						</div>
						<?php echo form_close() ?>
						<?php
					} else {

					}
				?>
			</div>

		</div>
		<!-- /.box -->
	</div>
</div>   
