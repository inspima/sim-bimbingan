<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $title ?></h3>
				<div class="pull-right">
					<a class="btn btn-xs btn-primary" href="<?= base_url() ?>dashboarda/master/user/add_pegawai">
						<i class="fa fa-plus"></i> Tambah Pegawai
					</a>
					<a class="btn btn-xs btn-primary" href="<?= base_url() ?>dashboarda/master/user/add_dosen">
						<i class="fa fa-plus"></i> Tambah Dosen
					</a>
				</div>
			</div>
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
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Info Akun</th>
						<th style="width: 120px">Akses & Role</th>
						<th>Struktural</th>
						<th>Prodi</th>
						<th>Status</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($user as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td>
									Username : <b> <?= $list['username'] ?></b>
									<hr class="divider-line-semi-bold"/>
									Nama : <b><?= $list['nama'] ?></b>
									<hr class="divider-line-semi-bold"/>
									Email : <b><?= $list['email'] ?></b>
									<hr class="divider-line-semi-bold"/>
									No HP : <b><?= $list['no_hp'] ?></b>
								</td>
								<td>
									Akses <br/>
									<b>
										<?php
											if ($list['sebagai'] == '1') { // dosen
												echo 'Dosen';
											} else if ($list['sebagai'] == '2') { // tendik
												echo 'Tendik';
											} else if ($list['sebagai'] == '3') { // mahasiswa
												echo 'Mahasiswa';
											}
										?>
									</b>
									<?php
										if ($list['sebagai'] == '2') {
											?>
											<br/>
											Role <br/>
											<b>
												<?php
													if ($list['role'] == '0') { // selain tendik
														echo '-';
													} else if ($list['role'] == '1') { // Admin
														echo 'Administrator';
													} else if ($list['role'] == '2') { // BAA
														echo 'BAA';
													} else if ($list['role'] == '3') { // Admin Prodi
														echo 'Admin Prodi';
													} else if ($list['role'] == '4') { // up4i
														echo 'UP4I';
													}
												?>
											</b>
											<?php
										}
									?>
									<?php
										if ($list['sebagai'] == '3') {
											if ($list['verifikasi'] == '1') {
												?>
												<br/>
												<label class="text-success text-sm">Sudah Verifikasi</label>
												<?php
												echo form_open('dashboarda/master/user/reset_verifikasi');
												echo formtext('hidden', 'hand', 'center19', 'required');
												echo formtext('hidden', 'username', $list['username'], 'required');
												echo formtext('hidden', 'id_user', $list['id_user'], 'required');
												?>
												<button type="submit" class="btn btn-xs btn-warning" style="margin-right:3px;">
													<i class="fa fa-refresh"></i> Reset Verifikasi
												</button>
												<?php
												echo form_close();
												?>
												<?php
											} else {
												?>
												<br/>
												<label class="text-danger text-sm">Belum Verifikasi</label>
												<?php
											}
										}
									?>
								</td>
								<td><?= $list['struktural'] ?></td>
								<td><?= $list['prodi'] ?></td>
								<td>
									<?php
										if ($list['status'] == '0') {
											echo 'Tidak Aktif';
										} else if ($list['status'] == '1') {
											echo 'Aktif';
										}
									?>
								</td>
								<td class="text-center">
									<?php
										echo form_open('dashboarda/master/user/direct_login');
										echo formtext('hidden', 'hand', 'center19', 'required');
										echo formtext('hidden', 'username', $list['username'], 'required');
									?>
									<button type="submit" class="btn btn-xs btn-primary" style="margin-right:3px;">
										<i class="fa fa-play"></i> Login
									</button>
									<?php
										echo form_close();
									?>
									<div class="divider5"><span></span></div>
									<a class="btn btn-xs btn-warning" href="<?= base_url() ?>dashboarda/master/user/detail/<?= $list['id_user'] ?>">
										<i class="fa fa-lock"></i> Password
									</a>
									<div class="divider5"></div>
									<?php
										if ($list['sebagai'] == '2') { // tendik
											?>
											<a class="btn btn-xs btn-info" href="<?= base_url() ?>dashboarda/master/user/edit_pegawai/<?= $list['id_user'] ?>/<?= $list['id_pegawai'] ?>">
												<i class="fa fa-edit"></i> Edit
											</a>
											<?php
										}
									?>
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
