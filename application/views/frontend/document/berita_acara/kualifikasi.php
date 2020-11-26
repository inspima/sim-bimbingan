<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $subtitle ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <dl>
                    <dt>Nama Dokumen</dt>
                    <dd><?= $nama_dokumen ?></dd>
                </dl>
                <dl>
                    <dt>NIM</dt>
                    <dd><?= $disertasi->nim ?></dd>
                </dl>
                <dl>
                    <dt>Nama</dt>
                    <dd><?= $disertasi->nama ?></dd>
                </dl>
                <dl>
                    <dt>Waktu Pelaksanaan</dt>
                    <dd><?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?></dd>
                </dl>
                <dl>
                    <dt>File</dt>
                    <dd><a class="btn btn-xs bg-red" href="<?= base_url() . 'document/berita_acara/cetak?doc=' . bin2hex($this->encryption->create_key(32)) . '$' . $disertasi->id_disertasi . '$' . TAHAPAN_DISERTASI_KUALIFIKASI ?>"><i class="fa fa-file-pdf-o"></i> Unduh</a></dd>
                </dl>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>