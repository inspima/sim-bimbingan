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
					<a class="btn btn-xs btn-primary" href="<?= base_url() ?>baa/master/pekan/add">
						<i class="fa fa-plus"></i> Tambah</a>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Jenis</th>
						<th class="text-center">Periode</th>
						<th class="text-center">Status</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($pekans as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['nama'] ?></td>
								<td><?= ucfirst($list['jenis']) ?></td>
								<td class="text-center">
									<?php
										if (!empty($list['tgl_awal']) && !empty($list['tgl_akhir'])) {
											echo '<b>' . woday_toindo($list['tgl_awal']) . '</b>  - <b> ' . woday_toindo($list['tgl_akhir']) . ' </b > ';
										} else {
											?>
											<label class="text-danger text-sm">Periode Kosong</label>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<?php
										if ($list['status'] == '0') {
											?>
											<button type="button" class="btn btn-xs btn-danger" style="margin-right:3px;">
												<i class="fa fa-close"></i> Tidak Aktif
											</button>
											<?php
										} else if ($list['status'] == '1') {
											?>
											<button type="button" class="btn btn-xs btn-success" style="margin-right:3px;">
												<i class="fa fa-check"></i> Aktif
											</button>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<a class="btn btn-xs btn-warning" href="<?= base_url() ?>baa/master/pekan/edit/<?= $list['id_pekan'] ?>">
										<i class="fa fa-edit"></i> Edit
									</a>
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
