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

<?php $this->view('backend/widgets/status_disertasi_kualifikasi'); ?>
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
                    <th>Tgl.Pengajuan</th>
                    <th>Penguji</th>
                    <th>Jadwal</th>
                    <th>Opsi</th>
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
                            $judul = $this->disertasi->read_judul($list['id_disertasi']);
                            echo $judul->judul;
                            ?>
                        </td>                            
                        <td><?php echo $list['departemen'] ?></td>
                        <td><?php echo toindo($list['tgl_pengajuan']) ?></td>
                        <td class="text-center">
                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">
                            <?php if ($list['status_kualifikasi'] == '1') {
                                ?>
                                <?php echo form_open('dosen/disertasi/kualifikasi/terima') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <button class="btn btn-xs btn-success pull-left"><i class="fa fa-check"></i> Setujui</button>
                                <?php echo form_close() ?>
                                <?php
                            } else {
                                ?>
                                <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima</span>
                                <br/><br/>
                                <a href="<?= base_url() ?>dosen/disertasi/kualifikasi/setting/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Jadwal & Penguji</a>
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