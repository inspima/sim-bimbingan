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
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart('mahasiswa/tesis/ujian/save'); ?>
            <div class="box-body">
                <div class="form-group">
                    <label>Pembimbing Utama</label>
                    <br>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                    <?php echo $tesis->nama_pembimbing_satu ?><br/><b><?php echo $tesis->nip_pembimbing_satu ?></b>
                </div>
                <div class="form-group">
                    <label>Pembimbing Kedua</label>
                    <br>
                    <?php echo $tesis->nama_pembimbing_dua ?><br/><b><?php echo $tesis->nip_pembimbing_dua ?></b>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <textarea class="form-control" name="judul" required><?php echo $tesis->judul ?></textarea>
                </div>
                <div class="form-group">
                    <label>Upload Berkas Ujian Tesis<br/>(format file .pdf maks <?=MAX_SIZE_FILE_UPLOAD_DESCRIPTION?>)</label>
                    <input type="file" name="berkas_tesis" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Upload Syarat Ujian Tesis<br>
                    1. SPP<br>
                    2. ELPT<br> 
                    3. Turnitin<br>
                    4. Jurnal<br>
                    5. Validasi Publikasi<br>
                    6. MKPT (Optional, hanya wajib untuk Magister Ilmu Hukum)<br>
                    Dijadikan satu file<br>
                    (format file .pdf maks <?=MAX_SIZE_FILE_UPLOAD_DESCRIPTION?>)</label>
                    <input type="file" name="berkas_syarat_tesis" class="form-control" required>
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