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
	<div class="col-xs-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Dosen Pembimbing</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body table-responsive">
				<?php echo form_open('baa/utility/pembimbing/sarjana/save'); ?>
				<div class="form-group">
					<label>Pilih Pembimbing</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_skripsi', $id_skripsi, 'required') ?>
					<select name="nip" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($mdosen as $list) {
								?>
								<option value="<?php echo $list['nip'] ?>"><?php echo $list['nama'] ?></option>
								<?php
							}
						?>
					</select>
				</div>

				<!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i> Simpan</button>
				</div>
				<?php echo form_close() ?>
				<div class="form-group">
					<table class="table table-bordered">
						<tr>
							<th>Nama</th>
							<th>Opsi</th>
						</tr>
						<?php
							$pembimbing = $this->skripsi->read_pembimbing($id_skripsi);
							foreach ($pembimbing as $listpembimbing) {
								?>
								<tr>
									<td>
										<?= $listpembimbing['status'] == '1' ? '<b class="text-primary">Usulan</b><br/>' : '' ?>
										<?php echo $listpembimbing['nama'] ?>
										<br/>
										<?= $listpembimbing['nip'] ?>
									</td>
									<td class="text-center">

										<?php echo form_open('baa/utility/pembimbing/sarjana/delete') ?>
										<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
										<?php echo formtext('hidden', 'id_skripsi', $id_skripsi, 'required') ?>
										<?php echo formtext('hidden', 'id_pembimbing', $listpembimbing['id_pembimbing'], 'required') ?>
										<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
										<?php echo form_close() ?>
									</td>
								</tr>
								<?php
							}
						?>
					</table>
				</div>
			</div>
		</div>
		<!-- /.box -->
	</div>

</div>
