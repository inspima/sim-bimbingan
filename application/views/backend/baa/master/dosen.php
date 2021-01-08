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
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Biodata & Kepangkatan</th>
						<th>Departemen/Bagian</th>
						<th>Email</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($dosen as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td>
									<?= $list['nama'] ?><br/>
									<b><?= $list['nip'] ?></b><br/>
									<hr class="divider-line-semi-bold"/>
									Jabatan : <b><?= !empty($list['jabatan'])?$list['jabatan']:'-'; ?></b><br/>
									Pangkat : <b><?= !empty($list['pangkat'])?$list['pangkat']:'-'; ?></b><br/>
									Golongan : <b><?= !empty($list['golongan'])?$list['golongan']:'-'; ?></b><br/>
								</td>
								<td><?= $list['departemen'] ?></td>
								<td><?= $list['email'] ?></td>
								<td class="text-center">
									<?php
										if ($list['status_berjalan'] == '0') {
											?>
											<?php
											echo form_open('dashboardb/master/dosen/update_berjalan');
											echo formtext('hidden', 'hand', 'center19', 'required');
											echo formtext('hidden', 'id_pegawai', $list['id_pegawai'], 'required');
											echo formtext('hidden', 'status_berjalan', '1', 'required');
											?>
											<button type="submit" class="btn btn-xs btn-danger pull-left" style="margin-right:3px;">
												<i class="fa fa-close"></i> Tidak Aktif
											</button>
											<?php
											echo form_close();
											?>
											<?php
										} else if ($list['status_berjalan'] == '1') {
											?>
											<?php
											echo form_open('dashboardb/master/dosen/update_berjalan');
											echo formtext('hidden', 'hand', 'center19', 'required');
											echo formtext('hidden', 'id_pegawai', $list['id_pegawai'], 'required');
											echo formtext('hidden', 'status_berjalan', '0', 'required');
											?>
											<button type="submit" class="btn btn-xs btn-success pull-left" style="margin-right:3px;">
												<i class="fa fa-check"></i> Aktif
											</button>
											<?php
											echo form_close();
											?>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<a class="btn btn-xs btn-info" href="<?= base_url() ?>baa/master/dosen/edit/<?= $list['id_pegawai'] ?>"><i class="fa fa-pencil"></i> Edit</a>
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
