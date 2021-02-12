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
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_PROMOTOR]); ?>
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
						<th class="text-center">Promotor</th>
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
								<td>
									<p class="text-center">
									Status <br/>
									<?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis'=>TAHAPAN_DISERTASI_PROMOTOR]); ?>
									</p>
									<hr class="divider-line-semi-bold"/>
									<?php $this->view('backend/widgets/disertasi/column_promotor_prodi', ['disertasi' => $list,'id_disertasi'=>$list['id_disertasi']]); ?>
									<?php
										if ($list['status_promotor'] >= STATUS_DISERTASI_PROMOTOR_SETUJUI_KPS) {
											?>
											<div class="divider5"></div>
											<hr class="divider-line-semi-bold"/>
											<!-- Undangan -->
											<?php $attributes = array('target' => '_blank'); ?>
											<?php echo form_open('prodi/doktoral/disertasi/promotor/cetak_sk', $attributes) ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
											<input type="text" name="no_sk" class="form-control" required placeholder="NOMOR SK">
											<br/><br/>
											<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Promotor</button>
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
