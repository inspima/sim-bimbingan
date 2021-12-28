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
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $subtitle ?></h3>
				<div class="pull-right">
					<a class="btn btn-xs btn-primary" href="<?= base_url() ?>prodi/doktoral/master/mkpkk/add">
						<i class="fa fa-plus"></i> Tambah</a>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th class="text-center">Departemen</th>
						<th class="text-center">Kode</th>
						<th class="text-center">Nama</th>
						<th class="text-center">SKS</th>
						<th class="text-center">Aktif</th>
						<th class="text-center">Aksi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($mkpkk as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['departemen'] ?></td>
								<td><?= $list['kode'] ?></td>
								<td><?= $list['nama'] ?></td>
								<td><?= $list['sks'] ?></td>
								<td class="text-center">
									<?php
										if ($list['status'] == '1') {
											?>
											<?php echo form_open('prodi/doktoral/master/mkpkk/update_aktif'); ?>
											<div class="form-group">
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_mkpkk', $list['id_mkpkk'], 'required') ?>
												<?php echo formtext('hidden', 'status', 0, 'required') ?>
												<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Aktif</button>
											</div>
											<?php echo form_close() ?>
											<?php
										} else {
											?>
											<?php echo form_open('prodi/doktoral/master/mkpkk/update_aktif'); ?>
											<div class="form-group">
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_mkpkk', $list['id_mkpkk'], 'required') ?>
												<?php echo formtext('hidden', 'status', 0, 'required') ?>
												<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Tidak</button>
											</div>
											<?php echo form_close() ?>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<a class="btn btn-xs btn-warning" href="<?= base_url() ?>prodi/doktoral/master/mkpkk/edit/<?= $list['id_mkpkk'] ?>">
										<i class="fa fa-edit"></i> Edit</a>
								</td>
							</tr>
							<?php
							$no++;
						}
					?>
					</tfoot>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
