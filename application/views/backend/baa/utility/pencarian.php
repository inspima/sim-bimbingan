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
    <div class="col-md-4">
        <!-- general form elements -->
        <div class="box box-default">
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('baa/utility/pencarian', ['method' => 'get']); ?>
            <div class="box-body">
                <div class="form-group form-inline">
                    <input type="text" class="form-control" size="28" name="search" placeholder="Masukkan Nama/NIM" required=""/>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Cari</button>
                </div>
                <?= form_close() ?>
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
<div class="box">

    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nim</th>
                    <th>Prodi</th>
                    <th>SKS</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th class="text-center">Tahapan</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($mahasiswas as $mahasiswa) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php echo $mahasiswa['nama'] ?></td>
                        <td><?php echo $mahasiswa['nim'] ?></td>
                        <td><?php echo $mahasiswa['jenjang'] ?> <?php echo $mahasiswa['nm_prodi'] ?></td>
                        <td><?php echo $mahasiswa['sks'] ?></td>
                        <td><?php echo $mahasiswa['alamat'] ?></td>
                        <td><?php echo $mahasiswa['email'] ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $mahasiswa]); ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $mahasiswa]); ?>
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