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
                <?php //$this->view('backend/widgets/tesis/informasi_tesis_judul', ['tesis' => $tesis]); ?>
                <?php 
                    $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_PROPOSAL);
                    echo '<b>Judul : </b>'.$judul->judul.'<br>';
                    
                    if($tesis->berkas_orisinalitas != '') {
                        echo '<b>Berkas Orisinalitas : </b><a href="'.base_url().'assets/upload/mahasiswa/tesis/judul/'.$tesis->berkas_orisinalitas.'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a><br>';
                    }
                ?>
                <hr>
                <b>Dosen Pembimbing</b><br><br>
                <table class="table table-condensed ">
                    <tr class="bg-gray-light">
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td><?php echo $tesis->nama_pembimbing_satu ?><br/><b><?php echo $tesis->nip_pembimbing_satu ?></b></td>
                        <td><button class="btn btn-xs bg-blue-gradient" style="color:white">Pembimbing Utama</button>
                        </td>
                        <td>
                            <?php
                            if ($tesis->status_pembimbing_satu == NULL) {
                                ?>
                                <button type="submit" class="btn btn-xs btn-warning"> Belum disetujui</button>
                                <?php
                            } else
                            if ($tesis->status_pembimbing_satu == '1') {
                                ?>
                                <button type="submit" class="btn btn-xs btn-success"> Disetujui</button>
                                <?php
                            } else
                            if ($tesis->status_pembimbing_satu == '2') {
                                ?>
                                <button type="submit" class="btn btn-xs btn-danger"> Ditolak</button>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $tesis->nama_pembimbing_dua ?><br/><b><?php echo $tesis->nip_pembimbing_dua ?></b></td>
                        <td><button class="btn btn-xs bg-blue-gradient" style="color:white">Pembimbing Kedua</button>
                        </td>
                        <td>
                            <?php
                            if ($tesis->status_pembimbing_dua == NULL) {
                                ?>
                                <button type="submit" class="btn btn-xs btn-warning"> Belum disetujui</button>
                                <?php
                            } else
                            if ($tesis->status_pembimbing_dua == '1') {
                                ?>
                                <button type="submit" class="btn btn-xs btn-success"> Disetujui</button>
                                <?php
                            } else
                            if ($tesis->status_pembimbing_dua == '2') {
                                ?>
                                <button type="submit" class="btn btn-xs btn-danger"> Ditolak</button>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
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
            <?php echo form_open('mahasiswa/tesis/ujian/jadwal_save'); ?>
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
                if ($ujian) {
                    if ($ujian->status_apv_kaprodi == '1') {
                        ?>
                        <p align="center">
                            <b><i class="fa fa-check text-green"></i> Sudah Diverifikasi Kaprodi</b>
                            <br>Jika Ingin Reschedule silahkan menghubungi KPS
                        </p>
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
</div>