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
                    $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_JUDUL);
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
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart('mahasiswa/tesis/proposal/bimbingan_save');?>
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
                        <?php $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_JUDUL);?>
                        <textarea class="form-control" name="hal" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>File Bimbingan Proposal Tesis<br/>(format file .pdf maks 2MB)</label>
                        <input type="file" name="berkas_bimbingan_proposal" class="form-control" >
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <a class="btn btn-sm btn-warning" href="<?= base_url()?>mahasiswa/tesis/proposal"><i class="fa fa-close"></i> Batal</a>
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
                                <th>Status Approval Pembimbing</th>
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
                                            <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/proposal/bimbingan/<?php echo $bt['file'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($bt['status_apv_pembimbing_satu'] == '1') {
                                            ?>
                                            <a class="btn btn-xs btn-success"> Disetujui Pembimbing Utama</a>
                                            <?php
                                        }
                                        if ($bt['status_apv_pembimbing_dua'] == '1') {
                                            ?>
                                            <a class="btn btn-xs btn-success"> Disetujui Pembimbing Kedua</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($bt['status_apv_pembimbing_satu'] == '0' && $bt['status_apv_pembimbing_dua'] == '0') {
                                        ?>
                                            <a href="<?= base_url() ?>mahasiswa/tesis/proposal/delete_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn bg-red"><i class="fa fa-trash"></i> Hapus</a>
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