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
                <h3 class="box-title"> Jadwal</h3>
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
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Dosen Penguji</h3>
            </div>
            <div class="box-body table-responsive">
                <?php $this->view('backend/widgets/tesis/list_penguji', ['tesis' => $tesis,'jadwal' => $jadwal]); ?>
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
                    <label>Status Ujian</label>
                    <p>
                        <?php
                        echo $this->tesis->get_status_ujian($tesis->status_ujian_proposal, 1);
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>