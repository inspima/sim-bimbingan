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
<?php $this->view('backend/widgets/disertasi/tab_link_persetujuan_dosen'); ?>
<div class="divider10"></div>
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_KUALIFIKASI]); ?>
<div class="box">
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="datatable-export" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Disertasi</th>
                    <th>Tgl.Pengajuan</th>
                    <th class="text-center">Penguji</th>
                    <th class="text-center">Jadwal</th>
                    <th class="text-center">Opsi</th>
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
                            <?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?>
                            <br/>
                            <b>Judul</b> <br/>
                            <?php
                            echo $list['judul']
                            ?>
                        </td>
                        <td><?php echo toindo($list['tgl_pengajuan']) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_penguji', ['id_disertasi' => $list['id_disertasi'], 'jenis' => UJIAN_DISERTASI_KUALIFIKASI]); ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_jadwal', ['id_disertasi' => $list['id_disertasi'], 'jenis' => UJIAN_DISERTASI_KUALIFIKASI]); ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => UJIAN_DISERTASI_KUALIFIKASI]); ?>
                            <?php
                            if ($list['status_kualifikasi'] == STATUS_DISERTASI_KUALIFIKASI_SETUJUI_PENGUJI && $struktural->id_struktur == STRUKTUR_SPS) {
                                ?>
                                <br/><br/>
                                <?php echo form_open('dosen/disertasi/kualifikasi/terima') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses Setujui</button>
                                <?php echo form_close() ?>
                                <?php
                            } else if ($list['status_kualifikasi'] == STATUS_DISERTASI_KUALIFIKASI_SETUJUI_SPS && $struktural->id_struktur == STRUKTUR_KPS_S3) {
                                ?>
                                <br/><br/>
                                <?php echo form_open('dosen/disertasi/kualifikasi/terima') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses Setujui</button>
                                <?php echo form_close() ?>
                                <?php
                            }

                            if ($list['status_kualifikasi'] > STATUS_DISERTASI_KUALIFIKASI_SETUJUI_KPS && $struktural->id_struktur == STRUKTUR_KPS_S3) {
                                ?>
                                <hr style = "margin: 10px;border-width:2px;" />
                                <a href = "<?= base_url() ?>dosen/disertasi/kualifikasi/promotor/<?= $list['id_disertasi'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-edit"></i> Promotor / Ko-Promotor</a>
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