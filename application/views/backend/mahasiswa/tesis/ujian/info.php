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
    <div class="col-sm-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Informasi Jadwal</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <?php $this->view('backend/widgets/tesis/informasi_jadwal_ujian', ['jadwal' => $jadwal]); ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- left column -->
</div>
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Dosen Penguji</h3>
            </div>
            <div class="box-body table-responsive">
                <?php $this->view('backend/widgets/tesis/list_penguji', ['jadwal' => $jadwal]); ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Status Ujian</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <p>
                        <?php
                        echo $this->tesis->get_status_ujian($tesis->status_ujian_tesis, 1);
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /.box -->
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Nilai Ujian</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <p>
                        <?php
                        if ($jadwal) {
                            $nilai_ujian = $jadwal->nilai_ujian ? number_format($jadwal->nilai_ujian,1) : 0;
                            ?>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><b>Nilai Ujian</b></td>
                                        <td><?= $nilai_ujian?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>