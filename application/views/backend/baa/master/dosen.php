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
						<th>Pembimbing</th>
						<th>Penguji</th>
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
									<?= $list['nama'] ?> <?= $list['external'] == '1' ? '<b class="label bg-red-gradient">EKSTERNAL</b>' : '' ?><br/>
									<?php
										if ($list['external'] == '1') {
											if (!empty($list['external_pt'])) {
												?>
												Asal PT : <b><?= $list['external_pt'] ?></b><br/>
												<?php
											}
										}
									?>
									NIP : <b><?= $list['nip'] ?></b><br/>
									Email : <b><?= $list['email'] ?></b><br/>
									<hr class="divider-line-semi-bold"/>
									Jabatan : <b><?= !empty($list['jabatan']) ? $list['jabatan'] : '-'; ?></b><br/>
									Pangkat : <b><?= !empty($list['pangkat']) ? $list['pangkat'] : '-'; ?></b><br/>
									Golongan : <b><?= !empty($list['golongan']) ? $list['golongan'] : '-'; ?></b><br/>
								</td>
								<td><?= $list['departemen'] ?></td>
								<td class="text-center">
									<?php
										foreach ($jenjangs as $jenjang) {
											$aktif = $this->dosen->checkAktifPembimbing($jenjang['id_jenjang'], $list['nip']);
											?>
											<?= $jenjang['nm_jenjang'] ?>
											<?php
											if ($aktif) {
												echo form_open('baa/master/dosen/update_aktif');
												echo formtext('hidden', 'hand', 'center19', 'required');
												echo formtext('hidden', 'mode', 'pembimbing', 'required');
												echo formtext('hidden', 'nip', $list['nip'], 'required');
												echo formtext('hidden', 'id_jenjang', $jenjang['id_jenjang'], 'required');
												echo formtext('hidden', 'status', '0', 'required');
												?>
												<button type="submit" class="btn btn-xs btn-success" style="margin:2px;">
													<i class="fa fa-check"></i> Aktif
												</button>
												<?php
												echo form_close();
											} else {
												echo form_open('baa/master/dosen/update_aktif');
												echo formtext('hidden', 'hand', 'center19', 'required');
												echo formtext('hidden', 'mode', 'pembimbing', 'required');
												echo formtext('hidden', 'nip', $list['nip'], 'required');
												echo formtext('hidden', 'id_jenjang', $jenjang['id_jenjang'], 'required');
												echo formtext('hidden', 'status', '1', 'required');
												?>
												<button type="submit" class="btn btn-xs btn-danger" style="margin:2px;">
													<i class="fa fa-remove"></i> Tidak
												</button>
												<?php
												echo form_close();
											}
											?>

											<hr class="divider-line-semi-bold"/>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<?php
										foreach ($jenjangs as $jenjang) {
											$aktif = $this->dosen->checkAktifPenguji($jenjang['id_jenjang'], $list['nip']);
											?>
											<?= $jenjang['nm_jenjang'] ?>
											<?php
											if ($aktif) {
												echo form_open('baa/master/dosen/update_aktif');
												echo formtext('hidden', 'hand', 'center19', 'required');
												echo formtext('hidden', 'mode', 'penguji', 'required');
												echo formtext('hidden', 'nip', $list['nip'], 'required');
												echo formtext('hidden', 'id_jenjang', $jenjang['id_jenjang'], 'required');
												echo formtext('hidden', 'status', '0', 'required');
												?>
												<button type="submit" class="btn btn-xs btn-success" style="margin:2px;">
													<i class="fa fa-check"></i> Aktif
												</button>
												<?php
												echo form_close();
											} else {
												echo form_open('baa/master/dosen/update_aktif');
												echo formtext('hidden', 'hand', 'center19', 'required');
												echo formtext('hidden', 'mode', 'penguji', 'required');
												echo formtext('hidden', 'nip', $list['nip'], 'required');
												echo formtext('hidden', 'id_jenjang', $jenjang['id_jenjang'], 'required');
												echo formtext('hidden', 'status', '1', 'required');
												?>
												<button type="submit" class="btn btn-xs btn-danger" style="margin:2px;">
													<i class="fa fa-remove"></i> Tidak
												</button>
												<?php
												echo form_close();
											}
											?>

											<hr class="divider-line-semi-bold"/>
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
