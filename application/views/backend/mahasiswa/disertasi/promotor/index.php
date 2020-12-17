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
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_PROMOTOR]); ?>
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
                    <th>Penasehat Akademik</th>
                    <th class="text-center">Promotor & Ko-Promotor</th>
                    <th class="text-center">Status</th>
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
                            <?php $this->view('backend/widgets/disertasi/column_promotor_mhs', ['id_disertasi' => $list['id_disertasi']]); ?>

                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_PROMOTOR]); ?>                            
                            <div class="divider5"></div>
                            <hr class="divider-line-thin"/>
                            <div class="divider5"></div>
                            <?php if ($list['status_mpkk'] < STATUS_DISERTASI_MPKK_PENGAJUAN && $list['status_promotor'] >= STATUS_DISERTASI_PROMOTOR_SELESAI):
                                ?>
                                <a href = "<?= base_url() ?>mahasiswa/disertasi/mpkk/add/<?= $list['id_disertasi'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-mail-forward"></i> Ajukan MKPKK</a>
                                <?php
                            endif;
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