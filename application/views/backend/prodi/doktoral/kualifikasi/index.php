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
						<th>Tgl.Pengajuan</th>
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
									<?php $this->view('backend/widgets/disertasi/column_info_disertasi_berkas', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_KUALIFIKASI]); ?>
								</td>
								<td><?php echo woday_toindo($list['waktu_pengajuan_kualifikasi']) ?></td>
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
											<!-- Undangan -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_sk_penasehat', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<input type="text" name="no_sk" class="form-control" required placeholder="NOMOR SK">
											<br/><br/>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Penasehat</button>
											<?php echo form_close() ?>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<?php $this->view('backend/widgets/disertasi/column_penguji', ['id_disertasi' => $list['id_disertasi'], UJIAN_DISERTASI_KUALIFIKASI]); ?>
								</td>
								<td class="text-center">
									<?php $this->view('backend/widgets/disertasi/column_jadwal', ['id_disertasi' => $list['id_disertasi'], UJIAN_DISERTASI_KUALIFIKASI]); ?>
								</td>
								<td class="text-center">
									<p class="text-center">
										Status <br/>
										<?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis'=>TAHAPAN_DISERTASI_KUALIFIKASI]); ?>
									</p>
									<hr class="divider-line-semi-bold"/>
									<?php
										if ($list['status_kualifikasi'] >= STATUS_DISERTASI_KUALIFIKASI_SETUJUI_KPS) {
											?>
											<hr style="margin: 5px"/>
											<!-- Undangan -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_undangan', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Undangan</button>
											<?php echo form_close() ?>
											<hr style="margin: 2px"/>
											<!-- Berita Acara -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_berita', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Berita Acara</button>
											<?php echo form_close() ?>
											<hr style="margin: 2px"/>
											<!-- Penilaian -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php echo form_open('prodi/doktoral/disertasi/kualifikasi/cetak_penilaian', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Form Penilaian</button>
											<?php echo form_close() ?>
											<hr style="margin: 2px"/>
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
