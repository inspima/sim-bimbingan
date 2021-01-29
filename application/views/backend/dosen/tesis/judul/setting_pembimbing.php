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
            <?php echo form_open_multipart('dosen/tesis/judul/setting_pembimbing_save');?>
                <div class="box-body">
                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control" value="<?= $tesis->nim;?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nim" class="form-control" value="<?= $tesis->nama;?>" readonly>
                    </div>
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
                        <label>Departemen</label>
                        <select name="departemen" class="form-control select2" style="width: 100%;" disabled>
                            <option value="">- Pilih -</option>
                            <?php
                            foreach ($departemen as $list) {
                                $selected = '';
                                if($list['id_departemen'] == $tesis->id_departemen){
                                    $selected = 'selected';
                                }
                                else {
                                    $selected = '';
                                }
                                ?>
                                <option value="<?php echo $list['id_departemen'] ?>" <?php echo $selected;?> ><?php echo $list['departemen'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Judul</label>
                        <?php $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_JUDUL);?>
                        <textarea class="form-control" name="judul" readonly><?php echo $judul->judul?></textarea>
                    </div>
                    <?php
                    if($tesis->berkas_orisinalitas != '') {
                    ?>
                    <div class="form-group">
                        <label>File Surat Pernyataan Orisinalitas</label>
                        <br/>
                        <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/judul/<?php echo $tesis->berkas_orisinalitas ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                    </div>
                    <?php
                    }
                    ?>
                    <!--
                    <div class="form-group">
                        <label>Upload Berkas Ujian Proposal Tesis<br/>(format file .pdf maks <?php //echo MAX_SIZE_FILE_UPLOAD_DESCRIPTION?>)</label>
                        <input type="file" name="berkas_proposal" class="form-control" >
                    </div>
                    -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <a class="btn btn-sm btn-warning" href="<?= base_url()?>mahasiswa/tesis/judul"><i class="fa fa-close"></i> Batal</a>
                </div>
            <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>