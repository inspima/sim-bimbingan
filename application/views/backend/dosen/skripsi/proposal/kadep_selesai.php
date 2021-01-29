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
				<?php $this->view('backend/widgets/skripsi/tab_link_kadep_proposal'); ?>
				<hr/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>NIM</th>
						<th>Nama</th>
						<th>Judul</th>
						<th>Berkas Proposal</th>
						<th>Departemen</th>
						<th>Pembimbing</th>
						<th>Tgl Pengajuan</th>
						<th>Semester</th>
						<th>Status Ujian</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($proposal as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['nim'] ?></td>
								<td><?= $list['nama'] ?></td>
								<td><?= $list['judul']; ?></td>
								<td>
									<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
								</td>
								<td><?php echo $list['departemen'] ?></td>
								<td>
									<?php
										$pembimbing = $this->skripsi->read_pembimbing_row($list['id_skripsi']);
										if ($pembimbing) {
											echo $pembimbing->nama;
										} else {
											echo 'Belum ada pembimbing';
										}
									?>
								</td>
								<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
								<td><?= $list['semester'] ?></td>
								<td>
									<?php
										if ($list['status_ujian_proposal'] == '0') {
											echo 'Belum ujian';
										} else if ($list['status_ujian_proposal'] == '1') {
											echo 'Layak dan dapat dilanjutkan untuk penulisan skripsi';
										} else if ($list['status_ujian_proposal'] == '2') {
											echo 'Layak dengan catatan perbaikan dan dapat dilanjutkan untuk penulisan skripsi';
										} else if ($list['status_ujian_proposal'] == '3') {
											echo 'Tidak layak dan harus diuji kembali';
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
