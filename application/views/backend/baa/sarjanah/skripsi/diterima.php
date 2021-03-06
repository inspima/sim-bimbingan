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
				<?php $this->view('backend/widgets/skripsi/tab_link_baa_skripsi'); ?>
				<hr/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Judul</th>
						<th>Departemen</th>
						<th>Berkas Skripsi & Turnitin</th>
						<th>Toefl</th>
						<th>Bimbingan</th>
						<th>Tanggal Pengajuan</th>
						<th>Berkas Lengkap ?</th>
						<th>Nilai</th>
						<th>Status</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($skripsi as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?></td>
								<td>
									<?php
										$judul = $this->skripsi_diterima->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?>
								</td>
								<td><?php echo $list['departemen'] ?></td>
								<td>
									<a href="<?php echo base_url() ?>assets/upload/turnitin/<?php echo $list['turnitin'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
								</td>
								<td><?php echo $list['toefl'] ?></td>
								<td>
									<?php
										$pembimbing = $this->skripsi_diterima->read_pembimbing($list['id_skripsi']);
										echo $pembimbing->nama . '<br>';
									?>
									<a class="btn btn-xs btn-primary pull-left" href="<?= base_url() ?>dashboardb/skripsi/skripsi_diterima/bimbingan/<?= $list['id_skripsi'] ?>">
										<i class="fa fa-calendar"></i> Bimbingan</a>
								</td>
								<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
								<td>
									<?php
										$bs = $list['berkas_skripsi'];
										if ($bs == '0') {
											$bst = 'belum lengkap';
											$btn = 'btn-danger';
											$kbs = '1';
										} else if ($bs == '1') {
											$bst = 'lengkap';
											$btn = 'btn-success';
											$kbs = '0';
										}
									?>
									<?php echo form_open('dashboardb/skripsi/skripsi_diterima/update_berkas') ?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<?php echo formtext('hidden', 'berkas_skripsi', $kbs, 'required') ?>
									<button type="submit" class="btn btn-xs <?php echo $btn ?> pull-left"> <?php echo $bst ?></button>
									<?php echo form_close() ?>

								</td>
								<td><?php echo $list['nilai'] ?></td>
								<td>
									<?php
										if ($list['status_skripsi'] == STATUS_SKRIPSI_UJIAN_SETUJUI_BAA) {
											echo 'approve BAA';
										} else if ($list['status_skripsi'] == STATUS_SKRIPSI_UJIAN_SETUJUI_PEMBIMMBING) {
											echo 'approve Pembimbing';
										}  else if ($list['status_skripsi'] == STATUS_SKRIPSI_UJIAN_DIJADWALKAN) {
											echo 'dijadwalakan Kepala Bagian';
										}else if ($list['status_skripsi'] == STATUS_SKRIPSI_UJIAN_SETUJUI_PENGUJI) {
											echo 'disetujui semua penguji';
										}else if ($list['status_skripsi'] == STATUS_SKRIPSI_UJIAN_SETUJUI_KPS) {
											echo 'disetujui KPS';
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
