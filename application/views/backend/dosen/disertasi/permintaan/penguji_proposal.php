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
<div class="btn-group">
    <a class="btn btn-info" href="<?php echo base_url() ?>dosen/disertasi/permintaan/penguji">Kualifikasi</a>
    <a class="btn btn-default" href="<?php echo base_url() ?>dosen/disertasi/permintaan/penguji/proposal">Proposal</a>
    <a class="btn btn-success" href="<?php echo base_url() ?>dosen/disertasi/permintaan/penguji/kelayakan">Kelayakan</a>
    <a class="btn bg-orange" href="<?php echo base_url() ?>dosen/disertasi/permintaan/penguji/tertutup">Ujian Tertutup</a>
    <a class="btn btn-danger" href="<?php echo base_url() ?>dosen/disertasi/permintaan/penguji/terbuka">Ujian Terbuka</a>
</div>
<hr style="margin: 10px"/>
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_PROPOSAL]); ?>
<div class="box">

    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Informasi Disertasi</th>
                    <th class="text-center">Penguji</th>
                    <th>Tgl.Pengajuan</th>
                    <th class="text-center">Jadwal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($disertasi as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td>
                            <?php $this->view('backend/widgets/disertasi/column_info_disertasi', ['disertasi' => $list]); ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_penguji', ['id_disertasi' => $list['id_disertasi'], 'jenis' => UJIAN_DISERTASI_PROPOSAL]); ?>
                        </td>
                        <td><?php echo toindo($list['tgl_pengajuan']) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_jadwal', ['id_disertasi' => $list['id_disertasi'], 'jenis' => UJIAN_DISERTASI_PROPOSAL]); ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_PROPOSAL]); ?>
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