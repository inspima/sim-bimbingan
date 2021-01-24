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
<div class="callout callout-info">
    <h4>Syarat</h4>
    <p>Jangka waktu Ujian 1 dan Proposal Minimal 6 Bulan, Nilai MKPD lengkap beserta Transkrip</p>
</div>
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart('mahasiswa/disertasi/kelayakan/save'); ?>
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
                    <textarea  style="resize: none;height: 80px;" class="form-control" name="judul" required><?php echo $disertasi->judul ?></textarea>
                </div>

                <div class="form-group">
                    <label>Upload Transkrip <br/>(format file .pdf maks <?= MAX_SIZE_FILE_UPLOAD_DESCRIPTION ?>)</label>
                    <input type="file" name="berkas_kelayakan" class="form-control" required>
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
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Promotor & Ko-Promotor</h3>
            </div>
            <div class="box-body table-responsive">
                <?php $this->view('backend/widgets/disertasi/list_promotor_kopromotor', ['disertasi' => $disertasi]); ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
