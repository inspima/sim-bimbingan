<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $title ?></h3>
                <div class="pull-right">
                    <a class="btn btn-xs btn-primary" href="<?= base_url() ?>dashboarda/master/user/add_pegawai">
                        <i class="fa fa-plus"></i> Tambah Pegawai
                    </a>
                    <a class="btn btn-xs btn-primary" href="<?= base_url() ?>dashboarda/master/user/add_dosen">
                        <i class="fa fa-plus"></i> Tambah Dosen
                    </a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Sebagai</th>
                            <th>Role (Khusus Tendik)</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($user as $list) {
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $list['username'] ?></td>
                                <td><?= $list['nama'] ?></td>
                                <td>
                                    <?php
                                    if ($list['sebagai'] == '1') { // dosen
                                        echo 'dosen';
                                    } else
                                    if ($list['sebagai'] == '2') { // tendik
                                        echo 'tendik';
                                    } else
                                    if ($list['sebagai'] == '3') { // mahasiswa
                                        echo 'mahasiswa';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($list['role'] == '0') { // selain tendik
                                        echo '';
                                    } else
                                    if ($list['role'] == '1') { // Admin
                                        echo 'Admin';
                                    } else
                                    if ($list['role'] == '2') { // BAA
                                        echo 'BAA';
                                    }
                                    ?>
                                </td> 
                                <td>
                                    <?php
                                    if ($list['status'] == '0') {
                                        echo 'Tidak Aktif';
                                    } else
                                    if ($list['status'] == '1') {
                                        echo 'Aktif';
                                    }
                                    ?>
                                </td>
                                <td> 
                                    <?php
                                    echo form_open('dashboarda/master/user/direct_login');
                                    echo formtext('hidden', 'hand', 'center19', 'required');
                                    echo formtext('hidden', 'username', $list['username'], 'required');
                                    ?>
                                    <button type="submit" class="btn btn-xs btn-primary pull-left" style="margin-right:3px;"><i class="fa fa-play"></i> Login</button>
                                    <?php
                                    echo form_close();
                                    ?>

                                    <a class="btn btn-xs btn-warning pull-left" href="<?= base_url() ?>dashboarda/master/user/detail/<?= $list['id_user'] ?>">
                                        <i class="fa fa-edit"></i> Detail</a>
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