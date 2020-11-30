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

                    <th>Info Tesis</th>

                    <th>Tgl.Pengajuan</th>

                    <th>Jadwal</th>

                    <th>Status</th>
                    
                    <th>Opsi</th>

                </tr>

            </thead>

            <tbody>

                <?php

                $no = 1;

                foreach ($tesis as $list) {

                    ?>

                    <tr>

                        <td><?= $no ?></td>

                        <td>
                            <?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?>
                            <br/>
                            <b>Judul</b> <br/>
                            <?php
                            echo $list['judul']
                            ?>
                        </td>

                        <td><?php echo toindo($list['tgl_pengajuan']) ?></td>

                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_jadwal', ['id_tesis' => $list['id_tesis'], 'jenis' => 1]); ?>
                        </td>

                        <td class="text-center">
                            <?php
                            if($list['status'] == '1')

                            {

                            ?>

                                <a class="btn btn-xs btn-primary pull-left" href="#">

                                <i class="fa fa-check"></i> Pengajuan</a>

                            <?php

                            }

                            else

                            if($list['status'] == '2')

                            {

                            ?>

                                <a class="btn btn-xs btn-success pull-left" href="#">

                                <i class="fa fa-check"></i> Diterima</a>

                            <?php

                            }

                            else

                            if($list['status'] == '3')

                            {

                            ?>

                                <a class="btn btn-xs btn-success pull-left" href="#">

                                <i class="fa fa-check"></i> Ditolak</a>

                            <?php

                            }
                            ?>

                        </td>

                        <td>

                            <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/proposal/approve_penguji/<?= $list['id_tesis']?>">

                            <i class="fa fa-edit"></i> Approve</a>

                            <a class="btn btn-xs btn-danger pull-left" href="<?= base_url()?>dosen/tesis/proposal/reject_penguji/<?= $list['id_tesis']?>">

                            <i class="fa fa-edit"></i> Reject</a>

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