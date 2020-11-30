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

                    <th>Ujian</th>

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

                        <td>

                        	<a href = "<?= base_url() ?>dosen/tesis/proposal/setting/<?= $list['id_tesis'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-edit"></i> Ujian & Penguji</a>

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