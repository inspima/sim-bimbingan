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
            <?php echo form_open('dosen/tesis/proposal/jadwal_pembimbing_save'); ?>
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
                            $status_apv_kaprodi = $ujian->status_apv_kaprodi;
                            $link_zoom = $ujian->link_zoom;
                        } else {
                            $id_ujian = '';
                            $tanggal = '';
                            $id_ruang = '';
                            $ruang = '-Pilih Ruang-';
                            $id_jam = '';
                            $jam = '-Pilih Jam-';
                            $status_apv_kaprodi = '';
                            $link_zoom = '';
                        }
                        ?>
                        <?php echo formtext('hidden', 'id_ujian', $id_ujian, '') ?>
                        <input type="text" name="tanggal" value="<?php echo $tanggal ?>" class="form-control pull-right" id="datepicker" <?= ($status_apv_kaprodi == 1) ? 'disabled' : '';?> required>              
                    </div>
                </div>
                <div class="form-group">
                    <label>Ruang</label>
                    <select name="id_ruang" class="form-control select2" style="width: 100%;" <?= ($status_apv_kaprodi == 1) ? 'disabled' : '';?> required>
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
                    <select name="id_jam" class="form-control select2" style="width: 100%;" <?= ($status_apv_kaprodi == 1) ? 'disabled' : '';?> required>
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
                <?php
                if($link_zoom != ''){
                    echo '
                    <div class="form-group">
                        <label>Link Zoom</label>
                        <br>
                        <a href="'.$link_zoom.'" target="_blank">'.$link_zoom.'</a>
                    </div>';   
                }
                ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?php
                if ($ujian) {
                    if ($status_apv_kaprodi == '1') {
                        ?>
                        <p align="center"><b><i class="fa fa-check text-green"></i> Sudah Diverifikasi Kaprodi</b></p>
                        <!--
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Ubah Ruang</button>
                        -->
                        <?php
                    } else {
                        ?>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan Jadwal</button>
                        <?php
                    }
                    ?>
                <?php
                } else {
                    ?>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan Jadwal</button>
                    <?php
                }
                ?>
            </div>
            <?php echo form_close() ?>
        </div>
        <!-- /.box -->
    </div>
    <!-- left column -->
    <?php 
    if($tesis->nip_pembimbing_satu == $this->session_data['username']){
    ?>
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">2. Dosen Penguji</h3>
                </div>
                <?php echo form_open('dosen/tesis/proposal/penguji_usulan_save'); ?>
                <div class="box-body table-responsive">
                    <?php
                    if ($ujian) {
                        ?>
                        <div class="form-group">
                            <label>Penguji</label>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                            <?php //echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
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
                        <?php $this->view('backend/widgets/tesis/list_penguji_dosen_temp', ['tesis' => $tesis, 'asal_pengusul' => '1']); ?>
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
    <?php
    }
    ?>
</div>