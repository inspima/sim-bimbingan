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
            <?php echo form_open_multipart('dosen/tesis/mkpt/save'); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label>Pembimbing Utama</label>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <?php echo formtext('hidden', 'id_gelombang', $gelombang->id_gelombang, 'required') ?>
                        <select name="nip_pembimbing_satu" class="form-control select2" style="width: 100%;" disabled>
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
                        <select name="nip_pembimbing_dua" class="form-control select2" style="width: 100%;" disabled>
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
                        <?php $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_PROPOSAL);?>
                        <textarea class="form-control" name="judul" readonly><?php echo $judul->judul?></textarea>
                    </div>
                    <div class="form-group">
                    <label>Mata Kuliah MKPT</label>
                        <?php
                            $tesis_mkpts = $this->tesis->read_tesis_mkpt($tesis->id_tesis);
                            if (!empty($tesis_mkpts)) {
                                ?>
                                <div class="form-group">
                                    <table class="table table-bordered ">
                                        <tr class="bg-gray">
                                            <th>Mata Kuliah</th>
                                            <th>Pengampu</th>
                                            <th class="text-center">Nilai</th>
                                        </tr>
                                        <?php
                                            $sudah_publish_semua=$this->tesis->cek_mkpt_sudah_publish($tesis->id_tesis);
                                            foreach ($tesis_mkpts as $index => $mkpt) {
                                                ?>
                                                <tr>
                                                    <td><?= $index + 1 ?>. (<b><?php echo $mkpt['kode'] ?></b>) <?php echo $mkpt['mkpt'] ?></td>
                                                    <td>
                                                        <?php
                                                            $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                                                            foreach ($mkpt_pengampus as $index_pengampu => $pengampu):
                                                                ?>
                                                                <?= $index_pengampu + 1 ?>. <b><?php echo $pengampu['nama'] ?></b> <br/><i><?php echo $pengampu['nip'] ?></i><br/>
                                                            <?php
                                                            endforeach;
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                            if ($sudah_publish_semua) {
                                                                ?>
                                                                <strong style="font-size: 1.2em"><?php echo $mkpd['nilai_angka'] ?></strong>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <div class="btn btn-xs btn-danger">Belum Di Publish</div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                    </table>
                                </div>

                                <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <p>Data belum ada</p>
                                </div>
                                <?php
                            }
                        ?>

                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10%">Kode MK</th>
                                <th style="width: 35%">Nama MK</th>
                                <th style="width: 10%">SKS</th>
                                <th style="width: 45%">Dosen</th>
                            </tr>
                            <?php
                            if (!empty($tesis_mkpts)) {
                                $sudah_publish_semua=$this->tesis->cek_mkpt_sudah_publish($tesis->id_tesis);
                                foreach ($tesis_mkpts as $index => $mkpt) {
                                ?>
                                <tr>
                                    <td><textarea name="nama<?=$mkpt['id_tesis_mkpt']?>" class="form-control" style="resize: none" ><?php echo $mkpt['kode'] ?></textarea></td>
                                    <td><textarea name="nama<?=$mkpt['id_tesis_mkpt']?>" class="form-control" style="resize: none" ><?php echo $mkpt['mkpt'] ?></textarea></td>
                                    <td><input name="sks<?=$mkpt['id_tesis_mkpt']?>" type="number" class="form-control" value="<?php echo $mkpt['sks'] ?>"></td>
                                    <td>
                                        <select name="pengampu<?=$mkpt['id_tesis_mkpt']?>[]" class="form-control select2" style="width: 100%;"  multiple>
                                            <option value="">- Pilih -</option>
                                            <?php
                                                $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                                                foreach ($mdosen as $list) {
                                                    foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                                                        $selected = '';
                                                        if($pengampu['nip'] == $list['nip']){
                                                            $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $list['nip'] ?>" <?php echo $selected?> ><?php echo $list['nama'] ?></option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                                }
                            }
                            else {
                            ?>
                            <?php
                                for ($i = 1; $i <= 2; $i++) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input name="kode<?=$i?>" type="text" class="form-control" >
                                        </td>
                                        <td>
                                            <textarea name="nama<?=$i?>" class="form-control" style="resize: none" ></textarea>
                                        </td>
                                        <td>
                                            <input name="sks<?=$i?>" type="number" class="form-control" >
                                        </td>
                                        <td>
                                            <select name="pengampu<?=$i?>[]" class="form-control select2" style="width: 100%;"  multiple>
                                                <option value="">- Pilih -</option>
                                                <?php
                                                    foreach ($mdosen as $list) {
                                                        ?>
                                                        <option value="<?php echo $list['nip'] ?>"><?php echo $list['nama'] ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                    if($tesis->berkas_mkpt != '') {
                    ?>
                    <div class="form-group">
                        <label>File Form MKPT</label>
                        <br/>
                        <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/mkpt/<?php echo $tesis->berkas_mkpt ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <a class="btn btn-sm btn-warning" href="<?= base_url()?>dosen/tesis/judul/pembimbing"><i class="fa fa-close"></i> Batal</a>
                </div>
            <?= form_close() ?>
        </div>
        <!-- /.box -->
    </div>
</div>