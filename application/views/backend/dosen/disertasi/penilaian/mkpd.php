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
<?php $this->view('backend/widgets/disertasi/tab_link_penilaian_dosen'); ?>
<div class="divider10"></div>
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_MKPD]); ?>
<div class="box">
	<!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="datatable-export" class="table table-bordered table-striped">
			<thead>
			<tr>
				<th>No</th>
				<th>Disertasi</th>
				<th class="text-center">Mata Kuliah</th>
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
							<?php $this->view('backend/widgets/disertasi/column_info_disertasi', ['disertasi' => $list]); ?>
						</td>
						<td class="text-center">
							<?php $this->view('backend/widgets/disertasi/column_mkpd', ['id_disertasi' => $list['id_disertasi']]); ?>
						</td>
						<td class="text-center">
							<?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_MPKK]); ?>
							<?php

								if ($list['status_mpkk'] >= STATUS_DISERTASI_MKPD_SETUJUI_PROMOTOR) {
									?>
									<hr style="margin: 10px;border-width:2px;"/>
									<a href="<?= base_url() ?>dosen/disertasi/penilaian/mkpd/input/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Penilaian</a>
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
