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
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_TERTUTUP]); ?>
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
						<th>Tgl.Pengajuan</th>
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
									<?php $this->view('backend/widgets/disertasi/column_info_disertasi_berkas', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_TERTUTUP]); ?>
								</td>
								<td><?php echo woday_toindo($list['waktu_pengajuan_tertutup']) ?></td>
								<td class="text-center">
									<?php $this->view('backend/widgets/disertasi/column_penguji', ['id_disertasi' => $list['id_disertasi'], 'jenis' => UJIAN_DISERTASI_TERTUTUP]); ?>
								</td>
								<td class="text-center">
									<?php $this->view('backend/widgets/disertasi/column_jadwal', ['id_disertasi' => $list['id_disertasi'], 'jenis' => UJIAN_DISERTASI_TERTUTUP]); ?>
								</td>
								<td class="text-center">
									<?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_TERTUTUP]); ?>
									<?php
										if ($list['status_tertutup'] >= 4) {
											?>
											<hr style="margin: 5px"/>

											<!-- SK UJIAN -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php
											$data_dokumen = [
													'tipe' => DOKUMEN_SK_UJIAN_DISERTASI,
													'jenis' => DOKUMEN_JENIS_DISERTASI_UJIAN_TERTUTUP_STR,
													'identitas' => $list['nim'],
											];
											$dokumen = $this->dokumen->detail_by_data($data_dokumen);
											?>
											<?php echo form_open('prodi/doktoral/disertasi/tertutup/cetak_sk_ujian', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<input type="text" name="no_sk" style="margin-bottom: 10px" class="form-control" placeholder="NO SK" value="<?= !empty($dokumen) ? $dokumen->no_doc : '' ?>" required/>
											<input type="text" name="tgl_sk" style="margin-bottom: 10px" class="datepicker form-control" placeholder="TGL SK" value="<?= !empty($dokumen) ? date('d-m-Y', strtotime($dokumen->date_doc)) : '' ?>" required/>
											<br/>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Ujian</button>
											<?php echo form_close() ?>
											<hr class="divider-line-semi-bold"/>

											<!-- Berita Acara -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php
											$ujian = $this->disertasi->read_jadwal($list['id_disertasi'], UJIAN_DISERTASI_TERTUTUP);
											?>
											<?php echo form_open('prodi/doktoral/disertasi/tertutup/cetak_berita', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<textarea style="resize: none;height: 60px;margin-bottom: 10px" class="form-control" name="link_meeting" placeholder="Link Meeting"><?= !empty($ujian->link_meeting) ? $ujian->link_meeting : '' ?></textarea>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Berita Acara</button>
											<?php echo form_close() ?>
											<hr class="divider-line-semi-bold"/>

											<!-- Nilai Akhir Penilaian -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php echo form_open('prodi/doktoral/disertasi/tertutup/cetak_nilai_akhir', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Nilai Akhir</button>
											<?php echo form_close() ?>
											<hr class="divider-line-semi-bold"/>
											<!-- Undangan -->
<!--											--><?php //$attributes = array('target' => '_blank'); ?>
<!--											--><?php //echo form_open('prodi/doktoral/disertasi/tertutup/cetak_undangan', $attributes) ?>
<!--											--><?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
<!--											--><?php //echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
<!--											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Undangan</button>-->
<!--											--><?php //echo form_close() ?>
<!--											<hr style="margin: 2px"/>-->
											<!-- Berita Acara -->
<!--											--><?php //$attributes = array('target' => '_blank'); ?>
<!--											--><?php //echo form_open('prodi/doktoral/disertasi/tertutup/cetak_berita', $attributes) ?>
<!--											--><?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
<!--											--><?php //echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
<!--											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Berita Acara</button>-->
<!--											--><?php //echo form_close() ?>
<!--											<hr style="margin: 2px"/>-->
											<!-- Penilaian -->
<!--											--><?php //$attributes = array('target' => '_blank'); ?>
<!--											--><?php //echo form_open('prodi/doktoral/disertasi/tertutup/cetak_penilaian', $attributes) ?>
<!--											--><?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
<!--											--><?php //echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
<!--											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Form Penilaian</button>-->
<!--											--><?php //echo form_close() ?>
<!--											<hr style="margin: 2px"/>-->
											<!-- Daftar Hadir -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php echo form_open('prodi/doktoral/disertasi/tertutup/cetak_absensi', $attributes) ?>
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
