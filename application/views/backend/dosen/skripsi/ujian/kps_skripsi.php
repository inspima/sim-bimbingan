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

				<div class="btn-group">
					<a href="?status=persetujuan" class="btn <?= $this->input->get('status') == 'persetujuan' || $this->input->get('status') == '' ? 'btn-default' : 'btn-success' ?>">Persetujuan</a>
					<a href="?status=ujian" class="btn <?= $this->input->get('status') == 'ujian' ? 'btn-default' : 'btn-primary' ?>">Proses Ujian</a>
					<a href="?status=selesai" class="btn <?= $this->input->get('status') == 'selesai' ? 'btn-default' : 'btn-danger' ?>">Selesai</a>
				</div>
				<hr class="divider-line-thin"/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Judul</th>
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
								<td>
									<?php
										$judul = $this->skripsi->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?>
									<br/>
									<a class="btn btn-xs btn-danger" href="<?php echo base_url() ?>assets/upload/skripsi/<?php echo $list['berkas_skripsi'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
									<hr class="divider-line-thin"/>
									<b class="text-primary">Departemen</b><br/>
									<?php echo $list['departemen'] ?>
									<hr class="divider-line-thin"/>
									<b class="text-primary">Gelombang</b><br/>
									<?= $list['gelombang'] . ' (' . $list['semester'] . ')' ?>
									<hr class="divider-line-thin"/>
									<b class="text-primary">Pembimbing</b><br/>
									<?php
										$pembimbing = $this->skripsi->read_pembimbing($list['id_skripsi']);
										echo $pembimbing->nama;
									?>
								</td>
								<td>
									<?php
										echo '<strong>Tanggal : </strong>' . toindo($list['tanggal']) . '<br>';
										echo '<strong>Jam     : </strong>' . $list['jam'] . '<br>';
										echo '<strong>Ruang   : </strong>' . $list['ruang'] . ' - ' . $list['gedung'] . '<br>';
									?>
								</td>
								<td>
									<ul style="padding-left: 15px">
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

											if ($show['status'] == '3') {
												$apv = '<br/><b class="text-red">Ditolak</b>';
												$tdc = 'style="text-decoration:line-through"';
											} else  {
												$apv = '';
												$tdc='';
											}

											echo '<li><span '.$tdc.'>' . $show['nama'] . '(' . $ka . $up . ')</span>'.$apv.'</li> ';
										}
									?>
									</ul>
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
