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
					<a class="<?= ($this->uri->segment(4) == 'penguji_pengajuan') ? 'btn btn-default' : 'btn btn-info'; ?>" href="<?php echo base_url() ?>dosen/sarjana/proposal/penguji_pengajuan">Pengajuan</a>
					<a class="<?= ($this->uri->segment(4) == 'penguji_proses_ujian') ? 'btn btn-default' : 'btn bg-navy'; ?>" href="<?php echo base_url() ?>dosen/sarjana/proposal/penguji_proses_ujian">Proses Pengujian</a>
					<a class="<?= ($this->uri->segment(4) == 'penguji_riwayat') ? 'btn btn-default' : 'btn btn-primary'; ?>" href="<?php echo base_url() ?>dosen/sarjana/proposal/penguji_riwayat">Selesai Ujian</a>
				</div>
				<hr class="divider-line-thin"/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Judul</th>
						<th>Status Tim</th>
						<th>Jadwal</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($penguji as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['nama'] . '<br>(' . $list['nim'] . ')' ?></td>
								<td>
									<?php
										echo $list['judul'];
									?>
									<br/>
									<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank" class="btn btn-xs btn-danger"><i class="fa fa-file-pdf-o"></i> Berkas</a>
								</td>
								<td>
									<?php
										if ($list['status_tim'] == '1') {
											echo 'Ketua';
										} else if ($list['status_tim'] == '2') {
											echo 'Anggota';
										}
									?>
								</td>
								<td>
									<span class="text-primary text-bold">
										<?php echo wday_toindo($list['tanggal']) ?>
									</span><br/>
									<span  class="text-navy text-bold">
										<?= $list['jam'] ?>
									</span><br/>
									<?= $list['ruang'] . ' ' . $list['gedung'] ?>
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
