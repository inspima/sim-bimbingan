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
<?php $this->view('backend/widgets/disertasi/status_kualifikasi'); ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?= $subtitle ?></h3>
        <div class="pull-right">
            <a class="btn btn-primary" href="<?= base_url() ?>mahasiswa/disertasi/kualifikasi/add">
                <i class="fa fa-plus"></i> TAMBAH</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Departemen</th>
                    <th>Tanggal Pengajuan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Info</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($disertasi as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php
                            $judul = $this->disertasi->read_judul($list['id_disertasi']);
                            echo $judul->judul;
                            ?>
                        </td>
                        <td><?= $list['departemen'] ?></td>
                        <td><?= date('Y-m-d', strtotime($list['tgl_pengajuan'])) ?></td>
                        <td class="text-center">
                            <?php
                            if ($list['status_kualifikasi'] == '1') {
                                ?>
                                <a class="btn btn-xs btn-primary " href="#">
                                    <i class="fa fa-check"></i> Pengajuan
                                </a>
                                <?php
                            } else
                            if ($list['status_kualifikasi'] == '2') {
                                ?>
                                <a class="btn btn-xs btn-success " href="#">
                                    <i class="fa fa-check"></i> Diterima
                                </a>
                                <?php
                            } else
                            if ($list['status_kualifikasi'] == '3') {
                                ?>
                                <a class="btn btn-xs btn-success " href="#">
                                    <i class="fa fa-check"></i> Selesai
                                </a>
                                <?php
                            } else
                            if ($list['status_kualifikasi'] == '4') {
                                ?>
                                <a class="btn btn-xs btn-danger " href="#">
                                    <i class="fa fa-check"></i> Ditolak
                                </a>
                                <?php
                            }
                            ?>

                        </td>
                        <td class="text-center">
                            <?php if ($list['status_kualifikasi'] != '1') {
                                ?>
                                <a class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Jadwal & Penguji</a>
                                <?php
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