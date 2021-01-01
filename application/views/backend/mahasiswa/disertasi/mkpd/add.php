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
	<!-- left column -->
	<div class="col-sm-12">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $subtitle ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open_multipart('mahasiswa/disertasi/mkpd/save'); ?>
			<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<div class="box-body">
				<div class="form-group">
					<label>Penasehat Akademik</label>
					<hr class="divider-line-thin"/>
					<p><?php echo $disertasi->nama_penasehat ?> <br/> <b><?php echo $disertasi->nip_penasehat ?></b></p>
				</div>
				<div class="form-group">
					<label>Judul</label>
					<hr class="divider-line-thin"/>
					<?php echo $disertasi->judul ?>
				</div>
				<div class="form-group">
					<label>Mata Kuliah MKPD</label>
					<table class="table table-bordered">
						<tr>
							<th style="width: 10%">Kode MK</th>
							<th style="width: 35%">Nama MK</th>
							<th style="width: 10%">SKS</th>
							<th style="width: 45%">Dosen</th>
						</tr>
						<?php
							for ($i = 1; $i <= 3; $i++) {
								?>
								<tr>
									<td>
										<input name="kode<?=$i?>" type="text" class="form-control" >
									</td>
									<td>
										<textarea name="nama<?=$i?>" class="form-control" style="resize: none" ></textarea>
									</td>
									<td>
										<input name="sks<?=$i?>" type="number" class="form-control" >
									</td>
									<td>
										<select name="pengampu<?=$i?>[]" class="form-control select2" style="width: 100%;"  multiple>
											<option value="">- Pilih -</option>
											<?php
												foreach ($mdosen as $list) {
													?>
													<option value="<?php echo $list['nip'] ?>"><?php echo $list['nama'] ?></option>
													<?php
												}
											?>
										</select>
									</td>
								</tr>
								<?php
							}
						?>
					</table>
				</div>

				<div class="form-group">
					<label>Upload Form MKPD <br/>(format file .pdf maks <?= MAX_SIZE_FILE_UPLOAD_DESCRIPTION ?>)</label>
					<input type="file" name="berkas_mkpd" class="form-control" required>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-up"></i> Ajukan</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
