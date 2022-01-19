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
					<a class="btn btn-xs btn-primary" href="<?= base_url() ?>baa/master/jam/add">
						<i class="fa fa-plus"></i> Tambah</a>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Jam</th>
						<th class="text-center">Digunakan Untuk</th>
						<th class="text-center">Status</th>
						<th class="text-center">Aksi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($jam as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['jam'] ?></td>
								<td class="text-center">
									<?php
										$count_jam_prodi = 0;
										$jam_prodis = $this->jam->readJamProdi($list['id_jam']);
										foreach ($jam_prodis as $jam_prodi) {
											if (!empty($jam_prodi['id_jam_prodi'])) {
												$count_jam_prodi++;
												?>
												<?= $jam_prodi['jenjang'] ?> - <?= $jam_prodi['nm_prodi'] ?><br/>
												<?php
											}
										}
										if ($count_jam_prodi == 0) {
											?>
											<small class="label bg-red-gradient">Data kosong</small>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<?php
										if ($list['status'] == '0') {
											?>
											<?php
											echo form_open('baa/master/jam/update_aktif');
											echo formtext('hidden', 'hand', 'center19', 'required');
											echo formtext('hidden', 'id_jam', $list['id_jam'], 'required');
											echo formtext('hidden', 'status', '1', 'required');
											?>
											<button type="submit" class="btn btn-xs btn-danger" style="margin-right:3px;"><i class="fa fa-close"></i> Tidak Aktif</button>
											<?php
											echo form_close();
											?>
											<?php
										} else if ($list['status'] == '1') {
											?>
											<?php
											echo form_open('baa/master/jam/update_aktif');
											echo formtext('hidden', 'hand', 'center19', 'required');
											echo formtext('hidden', 'id_jam', $list['id_jam'], 'required');
											echo formtext('hidden', 'status', '0', 'required');
											?>
											<button type="submit" class="btn btn-xs btn-success" style="margin-right:3px;"><i class="fa fa-check"></i> Aktif</a></button>
											<?php
											echo form_close();
										}
									?>
								</td>
								<td class="text-center">
									<a class="btn btn-xs btn-warning" href="<?= base_url() ?>baa/master/jam/edit/<?= $list['id_jam'] ?>">
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
