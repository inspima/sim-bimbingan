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
<?php $this->view('backend/widgets/disertasi/tab_link_admin_prodi'); ?>
<div class="divider10"></div>
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_KUALIFIKASI]); ?>
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
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Disertasi</th>
						<th>Penasehat Akademik</th>
						<th class="text-center">Penguji</th>
						<th class="text-center">Jadwal</th>
						<th class="text-center">Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($disertasi as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td>
									<?php $this->view('backend/widgets/disertasi/column_info_disertasi_berkas', [
											'disertasi' => $list,
											'jenis' => TAHAPAN_DISERTASI_KUALIFIKASI
									]); ?>
								</td>
								<td>
									<?php $this->view('backend/widgets/disertasi/column_penasehat', ['disertasi' => $list]); ?>
									<?php
										if ($list['status_kualifikasi'] >= STATUS_DISERTASI_KUALIFIKASI_PENGAJUAN) {
											?>
											<div class="divider5"></div>
											<a class="btn btn-primary btn-xs" href="<?= base_url() ?>prodi/doktoral/disertasi/kualifikasi/setting/<?= $list['id_disertasi'] ?>"><i class="fa fa-pencil-square"></i> Ubah</a>
											<?php
										}
										if (!empty($list['nip_penasehat'])) {
											?>
											<hr class="divider-line-semi-bold"/>
											<!-- SK Penasehat -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php
											$data_dokumen_sk_penasehat = [
													'tipe' => DOKUMEN_SURAT_KEPUTUSAN,
													'jenis' => DOKUMEN_JENIS_DISERTASI_SK_PENASEHAT_STR,
													'identitas' => $list['nim'],
											];
											$data_dokumen_sk_penasehat = $this->dokumen->detail_by_data($data_dokumen_sk_penasehat);
											?>
											<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_sk_penasehat', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<input type="text" name="no_sk" style="margin-bottom: 10px" class="form-control" placeholder="NO SK" value="<?= !empty($data_dokumen_sk_penasehat) ? $data_dokumen_sk_penasehat->no_doc : '' ?>" required/>
											<input type="text" name="tgl_sk" style="margin-bottom: 10px" class="datepicker form-control" placeholder="TGL SK" value="<?= !empty($data_dokumen_sk_penasehat) ? date('d-m-Y', strtotime($data_dokumen_sk_penasehat->date_doc)) : '' ?>" required/>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Penasehat</button>
											<?php echo form_close() ?>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<?php $this->view('backend/widgets/disertasi/column_penguji', [
											'id_disertasi' => $list['id_disertasi'],
											UJIAN_DISERTASI_KUALIFIKASI
									]); ?>
								</td>
								<td class="text-center">
									<?php $this->view('backend/widgets/disertasi/column_jadwal', [
											'id_disertasi' => $list['id_disertasi'],
											UJIAN_DISERTASI_KUALIFIKASI
									]); ?>
								</td>
								<td class="text-center">
									<p class="text-center">
										Status <br/>
										<?php $this->view('backend/widgets/disertasi/column_status', [
												'disertasi' => $list,
												'jenis' => TAHAPAN_DISERTASI_KUALIFIKASI
										]); ?>
									</p>
									<hr class="divider-line-semi-bold"/>
									<?php
										if ($list['status_kualifikasi'] >= STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PENGUJI) {
											?>
											<hr style="margin: 5px"/>
											<!-- SK UJIAN -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php
											$data_dokumen = [
													'tipe' => DOKUMEN_SK_UJIAN_DISERTASI,
													'jenis' => DOKUMEN_JENIS_DISERTASI_UJIAN_KUALIFIKASI_STR,
													'identitas' => $list['nim'],
											];
											$dokumen = $this->dokumen->detail_by_data($data_dokumen);
											?>
											<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_sk_ujian', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<input type="text" name="no_sk" style="margin-bottom: 10px" class="form-control" placeholder="NO SK" value="<?= !empty($dokumen) ? $dokumen->no_doc : '' ?>" required/>
											<input type="text" name="tgl_sk" style="margin-bottom: 10px" class="datepicker form-control" placeholder="TGL SK" value="<?= !empty($dokumen) ? date('d-m-Y', strtotime($dokumen->date_doc)) : '' ?>" required/>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Ujian</button>
											<?php echo form_close() ?>
											<hr class="divider-line-semi-bold"/>

											<!-- Berita Acara -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php
											$ujian = $this->disertasi->read_jadwal($list['id_disertasi'], UJIAN_DISERTASI_KUALIFIKASI);
											?>
											<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_berita', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<textarea style="resize: none;height: 60px;margin-bottom: 10px" class="form-control" name="link_meeting" placeholder="Link Meeting" ><?= !empty($ujian->link_meeting) ? $ujian->link_meeting : '' ?></textarea>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Berita Acara</button>
											<?php echo form_close() ?>
											<hr class="divider-line-semi-bold"/>
											<!-- Form Penilaian -->
											<!--											--><?php //$attributes = array('target' => '_blank'); ?>
											<!--											--><?php //echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_penilaian', $attributes) ?>
											<!--											--><?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<!--											--><?php //echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<!--											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Form Penilaian</button>-->
											<!--											--><?php //echo form_close() ?>
											<!--											<hr class="divider-line-bold"/>-->
											<!-- Nilai Akhir Penilaian -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_nilai_akhir', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Nilai Akhir</button>
											<?php echo form_close() ?>
											<hr class="divider-line-semi-bold"/>
											<!-- Daftar Hadir -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_absensi', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Daftar Hadir</button>
											<?php echo form_close() ?>
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
