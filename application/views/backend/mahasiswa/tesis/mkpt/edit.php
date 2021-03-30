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
            <?php echo form_open_multipart('mahasiswa/tesis/mkpt/update');?>
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
                        <?php $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_MKPT);?>
                        <textarea class="form-control" name="judul" readonly><?php echo $judul->judul?></textarea>
                    </div>
                    <div class="form-group">
                    <label>Mata Kuliah MKPT</label>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%">Topik</th>
                                <th style="width: 10%">SKS</th>
                                <th style="width: 45%">Dosen</th>
                                <th style="width: 45%">Status</th>
                                <th style="width: 10%">Nilai</th>
                            </tr>
                            <?php
                            $tesis_mkpts = $this->tesis->read_tesis_mkpt($tesis->id_tesis); 
                            $hitung_pengampu_setuju = 0;   
                            $hitung_nilai_publish = 0;
                            if (!empty($tesis_mkpts)) {
                                $sudah_publish_semua=$this->tesis->cek_mkpt_sudah_publish($tesis->id_tesis);
                                foreach ($tesis_mkpts as $index => $mkpt) {
                                    $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                                    foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                                        if($pengampu['status'] == '1' OR $pengampu['status'] == '2'){
                                            if($pengampu['status'] == '1'){
                                                $hitung_pengampu_setuju = $hitung_pengampu_setuju + 1;
                                                $status = '<button type="button" class="btn btn-xs btn-success"> Disetujui</button>';
                                            } 
                                            else if($pengampu['status'] == '2'){
                                                $status = '<button type="button" class="btn btn-xs btn-danger"> Ditolak</button>';
                                            }

                                            foreach ($mdosen as $list) {
                                                $dosen_mkpt = '';
                                                if($pengampu['nip'] == $list['nip']){
                                                    $dosen_mkpt = $list['nama'];
                                                }
                                            }

                                            if($mkpt['nilai_publish'] != ''){
                                                $hitung_nilai_publish = $hitung_nilai_publish + 1;
                                            }
                                            echo '
                                            <tr>
                                                <td>'.$mkpt['mkpt'].'</td>
                                                <td>'.$mkpt['sks'].'</td>
                                                <td>'.($pengampu['nip'] ? ('<b>'.$pengampu['nip'].'</b><br>'.$pengampu['nama']) : 'Belum Disetting').'</td>
                                                <td>'.$status.'</td>
                                                <td>'.$pengampu['nilai_angka'].'</td>
                                            </tr>
                                            ';
                                        }
                                        else {
                                            $status = '<button type="button" class="btn btn-xs btn-warning"> Menunggu Persetujuan</button>';
                                            echo '
                                            <tr>
                                                <td><input name="nama'.$mkpt['id_tesis_mkpt'].'" type="text"  class="form-control" value="'.$mkpt['mkpt'].'"></td>
                                                <td><input name="sks'.$mkpt['id_tesis_mkpt'].'" type="number" class="form-control" value="'.$mkpt['sks'].'"></td>
                                                <td></td>
                                                <td>'.$status.'</td>
                                            </tr>
                                            ';
                                        }
                                        ?>
                                    <?php
                                    }
                                }
                            }
                            else {
                            ?>
                            <?php
                                for ($i = 1; $i <= 2; $i++) {
                                    ?>
                                    <tr>
                                        <td>
                                            <textarea name="nama<?=$i?>" class="form-control" style="resize: none" ></textarea>
                                        </td>
                                        <td>
                                            <input name="sks<?=$i?>" type="number" value="2" class="form-control" >
                                        </td>
                                        <td>
                                            <select name="pengampu<?=$i?>[]" class="form-control select2" style="width: 100%;"  multiple>
                                                <option value="">- Pilih -</option>
                                                <?php
                                                    foreach ($mdosen as $list) {
                                                        ?>
                                                        <option value="<?php echo $list['nip'] ?>"><?php echo $list['nip'].' - '.$list['nama'] ?></option>
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
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <a class="btn btn-sm btn-warning" href="<?= base_url()?>mahasiswa/tesis/mkpt"><i class="fa fa-close"></i> Batal</a>
                </div>
            <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>