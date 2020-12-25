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
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => '1']); ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Tabel <?= $subtitle ?></h3>
        <div class="pull-right">
            <a class="btn btn-primary" href="<?= base_url() ?>mahasiswa/disertasi/kualifikasi/add">
                <i class="fa fa-plus"></i> TAMBAH</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penasehat Akademik</th>
                    <th class="text-center">Berkas</th>
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
                        <td><?php echo $list['nama_penasehat'] ?><br/><b><?php echo $list['nip_penasehat'] ?></b></td>
                        <td class="text-center">
                            <a href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/kualifikasi/<?php echo $list['berkas_kualifikasi'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                        </td>
                        <td><?= date('Y-m-d', strtotime($list['tgl_pengajuan'])) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => 1]); ?>

                            <?php if ($list['status_kualifikasi'] > STATUS_DISERTASI_KUALIFIKASI_SELESAI) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian</b><br/>
                                <?php
                                echo $this->disertasi->get_status_ujian($list['status_ujian_kualifikasi'], UJIAN_DISERTASI_KUALIFIKASI);


                                if ($list['status_promotor'] < STATUS_DISERTASI_PROMOTOR_PENGAJUAN) {
                                    ?>
                                    <hr style = "margin: 10px;border-width:2px;" />
                                    <a href = "<?= base_url() ?>mahasiswa/disertasi/promotor/info/<?= $list['id_disertasi'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-edit"></i> Promotor / Ko-Promotor</a>
                                    <?php
                                }
                            }
                            ?>

                        </td>
                        <td class="text-center">
                            <?php if ($list['status_kualifikasi'] > STATUS_DISERTASI_KUALIFIKASI_DIJADWALKAN) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/disertasi/kualifikasi/info/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Detail</a>
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
