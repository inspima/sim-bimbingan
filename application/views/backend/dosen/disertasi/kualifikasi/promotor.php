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
<div class="box">

    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Judul</th>
                    <th>Departemen</th>
                    <th class="text-center">Promotor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($disertasi as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?></td>
                        <td>
                            <?php
                            echo $list['judul']
                            ?>
                        </td>                            
                        <td><?php echo $list['departemen'] ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_promotor', ['id_disertasi' => $list['id_disertasi']]); ?>                            
                        </td>
                        <td>
                            <?php
                            $promotor = $this->disertasi->get_status_promotor($list['id_disertasi'], $this->session_data['username']);
                            if (!empty($promotor)) {
                                if ($promotor->status_tim == '1') {
                                    ?>
                                    <a href="<?= base_url() ?>dosen/disertasi/proposal/setting/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Ujian & Penguji</a>
                                    <?php
                                }
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