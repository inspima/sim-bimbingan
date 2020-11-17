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
    <a class="btn btn-default" href="<?php echo base_url() ?>dosen/disertasi/kualifikasi/penguji">Kualifikasi</a>
    <a class="btn btn-primary" href="<?php echo base_url() ?>dosen/disertasi/proposal/penguji">Proposal</a>
    <a class="btn btn-success" href="<?php echo base_url() ?>dosen/disertasi/kelayakan/penguji">Kelayakan</a>
    <a class="btn btn-danger" href="<?php echo base_url() ?>dosen/disertasi/ujian/penguji">Penguji</a>
</div>
<hr style="margin: 10px"/>
<?php $this->view('backend/widgets/disertasi/status_kualifikasi'); ?>
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
                    <th class="text-center">Penguji</th>
                    <th class="text-center">Jadwal</th>
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
                            echo $list['judul']
                            ?>
                        </td>                            
                        <td><?php echo $list['departemen'] ?></td>
                        <td><?php echo toindo($list['tgl_pengajuan']) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_penguji', ['id_disertasi' => $list['id_disertasi']]); ?>                            
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_jadwal', ['id_disertasi' => $list['id_disertasi']]); ?>
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
                            } else if ($list['status_kualifikasi'] == '2') {
                                ?>
                                <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima</span>
                                <?php
                            } else if ($list['status_kualifikasi'] == '3') {
                                ?>
                                <span class="btn btn-xs bg-navy"><i class="fa fa-check"></i> Dijadwalkan</span>
                                <?php
                            } else if ($list['status_kualifikasi'] == '4') {
                                ?>
                                <span class="btn btn-xs bg-purple"><i class="fa fa-check"></i> Ujian</span>
                                <?php
                            } else {
                                ?>
                                <span class="btn btn-xs bg-red"><i class="fa fa-check"></i> Selesai</span>
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