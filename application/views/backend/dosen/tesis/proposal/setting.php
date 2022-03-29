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
    <div class="col-sm-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">Informasi Tesis</h2>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><label>NIM</label></td>
                            <td><?php echo $tesis->nim ?></td>            
                        </tr>
                        <tr>
                            <td><label>Nama</label></td>
                            <td><?php echo $tesis->nama; ?></td>            
                        </tr>
                        <tr>
                            <td><label>Tesis</label></td>
                            <td>
                            <?php 
                                $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_PROPOSAL);
                                echo '<b>Judul : </b>'.$judul->judul.'<br>';
                                
                                if($tesis->berkas_orisinalitas != '') {
                                    echo '<b>Berkas Orisinalitas : </b><a href="'.base_url().'assets/upload/mahasiswa/tesis/judul/'.$tesis->berkas_orisinalitas.'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a><br>';
                                }
                            ?>
                            </td>            
                        </tr>
                        <tr>
                            <td><label>Pembimbing Utama</label></td>
                            <td>
                                <b><?php echo $tesis->nip_pembimbing_satu ?></b><br>
                                <?php echo $tesis->nama_pembimbing_satu ?>
                            </td>            
                        </tr>
                        <tr>
                            <td><label>Pembimbing Kedua</label></td>
                            <td>
                                <b><?php echo $tesis->nip_pembimbing_dua ?></b><br>
                                <?php echo $tesis->nama_pembimbing_dua ?>
                            </td>            
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- left column -->
    <div class="col-sm-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">1. Setting Jadwal</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('dosen/tesis/proposal/jadwal_save'); ?>
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
                            $link_zoom = $ujian->link_zoom;
                            $status_apv_kaprodi = $ujian->status_apv_kaprodi;
                        } else {
                            $id_ujian = '';
                            $tanggal = '';
                            $id_ruang = '';
                            $ruang = '-Pilih Ruang-';
                            $id_jam = '';
                            $jam = '-Pilih Jam-';
                            $link_zoom = '';
                            $status_apv_kaprodi = '';
                        }
                        ?>
                        <?php echo formtext('hidden', 'id_ujian', $id_ujian, '') ?>
                        <input type="text" name="tanggal" value="<?php echo $tanggal ?>" class="form-control pull-right" id="datepicker" <?php echo ($status_apv_kaprodi == '1') ? 'disabled' : ''; ?> required>              
                    </div>
                </div>
                <div class="form-group">
                    <label>Ruang</label>
                    <select name="id_ruang" class="form-control select2" style="width: 100%;" <?php echo ($status_apv_kaprodi == '1') ? 'disabled' : ''; ?> required>
                        <?php
                        foreach ($mruang as $list) {
                            ?>
                            <option value="<?php echo $list['id_ruang'] ?>" <?php echo ($list['id_ruang'] == $id_ruang) ? 'selected' : ''; ?> ><?php echo $list['ruang'] . ' - ' . $list['gedung'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jam</label>
                    <select name="id_jam" class="form-control select2" style="width: 100%;" <?php echo ($status_apv_kaprodi == '1') ? 'disabled' : ''; ?> required>
                        <!-- <option value="<?php //echo $id_jam ?>"><?php //echo $jam ?></option> -->
                        <?php
                        foreach ($mjam as $list) {
                            ?>
                            <option value="<?php echo $list['id_jam'] ?>" <?= ($id_jam == $list['id_jam']) ? 'selected' : ''?>><?php echo $list['jam'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <?php
                if($link_zoom != ''){
                    echo '
                    <div class="form-group">
                        <label>Link Zoom</label>
                        <br>
                        '.$link_zoom.'
                    </div>';   
                }
                ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?php
                if($ujian) {
                    if ($ujian->status_apv_kaprodi == '1') {
                        ?>
                        <a class="btn btn-warning pull-left" href="<?= base_url()?>dosen/tesis/proposal/batal_verifikasi_jadwal/<?= $tesis->id_tesis?>"><i class="fa fa-edit"></i> Batal</a>
                        <!--
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Ubah Ruang</button>
                        -->
                        <?php
                    } else if ($ujian->status_apv_kaprodi == NULL) {
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
<?php
if ($tesis->status_proposal >= STATUS_TESIS_PROPOSAL_DIJADWALKAN) {
?>
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
                        $penguji = $this->tesis->read_penguji_temp_belum_resmi($tesis->id_tesis, UJIAN_TESIS_PROPOSAL, $ujian->id_ujian, 1); 
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
                        $penguji = $this->tesis->read_penguji_temp_belum_resmi($tesis->id_tesis, UJIAN_TESIS_PROPOSAL, $ujian->id_ujian, 2); 
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
            echo form_open('dosen/tesis/proposal/penguji_save'); ?>
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
                    <?php echo form_open('dosen/tesis/proposal/kirim_whatsapp'); ?>
                    <div class="form-group">
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-comment"></i> Kirim Notifikasi Whatsapp</button>
                    </div>
                    <?php echo form_close() ?>
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
            <?php //echo form_open('dosen/tesis/proposal/update_status_ujian'); ?>
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
                                <option value="<?php //echo $status_ujian['value'] ?>" <?php //if ($status_ujian['value'] == $tesis->status_ujian_proposal) echo 'selected' ?>><?php //echo $status_ujian['text'] ?></option>
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
            <?php echo form_close() ?>
        </div>
        <!-- /.box -->
    </div>
</div>
<?php
}
?>
