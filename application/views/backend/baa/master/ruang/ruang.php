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
					<a class="btn btn-xs btn-primary" href="<?= base_url() ?>baa/master/ruang/add">
						<i class="fa fa-plus"></i> Tambah</a>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Gedung</th>
						<th>Ruang</th>
						<th class="text-center">Digunakan Untuk</th>
						<th class="text-center">Status</th>
						<th class="text-center">Aksi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($ruang as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['gedung'] ?></td>
								<td><?= $list['ruang'] ?></td>
								<td class="text-center">
									<?php
										$count_ruang_prodi = 0;
										$ruang_prodis = $this->ruang->readRuangProdi($list['id_ruang']);
										foreach ($ruang_prodis as $ruang_prodi) {
											if (!empty($ruang_prodi['id_ruang_prodi'])) {
												$count_ruang_prodi++;
												?>
												<?= $ruang_prodi['jenjang'] ?> - <?= $ruang_prodi['nm_prodi'] ?><br/>
												<?php
											}
										}
										if ($count_ruang_prodi == 0) {
											?>
											<small class="label bg-red-gradient">Data kosong</small>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<?php
										echo form_open('baa/master/ruang/update_aktif');
										echo formtext('hidden', 'hand', 'center19', 'required');
										echo formtext('hidden', 'id_ruang', $list['id_ruang'], 'required');
										echo formtext('hidden', 'status', $list['status'] == '1' ? 0 : 1, 'required');
									?>
									<button type="submit" class="btn btn-xs <?= $list['status'] == '1' ? 'btn-success' : 'btn-danger' ?>" style="margin-right:3px;">
										<i class="fa <?= $list['status'] == '1' ? 'fa-check' : 'fa-close' ?>"></i> <?= $list['status'] == '1' ? 'Aktif' : 'Tidak aktif' ?>
									</button>
									<?php
										echo form_close();
									?>
								</td>
								<td class="text-center">
									<a class="btn btn-xs btn-warning" href="<?= base_url() ?>baa/master/ruang/edit/<?= $list['id_ruang'] ?>">
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
