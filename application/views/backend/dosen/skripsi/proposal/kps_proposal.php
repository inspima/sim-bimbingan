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
					<a href="?status=baru" class="btn <?= $this->input->get('status') == 'baru' || $this->input->get('status') == '' ? 'btn-default' : 'btn-info' ?> ">Baru</a>
					<a href="?status=ujian" class="btn <?= $this->input->get('status') == 'ujian' ? 'btn-default' : 'btn-primary' ?> ">Proses Ujian</a>
					<a href="?status=selesai" class="btn <?= $this->input->get('status') == 'selesai' ? 'btn-default' : 'btn-danger' ?>">Selesai</a>
				</div>
				<hr class="divider-line-thin"/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Judul</th>
						<th class="text-center">Status & Ujian</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($proposal as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['nama'] ?><br><strong><?= $list['nim'] ?></strong></td>
								<td>
									<?php
										$judul = $this->proposal->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?>
									<br/>
									<a class="btn btn-xs btn-danger" href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
									<hr class="divider-line-thin"/>
									<b class="text-primary">Departemen</b><br/>
									<?php echo $list['departemen'] ?>
									<hr class="divider-line-thin"/>
									<b class="text-primary">Gelombang</b><br/>
									<?= $list['gelombang'] . ' (' . $list['semester'] . ')' ?>
								</td>
								<td>
									<p class="text-center">
										<?php $this->view('backend/widgets/skripsi/column_status', [
												'skripsi' => $list,
												'jenis' => TAHAPAN_SKRIPSI_PROPOSAL
										]);
										?>
										<br/>
									</p>
									<table class="table">
										<tr>
											<td>
												<?php
													$ujian = $this->proposal->read_ujian($list['id_skripsi']);
													if ($ujian) {
														?>
														<b class="text-primary">Jadwal</b><br/>
														<?php
														echo '<strong>Tanggal</strong> :<br>' . toindo($ujian->tanggal) . '<br>';
														echo '<strong>Ruang</strong>  :<br>' . $ujian->ruang . ' ' . $ujian->gedung . '<br>';
														echo '<strong>Jam</strong>     :<br>' . $ujian->jam;
													} else {
														echo '';
													}
												?>
											</td>
											<td>
												<?php
													$penguji = $this->proposal->read_penguji($list['id_skripsi']);
													$num = 1;
													if(!empty($penguji)){
														?>
														<b class="text-primary">Penguji</b><br/>
														<?php
													}
													foreach ($penguji as $show) {
														if ($show['status'] == '1') {
															?>
															<p style="color:red">
																<?php
																	echo $num . '. ' . $show['nama'] . '<br>';
																?>
															</p>
															<?php
														} else {
															echo $num . '. ' . $show['nama'] . '<br>';
														}
														$num++;
													}
												?>
											</td>
										</tr>
									</table>
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
