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
			<?php echo form_open('baa/master/ruang/save'); ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<div class="box-body">
				<div class="form-group">
					<label>Gedung</label>
					<?php echo formtext('text', 'gedung', '', 'required') ?>
				</div>
				<div class="form-group">
					<label>Ruang</label>
					<?php echo formtext('text', 'ruang', '', 'required') ?>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
				<a class="btn btn-sm btn-warning" href="<?= base_url() ?>baa/master/ruang"><i class="fa fa-close"></i> Batal</a>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
