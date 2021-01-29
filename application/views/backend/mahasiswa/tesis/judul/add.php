<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart('mahasiswa/tesis/judul/save'); ?>
            <div class="box-body">
                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                <?php echo formtext('hidden', 'id_gelombang', $gelombang->id_gelombang, 'required') ?>
                <div class="form-group">
                    <label>Departemen</label>
                    <select name="departemen" class="form-control select2" style="width: 100%;" required>
                        <option value="">- Pilih -</option>
                        <?php
                        foreach ($departemen as $list) {
                            ?>
                            <option value="<?php echo $list['id_departemen'] ?>" ><?php echo $list['departemen'] ?></option>
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
                    <label>Latar Belakang Singkat (250 - 300 kata)</label>
                    <textarea class="form-control" name="latar_belakang" required></textarea>
                </div>
                <div class="form-group">
                    <label>Rumusan Masalah Pertama</label>
                    <textarea class="form-control" name="rumusan_masalah_pertama" required></textarea>
                </div>
                <div class="form-group">
                    <label>Rumusan Masalah Kedua</label>
                    <textarea class="form-control" name="rumusan_masalah_kedua" required></textarea>
                </div>
                <div class="form-group">
                    <label>Rumusan Masalah 3 / 4 (Jika Ada)</label>
                    <textarea class="form-control" name="rumusan_masalah_lain" required></textarea>
                </div>
                <div class="form-group">
                    <label>Penelusuran Artikel di Internet</label>
                    <textarea class="form-control" name="penelusuran_artikel_internet" required></textarea>
                </div>
                <div class="form-group">
                    <label>Penelusuran pada Repository UNAIR (<a href="http://repository.unair.ac.id/" target="_blank">repository.unair.ac.id</a>)</label>
                    <textarea class="form-control" name="penelusuran_artikel_unair" required></textarea>
                </div>
                <div class="form-group">
                    <label>Uraikan apa yang memberdakan topik Anda dengan karya ilmiah lain yang topiknya sama / serupa</label>
                    <textarea class="form-control" name="uraian_topik" required></textarea>
                </div>
                <div class="form-group">
                    <label>Upload Surat Pernyataan Orisinalitas<br/>(format file .pdf maks <?=MAX_SIZE_FILE_UPLOAD_DESCRIPTION?>)</label>
                    <input type="file" name="berkas_orisinalitas" class="form-control" required>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-sm btn-warning" href="<?= base_url() ?>mahasiswa/tesis/judul"><i class="fa fa-close"></i> Batal</a>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.box -->
    </div>
</div>