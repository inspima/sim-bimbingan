<?php
	$judul = $this->proposal->read_judul($proposal->id_skripsi);
?>
<?php if($this->session->flashdata('msg')): ?>
	<?php
	$class_alert = 'alert '.$this->session->flashdata('msg-title').' alert-dismissable';
	?>
	<div class='<?=$class_alert?>'>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i> Notifikasi</h4>
		<?php echo $this->session->flashdata('msg'); ?>
	</div>
<?php endif; ?>
<div class="row">
	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $subtitle ?></h3>
				<div class="pull-right">
					<a class="btn btn-xs btn-warning" href="<?= base_url() ?>dosen/sarjana/kadep/proposal/pengajuan"><i class="fa fa-arrow-left"></i> Kembali</a>
				</div>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="form-group">
					<label>NIM</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
					<?php echo formtext('hidden', 'id_judul', $judul->id_judul, 'required') ?>
					<input type="text" name="nim" class="form-control" value="<?php echo $proposal->nim ?>" readonly>
				</div>
				<div class="form-group">
					<label>Nama</label>
					<input type="text" name="nama" class="form-control" value="<?php echo $proposal->nama ?>" readonly>
				</div>
				<div class="form-group">
					<label>Judul</label>
					<textarea class="form-control" name="judul" readonly rows="5" style="resize: none"><?php echo $judul->judul ?></textarea>
				</div>
				<div class="form-group">
					<label>Berkas Proposal</label>
					<p>
						<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $proposal->berkas_proposal ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="50px" height="auto"></a>
					</p>
				</div>


			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>

	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">1. Apakah sesuai dengan departemen ?</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open('dashboardd/proposal/kadep_pengajuan/update_departemen'); ?>
			<div class="box-body">
				<div class="form-group">
					<p>Jika tidak sesuai dengan departemen, pilih pindah departemen yang dituju lalu klilk tombol pindah departemen </p>
				</div>
				<div class="form-group">
					<label>Departemen</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
					<select name="id_departemen" class="form-control select2" style="width: 100%;" required>
						<option value="<?php echo $proposal->id_departemen ?>"><?php echo $proposal->departemen ?></option>
						<?php
							foreach ($departemen as $list) {
								?>
								<option value="<?php echo $list['id_departemen'] ?>"><?php echo $list['departemen'] ?></option>
								<?php
							}
						?>
					</select>
				</div>


			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Pindah Departemen</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>

	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">2. Proses</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open('dashboardd/proposal/kadep_pengajuan/update_proses'); ?>
			<?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
			<?php echo formtext('hidden', 'id_judul', $judul->id_judul, 'required') ?>

			<div class="box-body">
				<div class="form-group">
					<p>Jika sesuai dengan departemen, pilih proses selanjutnya lalu klik tombol proses. </p>
				</div>
				<div class="form-group">
					<label>Proses</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
					<select name="status_proposal" class="form-control select2" style="width: 100%;" required>
						<option value="<?= STATUS_SKRIPSI_PROPOSAL_SETUJUI_KADEP ?>" <?= $proposal->status_proposal >= STATUS_SKRIPSI_PROPOSAL_SETUJUI_KADEP && $proposal->status_proposal < STATUS_SKRIPSI_PROPOSAL_SELESAI ? 'selected' : '' ?>>Diterima</option>
						<option value="<?= STATUS_SKRIPSI_PROPOSAL_DITOLAK ?>" <?= $proposal->status_proposal == STATUS_SKRIPSI_PROPOSAL_DITOLAK ? 'selected' : '' ?>>Ditolak</option>
					</select>
				</div>
				<div class="form-group">
					<label>Keterangan (Diisi saat pengajuan proposal skripsi ditolak)</label>
					<textarea class="form-control" name="keterangan_proposal"></textarea>
				</div>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Proses</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
