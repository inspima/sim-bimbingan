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
    <a class="<?= ($this->uri->segment(4) == 'index' OR $this->uri->segment(4) == '') ? 'btn btn-default' : 'btn bg-aqua'; ?>" href="<?php echo base_url() ?>dosen/tesis/proposal/index">Belum Diproses</a>
    <a class="<?= ($this->uri->segment(4) == 'disetujui') ? 'btn btn-default' : 'btn bg-yellow'; ?>" href="<?php echo base_url() ?>dosen/tesis/proposal/disetujui">Disetujui</a>
    <a class="<?= ($this->uri->segment(4) == 'ditolak') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/proposal/ditolak">Ditolak</a>
</div>
<?php //$this->view('backend/widgets/tesis/tab_link_program_studi'); ?>
<!--
<div class="btn-group">
    <?php 
    /*foreach($prodi as $data){
    $id = $this->uri->segment(5) ? $this->uri->segment(5) : $max_id_prodi;
    ?>
        <a class="<?= ($id == $data['id_prodi']) ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/proposal/index/<?= $data['id_prodi']?>"><?= $data['jenjang'].' '.$data['nm_prodi'];?></a>   
    <?php
    }*/
    ?>
</div>
-->
<div class="divider10"></div>
<?php //$this->view('backend/widgets/tesis/tab_link_persetujuan_dosen'); ?>
<!--<div class="divider10"></div>-->
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_PROPOSAL, 'prodi' => $id_prodi]); ?>
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
                    <th colspan="2">Pembimbing</th>
                    <th class="text-center">Berkas Proposal</th>
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
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL]); ?>
                            <?php if (($id_prodi == S2_ILMU_HUKUM && $list['status_proposal'] > MIH_STATUS_TESIS_PROPOSAL_UJIAN) OR ($id_prodi == S2_KENOTARIATAN && $list['status_proposal'] > MKN_STATUS_TESIS_PROPOSAL_UJIAN)) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_proposal'], UJIAN_TESIS_PROPOSAL);
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if(($id_prodi == S2_ILMU_HUKUM && $list['status_proposal'] == MIH_STATUS_TESIS_PROPOSAL_PENGAJUAN) OR ($id_prodi == S2_KENOTARIATAN && $list['status_proposal'] == MKN_STATUS_TESIS_PROPOSAL_PENGAJUAN_JUDUL))
                            {
                            ?>
                                <?php
                                if ($list['status_pembimbing_satu'] == '1' && $list['status_pembimbing_dua'] == '1') {
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
                            else if(($id_prodi == S2_ILMU_HUKUM && $list['status_proposal'] == MIH_STATUS_TESIS_PROPOSAL_SETUJUI_SPS) OR ($id_prodi == S2_KENOTARIATAN && $list['status_proposal'] == MKN_STATUS_TESIS_PROPOSAL_SETUJUI_SPS)) {
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