<div class="box box-info collapsed-box">
    <div class="box-header with-border">

        <h3 class="box-title">Informasi Status</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="display: none;">
        <?php
        if ($jenis == '1') :// KUALIFIKASI
            ?>
            <dl style="margin-left: 20px">
                <dt><label class="label bg-blue">Pengajuan</label></dt>
                <dd>Diajukan oleh mahasiswa </dd>
                <dt><label class="label bg-green">Diterima SPS</label></dt>
                <dd>Diterima dan disetujui oleh Sekertaris Prodi</dd>
                <dt><label class="label bg-green">Diterima KPS</label></dt>
                <dd>Diterima dan disetujui oleh Ketua Prodi</dd>
                <dt><label class="label bg-navy">Dijadwalkan </label></dt>
                <dd>Telah dijadwalkan serta pengajuan Penguji oleh KPS</dd>
                <dt><label class="label bg-purple">Ujian </label></dt>
                <dd>Sudah disetujui semua pihak (Dosbing, Penguji, Sekertaris Prodi, KPS) dan menunggu waktu Ujian</dd>
                <dt><label class="label bg-red">Selesai </label></dt>
                <dd>Ujian Selesai serta hasil sudah ditentukan</dd>
            </dl>
            <?php
        elseif ($jenis == '2') :// MPKK
            ?>
            <dl style="margin-left: 20px">
                <dt><label class="label bg-blue">Pengajuan</label></dt>
                <dd>Diajukan oleh mahasiswa </dd>
                <dt><label class="label bg-green">Diterima SPS</label></dt>
                <dd>Diterima dan disetujui oleh Sekertaris Prodi</dd>
                <dt><label class="label bg-green">Diterima KPS</label></dt>
                <dd>Diterima dan disetujui oleh KPS</dd>
                <dt><label class="label bg-red">Selesai </label></dt>
                <dd>Selesai dan dapat melanjutkan ke Proposal</dd>
            </dl>
            <?php
        elseif ($jenis == '3') :// PROPOSAL
            ?>
            <dl style="margin-left: 20px">
                <dt><label class="label bg-blue">Pengajuan</label></dt>
                <dd>Diajukan oleh mahasiswa </dd>
                <dt><label class="label bg-green">Diterima SPS</label></dt>
                <dd>Diterima dan disetujui oleh Sekertaris Prodi</dd>
                <dt><label class="label bg-green">Diterima KPS</label></dt>
                <dd>Diterima dan disetujui oleh KPS</dd>
                <dt><label class="label bg-navy">Dijadwalkan </label></dt>
                <dd>Telah dijadwalkan serta pengajuan Penguji oleh Promotor</dd>
                <dt><label class="label bg-purple">Ujian </label></dt>
                <dd>Sudah disetujui semua pihak (Dosbing, Penguji, Sekertaris Prodi, KPS) dan menunggu waktu Ujian</dd>
                <dt><label class="label bg-red">Selesai </label></dt>
                <dd>Ujian Selesai serta hasil sudah ditentukan</dd>
            </dl>
            <?php
        elseif ($jenis == '4') :// KELAYAKAN
        elseif ($jenis == '5') :// KELAYAKAN
        elseif ($jenis == '6') :// UJIAN TERTUTUP
        elseif ($jenis == '7') :// UJIAN TERBUKA
        endif;
        ?>


    </div>
    <!-- /.box-body -->
</div>