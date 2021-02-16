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
			<?php echo form_open('dashboardb/master/semester/save',['autocomplete'=>'off']); ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<div class="box-body">
				<div class="form-group">
					<label>Nama Semester</label>
					<input class="form-control" type="text" name="semester" value="" placeholder="Gasal 2022/2023" required>
				</div>
				<div class="form-group">
					<label>Tahun Semester</label>
					<input class="form-control" type="number" name="tahun" value="" placeholder="2022" required>
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
				<a class="btn btn-sm btn-warning" href="<?= base_url() ?>dashboardb/master/semester"><i class="fa fa-close"></i> Batal</a>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
