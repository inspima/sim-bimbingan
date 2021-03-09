<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $title ?></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<dl>
					<dt>Nama Dokumen</dt>
					<dd><?= $dokumen->nama ?></dd>
				</dl>
				<dl>
					<dt>Tanggal</dt>
					<dd><?php echo hari($dokumen->date) ?>, <?php echo woday_toindo($dokumen->date) ?></dd>
				</dl>
				<dl>
					<dt>Status</dt>
					<dd>
						<?php if ($setujui_semua) {
							?>
							<span class="btn btn-xs bg-green" >Selesai</span>
							<?php
						} else {
							?>
							<span class="btn btn-xs bg-red" >TTD Belum lengkap</span>
							<?php
						}
						?>
					</dd>
				</dl>
				<dl>
					<dt>File</dt>
					<dd><a class="btn btn-xs bg-red" href="<?= $dokumen->link_cetak ?>"><i class="fa fa-file-pdf-o"></i> Unduh</a></dd>
				</dl>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
