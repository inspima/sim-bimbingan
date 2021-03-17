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
				<h3 class="box-title">Info Tugas Akhir</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="form-group">
					<label>NIM</label>
					<p><?php echo $proposal->nim ?></p>
				</div>
				<div class="form-group">
					<label>Nama</label>
					<p><?php echo $proposal->nama ?></p>
				</div>
				<div class="form-group">
					<label>Judul</label>
					<p><?= $proposal->judul ?></p>
				</div>
				<div class="form-group">
					<label>Berkas Proposal</label>
					<p>
						<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $proposal->berkas_proposal ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="50px" height="auto"></a>
					</p>
				</div>


			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>

	<div class="col-md-4">

	</div>
	<div class="col-md-8">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">3. Dosen Pembimbing</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body table-responsive">
				<?php echo form_open('kadep/sarjana/kadep/proposal/pembimbing_save'); ?>
				<div class="form-group">
					<label>Pengajuan Pembimbing</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
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

				<!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i> Simpan</button>
				</div>
				<?php echo form_close() ?>
				<div class="form-group">
					<table class="table table-bordered">
						<tr>
							<th>Nama</th>
							<th>Opsi</th>
						</tr>
						<?php
							$pembimbing = $this->skripsi->read_pembimbing($proposal->id_skripsi);
							foreach ($pembimbing

									 as $listpembimbing) {
								?>
								<tr>
									<td>
										<?= $listpembimbing['status'] == '1' ? '<b class="text-primary">Usulan</b><br/>' : '' ?>
										<?php echo $listpembimbing['nama'] ?>
										<br/>
										<?= $listpembimbing['nip'] ?>
									</td>
									<td class="text-center">

										<?php
											if ($listpembimbing['status'] == '1') {
												?>
												<?php echo form_open('kadep/sarjana/kadep/proposal/pembimbing_delete') ?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
												<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
												<?php echo formtext('hidden', 'id_pembimbing', $listpembimbing['id_pembimbing'], 'required') ?>
												<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
												<?php echo form_close() ?>
												<?php
												if ($is_kadep == '1') {
													?>
													<br/>
													<?php echo form_open('kadep/sarjana/kadep/proposal/pembimbing_konfirm') ?>
													<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
													<?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
													<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
													<?php echo formtext('hidden', 'id_pembimbing', $listpembimbing['id_pembimbing'], 'required') ?>
													<button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check-square-o"></i> Konfirmasi
													</button>
													<?php echo form_close() ?>
													<?php
												}
											}
										?>
									</td>
								</tr>
								<?php
							}
						?>
					</table>
				</div>
			</div>
		</div>
		<!-- /.box -->
	</div>

</div>
