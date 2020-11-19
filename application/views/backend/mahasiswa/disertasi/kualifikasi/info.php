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
                <h2 class="box-title">Informasi Disertasi</h2>

            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" value="<?php echo $disertasi->nim ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $disertasi->nama ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <?php
                    $judul = $this->disertasi->read_judul($disertasi->id_disertasi);
                    ?>
                    <textarea class="form-control" name="judul" readonly><?php echo $judul->judul ?></textarea>
                </div>


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
            <div class="box-body">

                <div class="form-group">
                    <label>Tanggal</label>
                    <p>
                        <i class="fa fa-calendar"></i>
                        <?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?>
                    </p>
                </div>

                <div class="form-group">
                    <label>Ruang</label>
                    <p>
                        Ruang <?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?>
                    </p>
                </div>

                <div class="form-group">
                    <label>Jam</label>
                    <p>
                        <?= substr($jadwal->jam, 0, 5); ?> - Selesai
                    </p>
                </div>
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
                <h3 class="box-title">3. Dosen Penguji</h3>
            </div>
            <div class="box-body table-responsive">
                <?php
                if ($jadwal) {
                    ?>              
                    <div class="form-group">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <th>Tim</th>
                                <th>Status</th>
                            </tr>
                            <?php
                            $penguji = $this->disertasi->read_penguji($jadwal->id_ujian);
                            $str_status_tim = '';
                            foreach ($penguji as $listpenguji) {
                                if ($listpenguji['status_tim'] == '1') {
                                    $str_status_tim = 'Ketua';
                                } else if ($listpenguji['status_tim'] == '2') {
                                    $str_status_tim = 'ANggota';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $listpenguji['nama'] ?></td>
                                    <td><?php echo $str_status_tim ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($listpenguji['status'] == '1') {
                                            ?>
                                            <a class="btn btn-xs btn-warning"> Belum Approve</a>
                                            <?php
                                        } else
                                        if ($listpenguji['status'] == '2') {
                                            ?>
                                            <a class="btn btn-xs btn-success"> Approved</a>
                                            <?php
                                        } else
                                        if ($listpenguji['status'] == '3') {
                                            ?>
                                            <a class="btn btn-xs btn-danger"> Rejected</a>
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
            <div class="box-body">
                <div class="form-group">
                    <label>Status Ujian</label>
                    <p>
                        <?php
                        echo $this->disertasi->get_status_ujian($disertasi->status_ujian_kualifikasi, 1);
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>