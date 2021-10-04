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

			<!-- /.box-body -->
			<div class="box-body">

				<?php $this->view('backend/widgets/skripsi/tab_link_baa_proposal'); ?>
				<hr/>
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Info Proposal</th>
							<th>Tanggal Pengajuan</th>
							<th>Jadwal</th>
							<th>Dosen Penguji</th>
							<th>Cetak</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($proposal as $list) {
								?>
								<tr>
									<td><?= $no ?></td>
									<td><?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?></td>
									<td>
										<?php
											$judul = $this->proposal_diterima->read_judul($list['id_skripsi']);
											echo $judul->judul;
										?>
										<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
										<hr class="divider-line-semi-bold">
										<b>Departemen</b> : <?php echo $list['departemen'] ?>
										<hr class="divider-line-thin">
										<b>Semester </b> : <?php echo $list['gelombang'] . ' (' . $list['semester'] . ')' ?>
									</td>
									<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
									<td>
										<?php
											$ujian = $this->proposal_diterima->read_ujian($list['id_skripsi']);
											if ($ujian) {
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
											$penguji = $this->proposal_diterima->read_penguji($list['id_skripsi']);
											$num = 1;
											foreach ($penguji as $show) {
												if ($show['status'] == '1') {
													?>
													<p style="color:red">
														<?php
															echo $num . ' ' . $show['nama'] . '<br>';
														?>
													</p>
													<?php
												} else {
													echo $num . ' ' . $show['nama'] . '<br>';
												}
												$num++;
											}
										?>
									</td>
									<td>
										<?php
											if ($ujian) {
												$ketua = $this->proposal_diterima->read_ketua_penguji($ujian->id_ujian);
												if (!empty($ketua)) {
													if ($list['status_proposal'] >= STATUS_SKRIPSI_PROPOSAL_SETUJUI_PENGUJI) {
														$data_dokumen_surat_tugas = [
																'tipe' => DOKUMEN_SURAT_TUGAS_PROPOSAL_PENGUJI_STR,
																'jenis' => DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR,
																'identitas' => $list['nim'],
														];
														$dokumen_surat_tugas = $this->dokumen->detail_by_data($data_dokumen_surat_tugas);
														?>
														<?php
														$attributes = array('target' => '_blank', 'autocomplete' => 'off');
														echo form_open('baa/sarjanah/proposal/cetak_surat_tugas', $attributes)
														?>
														<h4>Surat Tugas</h4>
														<input type="text" name="no_sk" style="margin-bottom: 10px" class="form-control" placeholder="NO SK" value="<?= !empty($dokumen_surat_tugas) ? $dokumen_surat_tugas->no_doc : '' ?>" required/>
														<input type="text" name="tgl_sk" style="margin-bottom: 10px" class="datepicker form-control" placeholder="TGL SK" value="<?= !empty($dokumen_surat_tugas) ? date('d-m-Y', strtotime($dokumen_surat_tugas->date_doc)) : '' ?>" required/>
														<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
														<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
														<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
														<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Surat Tugas</button>
														<?php echo form_close(); ?>
														<hr class="divider-line-semi-bold"/>
														<h4>Surat Undangan</h4>
														<?php
														$data_dokumen_undangan = [
																'tipe' => DOKUMEN_SURAT_UNDANGAN_PROPOSAL_STR,
																'jenis' => DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR,
																'identitas' => $list['nim']
														];
														$dokumen_undangan = $this->dokumen->detail_by_data($data_dokumen_undangan);
														$attributes = array('target' => '_blank');
														echo form_open('baa/sarjanah/proposal/cetak_undangan', $attributes)
														?>
														<input type="text" name="no_sk" style="margin-bottom: 10px" class="form-control" placeholder="NO SK" value="<?= !empty($dokumen_undangan) ? $dokumen_undangan->no_doc : '' ?>" required/>
														<input type="text" name="tgl_sk" style="margin-bottom: 10px" class="datepicker form-control" placeholder="TGL SURAT" value="<?= !empty($dokumen_undangan) ? date('d-m-Y', strtotime($dokumen_undangan->date_doc)) : '' ?>" required/>
														<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
														<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
														<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
														<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Undangan</button>
														<?php echo form_close(); ?>
														<hr class="divider-line-semi-bold"/>
														<?php
														$attributes = array('target' => '_blank');
														echo form_open('baa/sarjanah/proposal/cetak_berita', $attributes)
														?>
														<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
														<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
														<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Berita Acara</button>
														<?php echo form_close(); ?>
														<div class="divider5"></div>
														<!--													--><?php
														//													$attributes = array('target' => '_blank');
														//													echo form_open('dashboardb/proposal/proposal_diterima/cetak_absensi', $attributes)
														//													?>
														<!--													--><?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
														<!--													--><?php //echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
														<!--													<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Berita Acara Konsumsi-->
														<!--													</button>-->
														<!--													--><?php //echo form_close(); ?>
														<?php
													} else {
														echo '<b class="text-danger">Penguji belum menyetujui</b>';
													}

												} else {
													echo '<b class="text-danger">Ketua penguji belum dipilih</b>';
												}
											} else {
												echo '<b class="text-danger">Ujian belum dimasukkan</b>';
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
			</div>
		</div>
	</div>
	<!-- /.box -->
</div>
<!-- /.col -->
</div>
