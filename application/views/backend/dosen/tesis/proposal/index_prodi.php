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
<?php $this->view('backend/widgets/tesis/tab_link_program_studi'); ?>
<div class="divider10"></div>
<?php $this->view('backend/widgets/tesis/tab_link_persetujuan_dosen'); ?>
<div class="divider10"></div>
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_PROPOSAL]); ?>
<div class="box">
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
                        <td><?php echo $list['nama_pembimbing_satu'] ?><br/><b><?php echo $list['nip_pembimbing_satu'] ?></b></td>
                        <td><?php echo $list['nama_pembimbing_dua'] ?><br/><b><?php echo $list['nip_pembimbing_dua'] ?></b></td>
                        <td class="text-center">

                            <a href="<?php echo base_url()?>assets/upload/tesis/proposal/<?php echo $list['berkas_proposal']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>

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

                            <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/proposal/approve/<?= $list['id_tesis']?>">

                            <i class="fa fa-edit"></i> Approve</a><br>

                            <a class="btn btn-xs btn-danger pull-left" href="<?= base_url()?>dosen/tesis/proposal/reject/<?= $list['id_tesis']?>">

                            <i class="fa fa-edit"></i> Reject</a>

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