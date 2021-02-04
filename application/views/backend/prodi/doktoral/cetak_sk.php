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
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Disertasi</th>
						<th class="text-center">Penasehat</th>
						<th class="text-center">Promotor & Co-Promotor</th>
						<th class="text-center">Tahapan</th>
						<th class="text-center">Status</th>
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
									<?php $this->view('backend/widgets/disertasi/column_info_disertasi', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_KUALIFIKASI]); ?>
								</td>
								<td>
									<?php echo $list['nama_penasehat'] ?><br/><b><?php echo $list['nip_penasehat'] ?></b>
									<hr class="divider-line-semi-bold"/>
									<?php $attributes = array('target' => '_blank'); ?>
									<?php echo form_open('prodi/disertasi/cetak/sk-penasehat', $attributes) ?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
									<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Penasehat</button>
									<?php echo form_close() ?>
								</td>
								<td>
									<?php $this->view('backend/widgets/disertasi/column_promotor', ['id_disertasi' => $list['id_disertasi'], UJIAN_DISERTASI_KUALIFIKASI]); ?>
									<hr class="divider-line-semi-bold"/>
									<?php $attributes = array('target' => '_blank'); ?>
									<?php echo form_open('prodi/disertasi/cetak/sk-penasehat', $attributes) ?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
									<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Promotor</button>
									<?php echo form_close() ?>
								</td>
								<td>
									<?php $this->view('backend/widgets/disertasi/column_tahapan', ['disertasi' => $list]); ?>
								</td>
								<td class="text-center">
									<?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, $list['jenis']]); ?>
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
