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
<?php $this->view('backend/widgets/tesis/tab_link_prodi'); ?>
<div class="divider10"></div>
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_JUDUL]); ?>
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
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tesis</th>
                            <th>Tgl.Pengajuan</th>
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
                                    <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, TAHAPAN_TESIS_JUDUL]); ?>
                                    <?php
                                    if ($list['status_judul'] == STATUS_TESIS_JUDUL_SETUJUI_PEMBIMBING) {
                                    ?>
                                        <hr style="margin: 5px"/>
                                        <!-- Surat Tugas -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('prodi/magister/tesis/judul/cetak_surat_tugas_pembimbing', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                        <input type="text" name="no_surat" class="form-control" required placeholder="NOMOR SURAT">
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Surat Tugas</button>
                                        <?php echo form_close() ?>
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
    </div>
    <!-- /.col -->
</div>