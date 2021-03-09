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
			<?php echo form_open('baa/master/pekan/save',['autocomplete'=>'off']); ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<div class="box-body">
				<div class="form-group">
					<label>Nama</label>
					<input class="form-control" type="text" name="nama" value="" placeholder="Pekan Skripsi Gel 1" required>
				</div>
				<div class="form-group">
					<label>Jenis</label>
					<select name="jenis" class="form-control select2" style="width: 100%;" required>
						<option value="skripsi">Skripsi</option>
					</select>
				</div>
				<div class="form-group">
					<label>Periode Awal</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="periode_awal" value="" class="form-control pull-right datepicker" required>
					</div>
				</div>
				<div class="form-group">
					<label>Periode Akhir</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="periode_akhir" value="" class="form-control pull-right datepicker" required>
					</div>
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
