<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart('mahasiswa/tesis/ujian/update');?>
                <div class="box-body">
                    <div class="form-group">
                        <label>Pembimbing Utama</label>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <?php echo formtext('hidden', 'id_gelombang', $gelombang->id_gelombang, 'required') ?>
                        <select name="nip_pembimbing_satu" class="form-control select2" style="width: 100%;" required>
                            <option value="">- Pilih -</option>
                            <?php
                            foreach ($mdosen as $list) {
                                $selected = '';
                                if($list['nip'] == $tesis->nip_pembimbing_satu){
                                    $selected = 'selected';
                                }
                                else {
                                    $selected = '';
                                }
                                ?>
                                <option value="<?php echo $list['nip'] ?>" <?php echo $selected;?> ><?php echo $list['nama'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pembimbing Kedua</label>
                        <select name="nip_pembimbing_dua" class="form-control select2" style="width: 100%;" required>
                            <option value="">- Pilih -</option>
                            <?php
                            foreach ($mdosen as $list) {
                                $selected = '';
                                if($list['nip'] == $tesis->nip_pembimbing_dua){
                                    $selected = 'selected';
                                }
                                else {
                                    $selected = '';
                                }
                                ?>
                                <option value="<?php echo $list['nip'] ?>" <?php echo $selected;?> ><?php echo $list['nama'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Judul</label>
                        <?php $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_UJIAN);?>
                        <textarea class="form-control" name="judul" required><?php echo $judul->judul?></textarea>
                    </div>
                    <?php
                    if($tesis->berkas_tesis != '') {
                    ?>
                    <div class="form-group">
                        <label>File Berkas Ujian Tesis</label>
                        <br/>
                        <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/ujian/<?php echo $tesis->berkas_tesis ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                    </div>
                    <?php 
                    }
                    ?>
                    <div class="form-group">
                        <label>Upload Berkas Ujian Tesis<br/>(format file .pdf maks <?=MAX_SIZE_FILE_UPLOAD_DESCRIPTION?>)</label>
                        <input type="file" name="berkas_tesis" class="form-control" >
                    </div>
                    <?php
                    if($tesis->berkas_syarat_tesis != '') {
                    ?>
                    <div class="form-group">
                        <label>File Berkas Syarat Ujian Tesis</label>
                        <br/>
                        <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/ujian/<?php echo $tesis->berkas_syarat_tesis ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                    </div>
                    <?php 
                    }
                    ?>
                    <div class="form-group">
                        <label>Upload Berkas Syarat Ujian Tesis<br>
                            1. SPP<br>
                            2. ELPT<br> 
                            3. Turnitin<br>
                            4. Jurnal<br>
                            5. Validasi Publikasi<br>
                            6. MKPT (Optional, hanya wajib untuk Magister Ilmu Hukum)<br>
                            Dijadikan satu file<br>(format file .pdf maks <?=MAX_SIZE_FILE_UPLOAD_DESCRIPTION?>)</label>
                        <input type="file" name="berkas_syarat_tesis" class="form-control" >
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <a class="btn btn-sm btn-warning" href="<?= base_url()?>mahasiswa/tesis/ujian"><i class="fa fa-close"></i> Batal</a>
                </div>
            <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>