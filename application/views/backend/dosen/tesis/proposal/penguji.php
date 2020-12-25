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
    <?php 
    foreach($prodi as $data){
    $id = $this->uri->segment(5) ? $this->uri->segment(5) : $max_id_prodi;
    ?>
        <a class="<?= ($id == $data['id_prodi']) ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/proposal/penguji/<?= $data['id_prodi']?>"><?= $data['jenjang'].' '.$data['nm_prodi'];?></a>   
    <?php
    }
    ?>
</div>
<div class="divider10"></div>
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
                    <th>Jadwal</th>
                    <th>Status</th>
                    <th>Tim</th>
                    <th>Status Penguji</th>
                    <th>Opsi</th>
                    <th>Action</th>
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
                            <a href="<?php echo base_url()?>assets/upload/mahasiswa/tesis/proposal/<?php echo $list['berkas_proposal']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>
                        </td>
                        <td><?php echo toindo($list['tgl_pengajuan']) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_jadwal', ['id_tesis' => $list['id_tesis'], 'jenis' => UJIAN_TESIS_PROPOSAL]); ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => UJIAN_TESIS_PROPOSAL]); ?>
                            <?php if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_UJIAN) {
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
                            $str_status_tim = '';
                            if ($list['status_tim'] == '1') {
                                $str_status_tim = 'Ketua';
                            } else if ($list['status_tim'] == '2') {
                                $str_status_tim = 'Anggota';
                            }
                            echo '<span class="btn btn-xs btn-primary">'.$str_status_tim.'</span>';
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if($list['status_penguji'] == '1')
                            {
                            ?>
                                <a class="btn btn-xs btn-primary pull-left" href="#">
                                <i class="fa fa-check"></i> Pengajuan</a>
                            <?php
                            }
                            else
                            if($list['status_penguji'] == '2')
                            {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>
                            <?php
                            }
                            else
                            if($list['status_penguji'] == '3')
                            {
                            ?>
                                <a class="btn btn-xs btn-danger pull-left" href="#">
                                <i class="fa fa-check"></i> Ditolak</a>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if($list['status_penguji'] == '1')
                            {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/proposal/approve_penguji/<?= $list['id_tesis']?>/<?= $list['id_ujian']?>">
                                <i class="fa fa-edit"></i> Approve</a>
                                <a class="btn btn-xs btn-danger pull-left" href="<?= base_url()?>dosen/tesis/proposal/penguji_setting_penguji/<?php echo $list['id_tesis']?>">
                                <i class="fa fa-close"></i> Reject</a>
                            <?php
                            }
                            else if($list['status_penguji'] == '2') {
                            ?>
                                <a class="btn btn-xs btn-warning pull-left" href="<?= base_url()?>dosen/tesis/proposal/batal_penguji/<?= $list['id_tesis']?>/<?= $list['id_ujian']?>">
                                    <i class="fa fa-ban"></i> Batal</a>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if($list['status_penguji'] == '2')
                            {
                            ?>
                                <a href = "<?= base_url() ?>dosen/tesis/proposal/status_ujian/<?= $list['id_tesis'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-edit"></i> Status Ujian</a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>      
                    <?php
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->