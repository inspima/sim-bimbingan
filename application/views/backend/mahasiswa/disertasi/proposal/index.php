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
    <div class="box-header">
        <h3 class="box-title"><?= $subtitle ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Berkas</th>
                    <th>Departemen</th>
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
                            <a href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                        </td>
                        <td><?= $list['departemen'] ?></td>
                        <td><?= date('Y-m-d', strtotime($list['waktu_pengajuan_proposal'])) ?></td>
                        <td class="text-center">
                            <?php if ($list['status_proposal'] == '1') {
                                ?>
                                <span class="btn btn-xs bg-blue"><i class="fa fa-check"></i> Pengajuan</span><br/>
                                <?php
                            } else if ($list['status_proposal'] == '2') {
                                ?>
                                <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima</span>
                                <?php
                            } else if ($list['status_proposal'] == '3') {
                                ?>
                                <span class="btn btn-xs bg-navy"><i class="fa fa-check"></i> Dijadwalkan</span>
                                <?php
                            } else if ($list['status_proposal'] == '4') {
                                ?>
                                <span class="btn btn-xs bg-purple"><i class="fa fa-check"></i> Ujian</span>
                                <?php
                            } else {
                                ?>
                                <span class="btn btn-xs bg-red"><i class="fa fa-check"></i> Selesai</span>
                                <hr style="margin:5px"/>
                                <?php
                                echo $this->disertasi->get_status_ujian($list['status_ujian_kualifikasi'], 1);
                                ?>
                                <?php
                            }
                            ?>

                        </td>
                        <td class="text-center">
                            <?php if ($list['status_proposal'] > 0) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/disertasi/proposal/info/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Detail</a>
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