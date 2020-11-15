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
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $subtitle ?></h3>
                <div class="pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <div class="btn-group">
                    <a class="btn btn-info" href="<?php echo base_url() ?>sarjanah/skripsi/index">Belum Daftar</a>
                    <a class="btn btn-primary" href="<?php echo base_url() ?>sarjanah/skripsi/pengajuan">Pengajuan</a>
                    <a class="btn btn-success" href="<?php echo base_url() ?>sarjanah/skripsi/diterima">Diterima</a>
                    <a class="btn btn-danger" href="<?php echo base_url() ?>sarjanah/skripsi/ujian">Ujian</a>
                    <a class="btn btn-default" href="<?php echo base_url() ?>sarjanah/skripsi/belum_approve">Penguji - Belum Approve</a>
                </div>
                <hr/>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penguji</th>
                            <th>Nama</th>
                            <th>Judul</th>
                            <th>Jadwal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($penguji as $list) {
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?php echo $list['nama_dosen'] ?></td>
                                <td><?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?></td>
                                <td>
                                    <?php
                                    $judul = $this->penguji->read_judul($list['id_skripsi']);
                                    echo $judul->judul;
                                    ?>
                                </td>                            
                                <td>
                                    <?php
                                    $ujian = $this->penguji->read_ujian($list['id_skripsi']);
                                    if ($ujian) {
                                        echo '<strong>Tanggal</strong> :<br>' . toindo($ujian->tanggal) . '<br>';
                                        echo '<strong>Ruang</strong>  :<br>' . $ujian->ruang . ' ' . $ujian->gedung . '<br>';
                                        echo '<strong>Jam</strong>     :<br>' . $ujian->jam;
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </td>
                            </tr>      
                                    <?php
                                    $no++;
                                }
                                ?>
                        </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>