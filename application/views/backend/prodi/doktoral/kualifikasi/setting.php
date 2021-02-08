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
				<h3 class="box-title">Setting Penasehat Akademik</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/penasehat_update'); ?>
				<div class="form-group">
					<label>Daftar Dosen</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
					<select name="nip" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($mdosen as $list) {
								?>
								<option value="<?php echo $list['nip'] ?>" <?= $list['nip'] == $disertasi->nip_penasehat ? 'selected' : ''; ?>><?php echo $list['nama'] ?></option>
								<?php
							}
						?>
					</select>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i> Simpan</button>
				</div>

				<?php echo form_close() ?>

			</div>
		</div>
		<!-- /.box -->
	</div>

	<!-- left column -->


</div>
