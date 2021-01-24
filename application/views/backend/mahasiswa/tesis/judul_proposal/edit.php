<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart('mahasiswa/tesis/judul_proposal/update');?>
                <div class="box-body">
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                    <?php echo formtext('hidden', 'id_gelombang', $gelombang->id_gelombang, 'required') ?>
                    <div class="form-group">
                        <label>Departemen</label>
                        <select name="departemen" class="form-control select2" style="width: 100%;" required>
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
                        <?php $judul = $this->tesis->read_judul($tesis->id_tesis);?>
                        <textarea class="form-control" name="judul" required><?php echo $judul->judul?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Latar Belakang Singkat (250 - 300 kata)</label>
                        <textarea class="form-control" name="latar_belakang" required><?php echo $judul->latar_belakang?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Rumusan Masalah Pertama</label>
                        <textarea class="form-control" name="rumusan_masalah_pertama" required><?php echo $judul->rumusan_masalah_pertama?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Rumusan Masalah Kedua</label>
                        <textarea class="form-control" name="rumusan_masalah_kedua" required><?php echo $judul->rumusan_masalah_kedua?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Rumusan Masalah 3 / 4 (Jika Ada)</label>
                        <textarea class="form-control" name="rumusan_masalah_lain" required><?php echo $judul->rumusan_masalah_lain?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Penelusuran Artikel di Internet</label>
                        <textarea class="form-control" name="penelusuran_artikel_internet" required><?php echo $judul->penelusuran_artikel_internet?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Penelusuran pada Repository UNAIR (<a href="http://repository.unair.ac.id/" target="_blank">repository.unair.ac.id</a>)</label>
                        <textarea class="form-control" name="penelusuran_artikel_unair" required><?php echo $judul->penelusuran_artikel_unair?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Uraikan apa yang memberdakan topik Anda dengan karya ilmiah lain yang topiknya sama / serupa</label>
                        <textarea class="form-control" name="uraian_topik" required><?php echo $judul->uraian_topik?></textarea>
                    </div>
                    <?php
                    if($tesis->berkas_orisinalitas != '') {
                    ?>
                    <div class="form-group">
                        <label>File Surat Pernyataan Orisinalitas</label>
                        <br/>
                        <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/judul_proposal/<?php echo $tesis->berkas_orisinalitas ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <label>Upload Surat Pernyataan Orisinalitas<br/>(format file .pdf maks <?=MAX_SIZE_FILE_UPLOAD_DESCRIPTION?>)</label>
                        <input type="file" name="berkas_orisinalitas" class="form-control" <?php echo ($tesis->berkas_orisinalitas != '') ? '' : 'required';?> >
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <a class="btn btn-sm btn-warning" href="<?= base_url()?>mahasiswa/tesis/judul_proposal"><i class="fa fa-close"></i> Batal</a>
                </div>
            <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>