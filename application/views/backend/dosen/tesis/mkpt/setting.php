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
                        <?php $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_MKPT);?>
                        <textarea class="form-control" name="judul" readonly><?php echo $judul->judul?></textarea>
                    </div>
                    <div class="form-group">
                    <label>Mata Kuliah MKPT</label>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 10%">Kode MK</th>
                                <th style="width: 35%">Nama MK</th>
                                <th style="width: 10%">SKS</th>
                                <th style="width: 45%">Dosen</th>
                                <th style="width: 45%">Status</th>
                            </tr>
                            <?php
                            $tesis_mkpts = $this->tesis->read_tesis_mkpt($tesis->id_tesis);    
                            if (!empty($tesis_mkpts)) {
                                $sudah_publish_semua=$this->tesis->cek_mkpt_sudah_publish($tesis->id_tesis);
                                foreach ($tesis_mkpts as $index => $mkpt) {
                                    $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                                    foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                                        if($pengampu['status'] == '1' OR $pengampu['status'] == '2'){
                                            if($pengampu['status'] == '1'){
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
                                            echo '
                                            <tr>
                                                <td>'.$mkpt['kode'].'</td>
                                                <td>'.$mkpt['mkpt'].'</td>
                                                <td>'.$mkpt['sks'].'</td>
                                                <td>'.$pengampu['nama'].'</td>
                                                <td>'.$status.'</td>
                                            </tr>
                                            ';
                                        }
                                        else {
                                            $status = '<button type="button" class="btn btn-xs btn-warning"> Menunggu Persetujuan</button>';
                                            echo '
                                            <tr>
                                                <td><input name="kode'.$mkpt['id_tesis_mkpt'].'" type="text" class="form-control" value="'.$mkpt['kode'].'"></td>
                                                <td><input name="nama'.$mkpt['id_tesis_mkpt'].'" type="text"  class="form-control" value="'.$mkpt['mkpt'].'"></td>
                                                <td><input name="sks'.$mkpt['id_tesis_mkpt'].'" type="number" class="form-control" value="'.$mkpt['sks'].'"></td>
                                                <td>
                                                    <select name="pengampu'.$mkpt['id_tesis_mkpt'].'" class="form-control select2" style="width: 100%;">
                                                        <option value="">- Pilih -</option>';
                                                        foreach ($mdosen as $list) {
                                                            $selected = '';
                                                            if($pengampu['nip'] == $list['nip']){
                                                                $selected = 'selected';
                                                            }
                                                            echo '<option value="'.$list['nip'].'" '.$selected.' >'.$list['nama'].'</option>';
                                                        }
                                                    echo '
                                                    </select>
                                                </td>
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
                </div>
                <!-- /.box-body -->
            <?= form_close() ?>
        </div>
        <!-- /.box -->
    </div>
    <div class="col-sm-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">1. Setting Jadwal</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('dosen/tesis/mkpt/jadwal_save'); ?>
            <div class="box-body">
                <div class="form-group">
                    <label>Tanggal</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?php
                        if ($ujian) {
                            $id_ujian = $ujian->id_ujian;
                            $tanggal = toindo($ujian->tanggal);
                            $id_ruang = $ujian->id_ruang;
                            $ruang = $ujian->ruang . ' - ' . $ujian->gedung;
                            $id_jam = $ujian->id_jam;
                            $jam = $ujian->jam;
                        } else {
                            $id_ujian = '';
                            $tanggal = '';
                            $id_ruang = '';
                            $ruang = '-Pilih Ruang-';
                            $id_jam = '';
                            $jam = '-Pilih Jam-';
                        }
                        ?>
                        <?php echo formtext('hidden', 'id_ujian', $id_ujian, '') ?>
                        <input type="text" name="tanggal" value="<?php echo $tanggal ?>" class="form-control pull-right" id="datepicker" required>              
                    </div>
                </div>
                <div class="form-group">
                    <label>Ruang</label>
                    <select name="id_ruang" class="form-control select2" style="width: 100%;" required>
                        <option value="<?php echo $id_ruang ?>"><?php echo $ruang ?></option>
                        <?php
                        foreach ($mruang as $list) {
                            ?>
                            <option value="<?php echo $list['id_ruang'] ?>"><?php echo $list['ruang'] . ' - ' . $list['gedung'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jam</label>
                    <select name="id_jam" class="form-control select2" style="width: 100%;" required>
                        <option value="<?php echo $id_jam ?>"><?php echo $jam ?></option>
                        <?php
                        foreach ($mjam as $list) {
                            ?>
                            <option value="<?php echo $list['id_jam'] ?>"><?php echo $list['jam'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?php
                if($ujian) {
                    if ($ujian->status_apv_kaprodi == '1') {
                        ?>
                        <a class="btn btn-warning pull-left" href="<?= base_url()?>dosen/tesis/ujian/batal_verifikasi_jadwal/<?= $tesis->id_tesis?>"><i class="fa fa-edit"></i> Batal</a>
                        <!--
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Ubah Ruang</button>
                        -->
                        <?php
                    } else {
                        ?>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Verifikasi Jadwal</button>
                        <?php
                    }
                }
                else {
                    ?>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan dan Verifikasi Jadwal</button>
                    <?php
                }
                ?>
            </div>
            <?php echo form_close() ?>
        </div>
        <!-- /.box -->
    </div>
    <!-- left column -->
</div>

<div class="row">
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">3. Dosen Penguji</h3>
            </div>
            <?php
            if($ujian){
                ?>
                <div class="box-body table-responsive">
                    <?php 
                        echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_usulan_save_kps');
                        $penguji = $this->tesis->read_penguji_temp_belum_resmi($tesis->id_tesis, UJIAN_TESIS_UJIAN, $ujian->id_ujian, 1); 
                        foreach ($penguji as $listpenguji) {
                    ?>
                        <b>Usulan Pembimbing Utama</b>
                        <br>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
                        <?php echo formtext('hidden', 'nip', $listpenguji['nip'], 'required') ?>
                        <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                        <?php echo $listpenguji['nama'] ?><br/><b><?php echo $listpenguji['nip'] ?></b>
                        <br><br>
                        <button type="submit" name="terima" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan Penguji</button>
                        <button type="submit" name="tolak" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Tolak Penguji</button>
                    <?php
                        } 
                        echo form_close() 
                    ?>
                </div>
                <div class="box-body table-responsive">
                    <?php 
                        echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_usulan_save_kps');
                        $penguji = $this->tesis->read_penguji_temp_belum_resmi($tesis->id_tesis, UJIAN_TESIS_UJIAN, $ujian->id_ujian, 2); 
                        foreach ($penguji as $listpenguji) {
                    ?>
                        <b>Usulan Penguji</b>
                        <br>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
                        <?php echo formtext('hidden', 'nip', $listpenguji['nip'], 'required') ?>
                        <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                        <?php echo $listpenguji['nama'] ?><br/><b><?php echo $listpenguji['nip'] ?></b>
                        <br><br>
                        <button type="submit" name="terima" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan Penguji</button>
                        <button type="submit" name="tolak" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Tolak Penguji</button>
                    <?php
                        } 
                        echo form_close() 
                    ?>
                </div>
                <?php 
                $data_pembimbing_satu = array(
                    'id_ujian' => $id_ujian,
                    'nip' => $tesis->nip_pembimbing_satu
                );
                $cekpenguji_pembimbing_satu = $this->tesis->cek_penguji($data_pembimbing_satu);
                if(empty($cekpenguji_pembimbing_satu)) {
                ?>
                    <div class="box-body table-responsive">
                        <?php 
                            echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_save');
                        ?>
                            <b>Pembimbing Utama</b>
                            <br>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                            <?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
                            <?php echo formtext('hidden', 'nip', $tesis->nip_pembimbing_satu, 'required') ?>
                            <?php echo $tesis->nama_pembimbing_satu ?><br/><b><?php echo $tesis->nip_pembimbing_satu ?></b>
                            <br><br>
                            <button type="simpan" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan Penguji</button>
                        <?php
                            echo form_close() 
                        ?>
                    </div>
                <?php
                }
                $data_pembimbing_dua = array(
                    'id_ujian' => $id_ujian,
                    'nip' => $tesis->nip_pembimbing_dua
                );
                $cekpenguji_pembimbing_dua = $this->tesis->cek_penguji($data_pembimbing_dua);
                if(empty($cekpenguji_pembimbing_dua)) {
                ?>
                    <div class="box-body table-responsive">
                        <?php 
                            echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_save');
                        ?>
                            <b>Pembimbing Kedua</b>
                            <br>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                            <?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
                            <?php echo formtext('hidden', 'nip', $tesis->nip_pembimbing_dua, 'required') ?>
                            <?php echo $tesis->nama_pembimbing_dua ?><br/><b><?php echo $tesis->nip_pembimbing_dua ?></b>
                            <br><br>
                            <button type="simpan" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan Penguji</button>
                        <?php
                            echo form_close() 
                        ?>
                    </div>
                <?php
                } 
            }
            echo form_open('dosen/tesis/ujian/penguji_save'); ?>
            <div class="box-body table-responsive">
                <?php
                if ($ujian) {
                    ?>
                    <div class="form-group">
                        <label>Penguji</label>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
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
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                    <?php echo form_close() ?>
                    <?php $this->view('backend/widgets/tesis/list_penguji_dosen', ['tesis' => $tesis, 'ujian' => $ujian]); ?>
                    <?php
                } else {
                    ?>
                    <div class="form-group">
                        <p>Setting ujian terlebih dahulu</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">4. Status Ujian</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php //echo form_open('dosen/tesis/ujian/update_status_ujian'); ?>
            <div class="box-body">
                <div class="form-group">
                    <?php
                    if($ujian){
                        if(date('Y-m-d') >= $ujian->tanggal) {
                    ?>
                        <label>Status Ujian</label>
                        <?php 
                        foreach ($status_ujians as $status_ujian) {
                            if ($status_ujian['value'] == $tesis->status_ujian_proposal) {
                                echo '<br>'.$status_ujian['text'];
                            }
                        }
                        ?>
                        <!--<select name="status_ujian" class="form-control select2" style="width: 100%;" required>
                            <?php
                            /*foreach ($status_ujians as $status_ujian) {
                                ?>
                                <option value="<?php //echo $status_ujian['value'] ?>" <?php //if ($status_ujian['value'] == $tesis->status_ujian_tesis) echo 'selected' ?>><?php //echo $status_ujian['text'] ?></option>
                                <?php
                            }*/
                            ?>
                        </select>
                        -->
                    <?php
                        } else {
                            echo "<b>Ujian belum dilaksanakan</b>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="box-footer">
                <?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
                <?php //echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                <?php
                /*
                if($ujian){
                    echo '<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Status Ujian</button>';
                }*/
                ?>
            </div>
            <!-- /.box-body -->
            <div class="box-body">
                <?php echo form_close() ?>
                <?php
                if($ujian){
                    $rata_nilai_ujian = $ujian->rata_nilai_ujian ? number_format($ujian->rata_nilai_ujian,1) : 0;
                    $bobot_nilai_konversi = $ujian->bobot_nilai_konversi ? number_format($ujian->bobot_nilai_konversi,1) : 0;
                    $nilai_ujian = $ujian->nilai_ujian ? number_format($ujian->nilai_ujian,1) : 0;
                    ?>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><b>Rata-rata Nilai</b></td>
                                <td><?= $rata_nilai_ujian;?></td>
                            </tr>
                            <tr>
                                <td><b>Bobot Nilai Konversi</b></td>
                                <td><?= $bobot_nilai_konversi?></td>
                            </tr>
                            <tr>
                                <td><b>Nilai Ujian</b></td>
                                <td><?= $nilai_ujian?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php
                }
                ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>