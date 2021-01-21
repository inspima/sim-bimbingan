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
<?php //$this->view('backend/widgets/tesis/tab_link_program_studi'); ?>

<div class="divider10"></div>
<?php //$this->view('backend/widgets/tesis/tab_link_persetujuan_dosen'); ?>
<!--<div class="divider10"></div>-->
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_PROPOSAL]); ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Tabel <?= $subtitle ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="datatable-export" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tesis</th>
                    <th>Tgl.Pengajuan</th>
                    <th>Pembimbing Utama</th>
                    <th>Pembimbing Kedua</th>
                    <th class="text-center">Berkas Ujian Proposal Tesis</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Opsi</th>
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
                        <td>
                            <?php 
                            if($list['nip_pembimbing_satu'] != NULL) {
                                echo $list['nama_pembimbing_satu'].'<br/>'; 
                                echo '<b>'.$list['nip_pembimbing_satu'].'</b><br/>';
                                if($list['status_pembimbing_satu'] == NULL) {
                                    echo '<a class="btn btn-xs btn-primary pull-left" href="#">
                                    <i class="fa fa-check"></i> Pengajuan</a>';
                                } 
                                else if($list['status_pembimbing_satu'] == '1') {
                                    echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Diterima</a>';
                                } 
                                else if($list['status_pembimbing_satu'] == '2') {
                                    echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Ditolak</a>';
                                }
                            }
                            else {
                                echo '<a class="btn btn-xs btn-warning pull-left" href="#">
                                <i class="fa fa-clock-o"></i> Belum Ditentukan</a>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if($list['nip_pembimbing_dua'] != NULL) {
                                echo $list['nama_pembimbing_dua'].'<br/>'; 
                                echo '<b>'.$list['nip_pembimbing_dua'].'</b><br/>';
                                if($list['status_pembimbing_satu'] == NULL) {
                                    echo '<a class="btn btn-xs btn-primary pull-left" href="#">
                                    <i class="fa fa-check"></i> Pengajuan</a>';
                                } 
                                else if($list['status_pembimbing_dua'] == '1') {
                                    echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Diterima</a>';
                                } 
                                else if($list['status_pembimbing_dua'] == '2') {
                                    echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Ditolak</a>';
                                }
                            }
                            else {
                                echo '<a class="btn btn-xs btn-warning pull-left" href="#">
                                <i class="fa fa-clock-o"></i> Belum Ditentukan</a>';
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
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL]); ?>
                            <?php if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_UJIAN) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_proposal'], UJIAN_TESIS_PROPOSAL);
                                ?>
                                <?php if ($list['status_tesis'] < STATUS_TESIS_UJIAN_PENGAJUAN && $list['status_proposal'] > STATUS_TESIS_PROPOSAL_UJIAN_SELESAI):
                                    ?>
                                    <hr style = "margin:5px"/>
                                    <a href = "<?= base_url() ?>mahasiswa/tesis/ujian/add/<?= $list['id_tesis'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-mail-forward"></i> Ajukan Tesis</a>
                                    <?php
                                endif;
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if($list['status_proposal'] == STATUS_TESIS_PROPOSAL_PENGAJUAN)
                            {
                            ?>
                                <?php
                                if ($list['nip_pembimbing_satu'] == '') {
                                ?>
                                    <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/proposal/setting_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Setting Pembimbing Utama</a><br>
                                <?php
                                }
                                else if ($list['status_pembimbing_satu'] == '1' && $list['status_pembimbing_dua'] == '1') {
                                ?>
                                    <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/proposal/approve/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Approve</a><br>
                                <?php
                                }
                                else {
                                ?>
                                    <a class="btn btn-xs btn-danger pull-left">Menunggu Persetujuan Pembimbing</a><br>
                                <?php
                                }
                            ?>
                            <?php
                            }
                            else if($list['status_proposal'] == STATUS_TESIS_PROPOSAL_SETUJUI_SPS) {
                            ?>
                                <a class="btn btn-xs btn-warning pull-left" href="<?= base_url()?>dosen/tesis/proposal/batal/<?= $list['id_tesis']?>">
                                <i class="fa fa-edit"></i> Batal</a><br>
                            <?php
                            }
                            ?>
                            <!--
                            <a class="btn btn-xs btn-danger pull-left" href="<?php //echo base_url()?>dosen/tesis/proposal/reject/<?php //echo $list['id_tesis']?>">
                            <i class="fa fa-edit"></i> Reject</a>
                            -->
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