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
    <div class="col-sm-12">
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
                                $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_JUDUL);
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
                                        if($tesis->nip_pembimbing_satu == $this->session_data['username']){
                                            if ($bt['status_apv_pembimbing_satu'] == '1') {
                                            ?>
                                                <a class="btn btn-xs btn-success"> Disetujui Pembimbing Utama</a>
                                                <a href="<?= base_url() ?>dosen/tesis/permintaan/batal_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>/1/<?= UJIAN_TESIS_PROPOSAL ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn btn-xs btn-danger"> Batal</a>
                                            <?php
                                            }
                                            else if ($bt['status_apv_pembimbing_satu'] == '2') {
                                            ?>
                                                <a class="btn btn-xs btn-danger"> Ditolak Pembimbing Utama</a>
                                                <a href="<?= base_url() ?>dosen/tesis/permintaan/batal_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>/1/<?= UJIAN_TESIS_PROPOSAL ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn btn-xs btn-danger"> Batal</a>
                                            <?php
                                            }
                                            else {
                                            ?>
                                                <a href="<?= base_url() ?>dosen/tesis/permintaan/approve_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>/1/<?= UJIAN_TESIS_PROPOSAL ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn btn-xs btn-success"> Terima</a>
                                                <a href="<?= base_url() ?>dosen/tesis/permintaan/tolak_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>/1/<?= UJIAN_TESIS_PROPOSAL ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn btn-xs btn-danger"> Tolak</a>
                                            <?php
                                            }
                                        }
                                        if($tesis->nip_pembimbing_dua == $this->session_data['username']){
                                            if ($bt['status_apv_pembimbing_dua'] == '1') {
                                            ?>
                                                <a class="btn btn-xs btn-success"> Disetujui Pembimbing Kedua</a><br><br>
                                                <a href="<?= base_url() ?>dosen/tesis/permintaan/batal_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>/2/<?= UJIAN_TESIS_PROPOSAL ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn btn-xs btn-danger"> Batal</a>
                                            <?php
                                            }
                                            else if ($bt['status_apv_pembimbing_dua'] == '2') {
                                            ?>
                                                <a class="btn btn-xs btn-danger"> Ditolak Pembimbing Kedua</a><br><br>
                                                <a href="<?= base_url() ?>dosen/tesis/permintaan/batal_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>/2/<?= UJIAN_TESIS_PROPOSAL ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn btn-xs btn-danger"> Batal</a>
                                            <?php
                                            }
                                            else {
                                            ?>
                                                <a href="<?= base_url() ?>dosen/tesis/permintaan/approve_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>/2/<?= UJIAN_TESIS_PROPOSAL ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn btn-xs btn-success"> Terima</a>
                                                <a href="<?= base_url() ?>dosen/tesis/permintaan/tolak_bimbingan/<?= $bt['id_tesis'] ?>/<?= $bt['id_bimbingan_tesis'] ?>/2/<?= UJIAN_TESIS_PROPOSAL ?>" onclick="return confirm('Apakah anda yakin ?')" class="btn btn-xs btn-danger"> Tolak</a>
                                            <?php
                                            }
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