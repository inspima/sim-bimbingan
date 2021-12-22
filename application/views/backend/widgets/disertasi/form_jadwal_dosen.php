<!-- form start -->
<?php echo form_open('dosen/disertasi/' . $this->uri->segment('3') . '/jadwal_save'); ?>
<div class="form-group">
	<label>Tanggal</label>
	<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
	<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
	<div class="input-group date">
		<div class="input-group-addon">
			<i class="fa fa-calendar"></i>
		</div>
		<?php
			if ($ujian) {
				$tanggal = toindo($ujian->tanggal);
				$id_ruang = $ujian->id_ruang;
				$ruang = $ujian->ruang . ' - ' . $ujian->gedung;
				$id_jam = $ujian->id_jam;
				$jam = $ujian->jam;
				$link_meeting = $ujian->link_meeting;
			} else {
				$tanggal = date('d/m/Y');
				$id_ruang = '';
				$ruang = '-Pilih Ruang-';
				$id_jam = '';
				$jam = '-Pilih Jam-';
				$link_meeting = '';
			}
		?>
		<input type="text" name="tanggal" value="<?php echo $tanggal ?>" class="form-control pull-right" id="datepicker" required readonly>
	</div>
</div>

<div class="form-group">
	<label>Ruang</label>
	<select name="id_ruang" class="form-control select2" style="width: 100%;" required>
		<option value="<?php echo $id_ruang ?>"><?php echo $ruang ?></option>
		<?php
			foreach ($mruang as $list) {
				?>
				<option value="<?php echo $list['id_ruang'] ?>"><?php echo $list['ruang'] . ' - ' . $list['gedung'] ?></option>
				<?php
			}
		?>
	</select>
</div>

<div class="form-group">
	<label>Link Meeting Online</label>
	<textarea class="form-control" style="resize: none;" rows="2" name="link_meeting" placeholder="Link zoom/google meet hanya untuk ujian online"><?=$link_meeting?></textarea>
</div>

<div class="form-group">
	<label>Jam</label>
	<select name="id_jam" class="form-control select2" style="width: 100%;" required>
		<option value="<?php echo $id_jam ?>"><?php echo $jam ?></option>
		<?php
			foreach ($mjam as $list) {
				?>
				<option value="<?php echo $list['id_jam'] ?>"><?php echo $list['jam'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<div class="divider10"></div>
<div class="form-group">
	<?php
		if ($ujian) {
			$jadwal_riwayats = $this->disertasi->read_jadwal_riwayat($disertasi->id_disertasi, $ujian->jenis_ujian);
			?>
			<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, '') ?>
			<?php echo formtext('hidden', 'is_ubah_jadwal', 1, '') ?>
			<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> Ubah Jadwal</button>
			<button type="button" class="btn btn-sm bg-blue-active" data-toggle="modal" data-target="#modal-riwayat-jadwal">
				<i class="glyphicon glyphicon-list-alt"></i> Riwayat Perubahan
			</button>
			<div class="modal fade" id="modal-riwayat-jadwal" style="display: none;">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Riwayat Perubahan Jadwal</h4>
						</div>
						<div class="modal-body">
							<table class="table table-hover">
								<tbody>
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Ruang - Gedung</th>
									<th>Jam</th>
									<th class="text-center">Status</th>
								</tr>
								<?php
									foreach ($jadwal_riwayats as $index => $jadwal_riwayat) {
										?>
										<tr>
											<td><?= $index + 1 ?></td>
											<td><?php echo wday_toindo($jadwal_riwayat['tanggal']) ?></td>
											<td><?= $jadwal_riwayat['ruang'] ?> - <?= $jadwal_riwayat['gedung'] ?></td>
											<td><?= $jadwal_riwayat['jam'] ?></td>
											<td class="text-center">
												<?php
													if ($jadwal_riwayat['status'] == '1') {
														?>
														<span class="label label-success">Aktif</span>
														<?php
													} else {
														?>
														<span class="label label-warning">Tidak Aktif</span>
														<?php
													}
												?>
											</td>
										</tr>
										<?php
									}
								?>
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<?php
		} else {
			?>
			<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i> Simpan Jadwal</button>
			<?php
		}
	?>

</div>
<?php echo form_close() ?>
