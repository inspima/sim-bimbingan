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
<div class="box">
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Info Tesis</th>
                    <th class="text-center">Berkas Proposal</th>
                    <th>Tgl.Pengajuan</th>
                    <th>Keterangan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Status Pembimbing</th>                    
                    <th>Opsi</th>
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
                        <td class="text-center">
                            <a href="<?php echo base_url()?>assets/upload/tesis/proposal/<?php echo $list['berkas_proposal']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>
                        </td>
                        <td><?php echo toindo($list['tgl_pengajuan']) ?></td>
                        <td>
                            <?php
                            if ($list['nip_pembimbing_satu'] == $this->session_data['username']){
                                echo 'Pembimbing Satu';
                            }   
                            if ($list['nip_pembimbing_dua'] == $this->session_data['username']){
                                echo 'Pembimbing Dua';
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
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            if($list['nip_pembimbing_satu'] == $this->session_data['username']){
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
                            }
                            else if($list['nip_pembimbing_dua'] == $this->session_data['username']){
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
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if($list['nip_pembimbing_satu'] == $this->session_data['username']){
                                if($list['status_pembimbing_satu'] == NULL) {
                                ?>
                                    <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/proposal/approve_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Approve</a>
                                    <a class="btn btn-xs btn-danger pull-left" href="<?= base_url()?>dosen/tesis/proposal/reject_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Reject</a>
                                <?php
                                } else {
                                ?>
                                    <a class="btn btn-xs btn-warning pull-left" href="<?= base_url()?>dosen/tesis/proposal/reject_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Batal</a>
                                <?php
                                } 
                            } else if($list['nip_pembimbing_dua'] == $this->session_data['username']){
                                if($list['status_pembimbing_dua'] == NULL) {
                                ?>
                                    <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/proposal/approve_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Approve</a>
                                    <!--
                                    <a class="btn btn-xs btn-warning pull-left" href="<?php //echo base_url()?>dosen/tesis/proposal/reject_pembimbing/<?php //echo $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Reject</a>
                                    -->
                                <?php
                                } else {
                                ?>
                                    <a class="btn btn-xs btn-warning pull-left" href="<?= base_url()?>dosen/tesis/proposal/batal_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Batal</a>
                                <?php
                                }
                            }
                            ?>


                        </td>

                        <td>

                            <?php
                            if ($list['nip_pembimbing_satu'] == $this->session_data['username']){
                                if($list['status_pembimbing_dua'] == '1') {
                                    echo '<a href = "'.base_url().'dosen/tesis/proposal/setting_penguji/'.$list['id_tesis'].'" class = "btn btn-xs bg-blue"><i class = "fa fa-edit"></i> Setting Penguji</a>';
                                }
                            }   
                            if ($list['nip_pembimbing_dua'] == $this->session_data['username']){
                                echo '';
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