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
	<div class="col-sm-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h2 class="box-title">Informasi Disertasi</h2>

			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<?php $this->view('backend/widgets/disertasi/informasi_disertasi_judul', ['disertasi' => $disertasi]); ?>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>

	<!-- left column -->
	<div class="col-sm-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">1. Setting Jadwal</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<?php
					$this->view('backend/widgets/disertasi/form_jadwal_dosen', ['disertasi' => $disertasi, 'ujian' => $ujian, 'mruang' => $mruang, 'mjam' => $mjam, 'jenis' => UJIAN_DISERTASI_PROPOSAL]);
				?>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>

	<!-- left column -->


</div>
<div class="row">
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">3. Calon Penguji</h3>
			</div>
			<div class="box-body table-responsive">
				<?php
					if ($ujian) {
						$cek_penguji_ketua = $this->disertasi->read_penguji_ketua($ujian->id_ujian);
						if (empty($cek_penguji_ketua)) {
							?>
							<div class="callout callout-danger">Perhatian ! Ketua penguji belum dipilih</div>
							<?php
						}
						if (!$this->disertasi->cek_penguji_promotor($disertasi->id_disertasi, $ujian->id_ujian)) {
							?>
							<b>Penguji dari Promotor & Ko-Promotor</b>
							<?php $this->view('backend/widgets/disertasi/list_penguji_promotor_dosen', ['disertasi' => $disertasi, 'id_ujian' => $ujian->id_ujian, 'promotors' => $promotors]); ?>
							<?php
						}
						?>
						<b>Rekomendasi penguji Ujian Terbuka</b>
						<p>Berdasarkan jumlah pengujian dan urutan nama dibatasi 5</p>
						<?php $this->view('backend/widgets/disertasi/list_terbuka_rekom_penguji', ['disertasi' => $disertasi, 'id_ujian' => $ujian->id_ujian, 'promotors' => $promotors]); ?>
						<hr class="divider-line-semi-bold"/>
						<div class="divider10"></div>
						<?php echo form_open('dosen/disertasi/terbuka/penguji_save'); ?>
						<div class="form-group">
							<label>Cari Penguji</label>
							<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
							<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
							<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
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
							<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan
							</button>
						</div>

						<?php echo form_close() ?>
						<?php $this->view('backend/widgets/disertasi/list_penguji_dosen', ['disertasi' => $disertasi, 'ujian' => $ujian]); ?>
						<?php echo form_open('dosen/disertasi/terbuka/penguji/kirim_whatsapp'); ?>
						<div class="form-group">
							<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
							<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
							<button type="submit" class="btn btn-sm btn-success">
								<i class="fa fa-comment"></i> Kirim Notifikasi Whatsapp
							</button>
						</div>
						<?php echo form_close() ?>
						<?php
					} else {
						?>
						<div class="form-group">
							<p>Setting ujian terlebih dahulu</p>
						</div>
						<?php
					}
				?>
			</div>
		</div>
		<!-- /.box -->
	</div>
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">4. Status Ujian</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open('dosen/disertasi/terbuka/update_status_ujian'); ?>

			<div class="box-body">
				<div class="form-group">
					<label>Status Ujian</label>

					<select name="status_ujian" class="form-control select2" style="width: 100%;" required>
						<?php
							foreach ($status_ujians as $status_ujian) {
								?>
								<option value="<?php echo $status_ujian['value'] ?>" <?php if ($status_ujian['value'] == $disertasi->status_ujian_terbuka)
									echo 'selected' ?>><?php echo $status_ujian['text'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
			</div>
			<div class="box-footer">
				<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
				<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
				<!--<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Status Ujian</button>-->
			</div>
			<!-- /.box-body -->
			<?php echo form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
