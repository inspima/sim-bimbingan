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
				<div class="col-md-12">
					<div class="form-group">
						<?php echo form_open('dashboardd/skripsi/kps_skripsi/filter_tahun'); ?>
						<label>Tahun</label><br/>
						<select name="tahun" class="form-control" style="width: 200px;">
							<?php
								$tahuns = [date('Y'), date('Y') - 1, date('Y') - 2, date('Y') - 3, date('Y') - 4];
								foreach ($tahuns as $tahun) {
									?>
									<option <?php if ($post_year == $tahun) {
										echo "selected";
									} ?> value="<?= $tahun ?>"><?= $tahun ?></option>
									<?php
								}
							?>
						</select>
						<div class="divider10"></div>
						<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Tampilkan</button>
						<?php echo form_close() ?>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Judul</th>
						<th>Pembimbing</th>
						<th>Departemen</th>
						<th>Gelombang / Semester</th>
						<th>Jadwal</th>
						<th>Penguji</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($skripsi as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['nama'] . '<br>' . $list['nim'] ?></td>
								<td><?php
										$judul = $this->skripsi->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?></td>
								<td><?php
										$pembimbing = $this->skripsi->read_pembimbing($list['id_skripsi']);
										echo $pembimbing->nama;
									?></td>
								<td><?php echo $list['departemen'] ?></td>
								<td><?= $list['gelombang'] . ' / ' . $list['semester'] ?></td>
								<td>
									<?php
										echo '<strong>Tanggal : </strong>' . toindo($list['tanggal']) . '<br>';
										echo '<strong>Jam     : </strong>' . $list['jam'] . '<br>';
										echo '<strong>Ruang   : </strong>' . $list['ruang'] . ' - ' . $list['gedung'] . '<br>';
									?>
								</td>
								<td>
									<?php
										$penguji = $this->skripsi->read_penguji($list['id_ujian']);
										foreach ($penguji as $show) {
											if ($show['status_tim'] == '1') {
												$ka = 'ketua';
											} else if ($show['status_tim'] == '2') {
												$ka = 'anggota';
											}

											if ($show['usulan_dosbing'] == '0') {
												$up = '';
											} else if ($show['usulan_dosbing'] == '1') {
												$up = '- usulan pembimbing';
											} else if ($show['usulan_dosbing'] == '2') {
												$up = '- pembimbing';
											}

											echo '- ' . $show['nama'] . '(' . $ka . $up . ')<br>';
										}
									?>
								</td>
								<td class="text-center">
									<?php
										if ($list['status_skripsi'] == STATUS_SKRIPSI_UJIAN_SETUJUI_PENGUJI) {
											?>
											<?php echo form_open('dashboardd/skripsi/kps_skripsi/approve') ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
											<?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
											<?php echo formtext('hidden', 'status_skripsi', '4', 'required') ?>
											<button type="submit" class="btn btn-xs btn-success"> Setujui</button>
											<?php echo form_close() ?>
											<?php
										} else if ($list['status_skripsi'] > STATUS_SKRIPSI_UJIAN_SETUJUI_KPS && $list['status_skripsi'] < STATUS_SKRIPSI_UJIAN_SELESAI) {
											?>
											<b><?= 'Proses Ujian' ?></b>
											<?php echo form_open('dashboardd/skripsi/kps_skripsi/unapprove', ['id' => 'form-kps-unapprove-'.$list['id_skripsi']]) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
											<?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
											<?php echo formtext('hidden', 'status_skripsi', '4', 'required') ?>
											<button type="button" onclick="confirm_unapprove(<?=$list['id_skripsi']?>)" class="btn btn-xs btn-warning"> Batalkan</button>
											<?php echo form_close() ?>
											<?php
										} else if ($list['status_skripsi'] >= STATUS_SKRIPSI_UJIAN_SELESAI) {
											?>
											<b><?= 'Selesai Ujian' ?></b>
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
<script>
	function confirm_unapprove(id) {
		var r = confirm("Data jadwal dan penguji akan di hapus oleh sistem, apakah anda ingin membatalkan?");
		if (r == true) {
			document.getElementById("form-kps-unapprove-"+id).submit();
		} else {
			return false;
		}

	}
</script>
