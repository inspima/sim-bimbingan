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

            <?php echo form_open_multipart('mahasiswa/disertasi/kualifikasi/save'); ?>
            <div class="box-body">
                <div class="form-group">
                    <label>Penasehat Akademik</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_gelombang', $gelombang->id_gelombang, 'required') ?>
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
                <div class="form-group">
                    <label>Judul</label>
                    <textarea class="form-control" name="judul" required></textarea>
                </div>
                <div class="form-group">
                    <label>Berkas - Transrkip dan SK Yudisium<br/>(format file .pdf maks <?=MAX_SIZE_FILE_UPLOAD_DESCRIPTION?>)</label>
                    <input type="file" name="berkas_kualifikasi" class="form-control" required>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-sm btn-warning" href="<?= base_url() ?>mahasiswa/disertasi/kualifikasi"><i class="fa fa-close"></i> Batal</a>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.box -->
    </div>
</div>
