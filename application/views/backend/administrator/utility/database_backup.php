<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $title ?></h3>
				<div class="pull-right">
					<?php echo form_open('dashboarda/utility/database/backup/create'); ?>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<button type="submit" class="btn btn-xs btn-primary" href="<?= base_url() ?>dashboarda/master/user/add_pegawai">
						<i class="fa fa-plus"></i> Buat Baru
					</button>

					<?= form_close() ?>
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
						<th>Nama File</th>
						<th style="width: 120px">Waktu Backup</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($backups as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td>
									 <?= $list['filename'] ?>
								</td>
								<td>
									<?= waktu_format_indonesia(date('Y-m-d H:i:s', strtotime($list['time']))) ?>
								</td>
								<td class="text-center">

									<div class="divider5"><span></span></div>
									<a class="btn btn-xs btn-success" href="<?= base_url() ?>assets/backups/<?= $list['filename'] ?>">
										<i class="fa fa-download"></i> Download
									</a>
									<div class="divider5"></div>
									<?php
										echo form_open('dashboarda/utility/database/backup/delete');
										echo formtext('hidden', 'hand', 'center19', 'required');
										echo formtext('hidden', 'id', $list['id_db_backup'], 'required');
									?>
									<button type="submit" class="btn btn-xs btn-danger" style="margin-right:3px;">
										<i class="fa fa-remove"></i> Delete
									</button>
									<?php
										echo form_close();
									?>
								</td>
							</tr>
							<?php
							$no++;
						}
					?>
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
