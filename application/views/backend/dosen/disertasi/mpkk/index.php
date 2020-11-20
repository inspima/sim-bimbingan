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
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => '2']); ?>
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
                    <th class="text-center">Berkas</th>
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
                        <td><?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?></td>
                        <td>
                            <?php
                            echo $list['judul']
                            ?>
                        </td>                            
                        <td><?php echo $list['departemen'] ?></td>
                        <td class="text-center">
                            <a href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/mpkk/<?php echo $list['berkas_mpkk'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"> </a>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => 2]); ?>
                            <?php
                            if ($list['status_mpkk'] == 1 && $struktural->id_struktur == STRUKTUR_SPS) {
                                ?>
                                <br/><br/>
                                <?php echo form_open('dosen/disertasi/mpkk/terima') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses Setujui</button>
                                <?php echo form_close() ?>
                                <?php
                            } else if ($list['status_mpkk'] == 2 && $struktural->id_struktur == STRUKTUR_KPS_S3) {
                                ?>
                                <br/><br/>
                                <?php echo form_open('dosen/disertasi/mpkk/terima') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses Setujui</button>
                                <?php echo form_close() ?>
                                <?php
                            } else if ($list['status_mpkk'] >= 4 && $struktural->id_struktur == STRUKTUR_KPS_S3) {
                                ?>
                                <br/><br/>
                                <a href="<?= base_url() ?>dosen/disertasi/mpkk/setting/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Ujian & Penguji</a>
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