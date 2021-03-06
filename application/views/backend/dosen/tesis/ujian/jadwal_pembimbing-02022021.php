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
                <?php $this->view('backend/widgets/tesis/informasi_tesis_judul', ['tesis' => $tesis]); ?>
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
            <?php echo form_open('dosen/tesis/ujian/jadwal_pembimbing_save'); ?>
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
                        } else {
                            $id_ujian = '';
                            $tanggal = '';
                            $id_ruang = '';
                            $ruang = '-Pilih Ruang-';
                            $id_jam = '';
                            $jam = '-Pilih Jam-';
                            $status_apv_kaprodi = '';
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
                <?php echo form_open('dosen/tesis/ujian/penguji_usulan_save'); ?>
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