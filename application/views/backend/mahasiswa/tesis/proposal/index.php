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
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => '1']); ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Tabel <?= $subtitle ?></h3>
        <div class="pull-right">
            <a class="btn btn-primary" href="<?= base_url() ?>mahasiswa/tesis/proposal/add">
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
                    <th colspan="2">Pembimbing</th>
                    <th class="text-center">Berkas</th>
                    <th>Tanggal Pengajuan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Info</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($tesis as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php
                            $judul = $this->tesis->read_judul($list['id_tesis']);
                            echo $judul->judul;
                            ?>
                        </td>
                        <td>
                            <?php echo $list['nama_pembimbing_satu'] ?><br/>
                            <b><?php echo $list['nip_pembimbing_satu'] ?></b><br/>
                            <?php
                            if($list['status_pembimbing_satu'] == NULL) {
                            ?>
                                <a class="btn btn-xs btn-primary pull-left" href="#">
                                <i class="fa fa-check"></i> Pengajuan</a>
                            <?php
                            } else if($list['status_pembimbing_satu'] == '1') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>
                            <?php
                            } else if($list['status_pembimbing_satu'] == '2') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Ditolak</a>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $list['nama_pembimbing_dua'] ?><br/>
                            <b><?php echo $list['nip_pembimbing_dua'] ?></b><br/>
                            <?php
                            if($list['status_pembimbing_dua'] == NULL) {
                            ?>
                                <a class="btn btn-xs btn-primary pull-left" href="#">
                                <i class="fa fa-check"></i> Pengajuan</a>
                            <?php
                            } else if($list['status_pembimbing_dua'] == '1') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>
                            <?php
                            } else if($list['status_pembimbing_dua'] == '2') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Ditolak</a>
                            <?php
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if($list['berkas_proposal'] != '') {
                            ?>
                                <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                            <?php 
                            }
                            ?>
                        </td>
                        <td><?= date('Y-m-d', strtotime($list['tgl_pengajuan'])) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL]); ?>
                            <?php if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_UJIAN) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_proposal'], UJIAN_TESIS_PROPOSAL);
                                ?>
                                <?php if ($list['status_tesis'] < STATUS_TESIS_UJIAN_PENGAJUAN && $list['status_proposal'] == STATUS_TESIS_PROPOSAL_UJIAN_SELESAI):
                                    ?>
                                    <hr style = "margin:5px"/>
                                    <a href = "<?= base_url() ?>mahasiswa/tesis/ujian/add/<?= $list['id_tesis'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-mail-forward"></i> Ajukan Tesis</a>
                                    <?php
                                endif;
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/proposal/info/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Detail</a>
                                <?php
                            }
                            if ($list['status_pembimbing_satu'] == '' && $list['status_pembimbing_dua'] == '') {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/proposal/edit/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Edit</a>
                                <?php
                            }
                            if ($list['status_proposal'] == STATUS_TESIS_PROPOSAL_SETUJUI_SPS) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/proposal/jadwal/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Ajukan Jadwal</a>
                                <?php
                            }
                            if ($list['status_proposal'] == STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/proposal/jadwal/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Lihat Jadwal</a>
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