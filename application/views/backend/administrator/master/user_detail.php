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
				<h3 class="box-title">Password</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open('dashboarda/master/user/update_password'); ?>
			<div class="box-body">
				<div class="form-group">
					<label>Username</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_user', $user->id_user, 'required') ?>
					<input type="text" class="form-control" name="username" value="<?= $user->username ?>" readonly>
				</div>
				<div class="form-group">
					<label>Password Baru</label>
					<?php echo formtext('text', 'password', '', 'required') ?>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Ubah Password</button>
				<a class="btn btn-sm btn-warning" href="<?= base_url() ?>dashboarda/master/user"><i class="fa fa-close"></i> Batal</a>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
