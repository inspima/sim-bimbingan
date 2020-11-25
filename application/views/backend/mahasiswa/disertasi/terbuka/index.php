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
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_TERBUKA]); ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Tabel <?= $subtitle ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Berkas</th>
                    <th>Tanggal Pengajuan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Info</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($disertasi as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php
                            $judul = $this->disertasi->read_judul($list['id_disertasi']);
                            echo $judul->judul;
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/terbuka/<?php echo $list['berkas_terbuka'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                        </td>
                        <td><?= date('Y-m-d', strtotime($list['waktu_pengajuan_terbuka'])) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_TERBUKA]); ?>
                            <?php if ($list['status_terbuka'] > STATUS_DISERTASI_TERBUKA_UJIAN) {
                                ?>
                                <hr class="divider-line-thin"/>
                                <b>Hasil Ujian</b><br/>
                                <?php
                                echo $this->disertasi->get_status_ujian($list['status_ujian_terbuka'], UJIAN_DISERTASI_TERBUKA);
                                if ($list['status_ujian_terbuka']) {
                                    ?>
                                <br/>
                                    <hr class="divider-line-thin"/>
                                    <a class="btn btn-app">
                                        <i class="fa fa-graduation-cap text-green"></i> Selamat
                                    </a>
                                    <?php
                                }
                            }
                            ?>

                        </td>
                        <td class="text-center">
                            <?php if ($list['status_terbuka'] > STATUS_DISERTASI_TERBUKA_SETUJUI_PENGUJI) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/disertasi/terbuka/info/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Detail</a>
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