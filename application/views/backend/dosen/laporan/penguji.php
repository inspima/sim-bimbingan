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
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<div class="btn-group">
					<a class="<?= ($this->uri->segment(4) == 'sarjana') ? 'btn btn-default' : 'btn btn-danger'; ?>" href="<?php echo base_url() ?>dosen/laporan/penguji/sarjana">Sarjana</a>
					<a class="<?= ($this->uri->segment(4) == 'magister') ? 'btn btn-default' : 'btn btn-info'; ?>" href="<?php echo base_url() ?>dosen/laporan/penguji/magister">Magister</a>
					<a class="<?= ($this->uri->segment(4) == 'doktor') ? 'btn btn-default' : 'btn btn-primary'; ?>" href="<?php echo base_url() ?>dosen/laporan/penguji/doktor">Doktor</a>
				</div>
				<hr class="divider-line-semi-bold"/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Judul</th>
						<th>Status Tim</th>
						<th>Tanggal</th>
						<th>Jam</th>
						<th>Ruang</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($penguji as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td style="width: 15%"><?= $list['nama'] . '<br>(' . $list['nim'] . ')' ?></td>
								<td style="width: 25%">
									<?php
										if ($list['tanggal'] > date('Y-m-d')) {
											?>
											<b class="label bg-green">AKAN DATANG</b>
											<br/>
											<?php
										} else {
											?>
											<b class="label bg-primary">SELESAI</b>
											<br/>
											<?php
										}
									?>
									<?php
										echo $list['judul'];
									?>
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
								<td><?php echo tanggal_hari_format_indonesia($list['tanggal']) ?></td>
								<td><?= $list['jam'] ?></td>
								<td><?= $list['ruang'] . ' ' . $list['gedung'] ?></td>
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
