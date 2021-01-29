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
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?=$subtitle?></h3>
				<div class="pull-right">
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<div class="btn-group">
					<a class="<?= ($this->uri->segment(4) == 'penguji_pengajuan') ? 'btn btn-default' : 'btn btn-info'; ?>" href="<?php echo base_url() ?>dosen/sarjana/proposal/penguji_pengajuan">Pengajuan</a>
					<a class="<?= ($this->uri->segment(4) == 'penguji_riwayat') ? 'btn btn-default' : 'btn btn-primary'; ?>" href="<?php echo base_url() ?>dosen/sarjana/proposal/penguji_riwayat">Riwayat</a>
				</div>
				<hr class="divider-line-thin"/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Judul</th>
						<th>Berkas Proposal</th>
						<th>Status Tim</th>
						<th>Tanggal</th>
						<th>Jam</th>
						<th>Ruang</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach($penguji as $list){
							?>
							<tr>
								<td><?=$no?></td>
								<td><?=$list['nama'].'<br>('.$list['nim'].')'?></td>
								<td><?php
										$judul = $this->penguji->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?></td>
								<td>
									<a href="<?php echo base_url()?>assets/upload/proposal/<?php echo $list['berkas_proposal']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>
								</td>
								<td>
									<?php
										if($list['status_tim'] == '1')
										{
											echo 'Ketua';
										}
										else
											if($list['status_tim'] == '2')
											{
												echo 'Anggota';
											}
									?>
								</td>
								<td><?php echo toindo($list['tanggal'])?></td>
								<td><?=$list['jam']?></td>
								<td><?=$list['ruang'].' '.$list['gedung']?></td>
								<td>
									<?php echo form_open('dashboardd/proposal/penguji_pengajuan/update_penguji');?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
									<?php echo formtext('hidden', 'id_penguji', $list['id_penguji'], 'required') ?>
									<?php echo formtext('hidden', 'status', '2', 'required') ?>
									<button type="submit" class="btn btn-xs btn-success"> Approve</button>
									<?php echo form_close();?>

									<?php echo form_open('dashboardd/proposal/penguji_pengajuan/update_penguji');?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
									<?php echo formtext('hidden', 'id_penguji', $list['id_penguji'], 'required') ?>
									<?php echo formtext('hidden', 'status', '3', 'required') ?>
									<button type="submit" class="btn btn-xs btn-danger"> Tolak</button>
									<?php echo form_close();?>
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
