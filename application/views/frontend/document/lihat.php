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
					<dt>Tanggal Dokumen</dt>
					<dd><?php echo hari($dokumen->date_doc) ?>, <?php echo woday_toindo($dokumen->date_doc) ?></dd>
				</dl>
				<dl>
					<dt>File</dt>
					<dd>
						<a class="btn btn-xs bg-red" href="<?= $dokumen->link_cetak ?>"><i class="fa fa-file-pdf-o"></i> Unduh</a>
					</dd>
				</dl>
			</div>
			<!-- /.box-body-->
		</div>
	</div>
</div>
