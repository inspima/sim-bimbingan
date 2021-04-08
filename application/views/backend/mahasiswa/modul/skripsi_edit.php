<?php $judul = $this->skripsi->read_judul($skripsi->id_skripsi); ?>
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
				<h3 class="box-title">Judul Skripsi</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open('dashboardm/modul/skripsi/update'); ?><?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
			<?php echo formtext('hidden', 'id_judul', $judul->id_judul, 'required') ?>

			<div class="box-body">
				<div class="form-group">
					<label>Judul</label>
					<textarea class="form-control" name="judul" rows="4" style="resize: none" required><?php echo $judul->judul ?></textarea>
				</div>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i> Simpan</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>

<div class="row">
	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Update File</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open_multipart('dashboardm/modul/skripsi/update_file'); ?>
			<div class="box-body">
				<div class="form-group">
					<label>Berkas Skripsi, Turnitin & TOEFL (jadikan 1 file - format file .pdf maks <?= MAX_SIZE_FILE_UPLOAD / 1000 ?>)</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
					<input type="file" name="file" class="form-control" required>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-upload"></i> Upload</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
