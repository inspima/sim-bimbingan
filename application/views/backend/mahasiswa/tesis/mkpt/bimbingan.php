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
                <?php 
                    $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_MKPT);

                    $mkpt_data = $this->tesis->get_tesis_mkpt_dan_pengampu_by_id_tesis($tesis->id_tesis);
                    
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

                <hr>
                <b>Dosen Pengampu MKPT</b><br><br>
                <table class="table table-condensed ">
                    <tr class="bg-gray-light">
                        <th>Nama</th>
                        <th>MKPT</th>
                        <th>SKS</th>
                    </tr>
                    <?php
                    foreach ($mkpt_data as $item_mkpt_data) {
                    ?>
                    <tr>
                        <td><?php echo $item_mkpt_data['nama'] ?><br/><b><?php echo $item_mkpt_data['nip'] ?></b></td>
                        <td><?php echo $item_mkpt_data['mkpt'] ?></td>
                        <td><?php echo $item_mkpt_data['sks'] ?></td>
                    </tr>
                    <?php }
                    ?>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart('mahasiswa/tesis/mkpt/bimbingan_save');?>
                <div class="box-body">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-group date">
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="tgl_bimbingan" value="" class="form-control pull-right" id="datepicker" required>              
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Materi Bimbingan</label>
                        <?php $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_MKPT);?>
                        <textarea class="form-control" name="hal" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>MKPT Pengampu</label>
                        <select name="tesis_mkpt" class="form-control">
                    <?php
                    foreach ($mkpt_data as $item_mkpt_data) {
                    ?>
                        <option value="<?= $item_mkpt_data['id_tesis_mkpt'] ?>" ><?= $item_mkpt_data['nama'] ?></option>
                    <?php }
                    ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label>File Bimbingan MKPT Tesis<br/>(format file .pdf maks 2MB)</label>
                        <input type="file" name="berkas_bimbingan_mkpt" class="form-control" >
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
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Riwayat Bimbingan</h3>
            </div>
            <div class="box-body table-responsive">
                <?php
                if ($bimbingan) {
                    ?>              
                    <div class="form-group">
                        <table class="table table-condensed ">
                            <tr class="bg-gray-light">
                                <th>Tanggal</th>
                                <th>Materi Bimbingan</th>
                                <th>File</th>
                                <th>Nama Pengampu</th>
                                <th>Status Approval Pengampu</th>
                                <th></th>
                            </tr>
                            <?php
                            foreach ($bimbingan as $bt) {
                                ?>
                                <tr>
                                    <td><?php echo $bt['tanggal'] ?></td>
                                    <td><?php echo $bt['hal'] ?></td>
                                    <td>
                                        <?php
                                        if($bt['file'] != '') {
                                        ?>
                                            <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/mkpt/bimbingan/<?php echo $bt['file'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $bt['nama_pengampu'] ?></td>
                                    <td>
                                        <?php
                                        if ($bt['status_apv_pengampu'] == '1') {
                                            ?>
                                            <a class="btn btn-xs btn-success"> Disetujui Pengampu</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($bt['status_apv_pembimbing_satu'] == '0' && $bt['status_apv_pembimbing_dua'] == '0') {
                                        ?>
                                            <a href="<?= base_url() ?>mahasiswa/tesis/mkpt/delete_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn bg-red"><i class="fa fa-trash"></i> Hapus</a>
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
                        <p>Belum ada bimbingan</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>