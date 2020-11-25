<?php if($this->session->flashdata('msg')): ?>
  <?php 
  $class_alert = 'alert '.$this->session->flashdata('msg-title').' alert-dismissable';
  ?>
  <div class='<?=$class_alert?>'>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Notifikasi</h4>
    <?php echo $this->session->flashdata('msg'); ?>
  </div>
<?php endif; ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?=$subtitle?></h3>
                <div class="pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Judul</th>
                            <th>Berkas Proposal</th>
                            <th>Status</th>
                            <th>Status Pengajuan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($pembimbing as $list){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$list['nama'].'<br>('.$list['nip'].')'?></td>
                            <td><?=$list['judul']?></td>                            
                            <td>
                                <a href="<?php echo base_url()?>assets/upload/proposal/<?php echo $list['berkas_proposal']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>
                            </td>
                            <td>
                                <?php 
                                if($list['status_bimbingan'] == '1')
                                {
                                    echo 'Ketua';
                                }
                                else
                                if($list['status_bimbingan'] == '2')
                                {
                                    echo 'Anggota';
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                if($list['status'] == '1')
                                {
                                    echo 'Approve <br />';
                                ?>
                                <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dashboardd/proposal_tesis/pembimbing/pembimbing2/<?= $list['id_skripsi']?>">
                                <i class="fa fa-edit"></i> Set Pembimbing II</a>
                                <?php
                                }
                                else
                                if($list['status'] == '2')
                                {
                                    echo 'Reject';
                                }
                                ?>
                                
                            </td>
                            <td>
                                <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dashboardd/proposal_tesis/pembimbing/approve/<?= $list['id_skripsi']?>">
                                <i class="fa fa-edit"></i> Approve</a> |
                                <a class="btn btn-xs btn-danger pull-left" href="<?= base_url()?>dashboardd/proposal_tesis/pembimbing/reject/<?= $list['id_skripsi']?>">
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
    </div>
    <!-- /.col -->
</div>