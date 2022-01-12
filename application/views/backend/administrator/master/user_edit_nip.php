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
				<h3 class="box-title">Edit Dosen</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open('dashboarda/master/user/update_nip'); ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<?php echo formtext('hidden', 'id_pegawai', $pegawai->id_pegawai, 'required') ?>
			<div class="box-body">
				<div class="form-group">
					<label>Sebagai</label>
					<p><?= $pegawai->sebagai==1?'Dosen':'Tendik' ?></p>
				</div>
			</div>
			<div class="box-body">
				<div class="form-group">
					<label>Nama</label>
					<p><?= $pegawai->nama ?></p>
				</div>
			</div>
			<div class="box-body">
				<div class="form-group">
					<label>NIP/NIK</label>
					<input type="text" name="nip" class="form-control" value="<?= $pegawai->nip ?>" />
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<div class="callout callout-danger">Merubah NIP/NIK akan membuat beberapa fitur tidak berfungsi dengan baik
				</div>
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Lanjut Ubah</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
