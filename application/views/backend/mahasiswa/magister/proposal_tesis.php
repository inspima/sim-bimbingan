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
                    <a class="btn btn-xs btn-primary" href="<?= base_url()?>dashboardm/magister/proposal_tesis/add">
                    <i class="fa fa-plus"></i> Pengajuan Proposal Tesis</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Departemen</th>
                            <th>Gelombang</th>
                            <th>Tanggal Pengajuan</th>
                            <th>File (BAB I)</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        //var_dump($proposal); die();
                        foreach($proposal as $list){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?php
                                $judul = $this->proposal->read_judul($list['id_skripsi']);
                                echo $judul->judul;
                                ?>
                            </td>
                            <td><?=$list['departemen']?></td>
                            <td><?=$list['semester'].' ('.$list['gelombang'].')'?></td>
                            <td><?=$list['tgl_pengajuan']?></td>
                            <td>
                                <a href="<?php echo base_url()?>assets/upload/proposal/<?php echo $list['berkas_proposal']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>
                            </td>
                            <td>
                                <?php 
                                if($list['status_proposal'] == '1')
                                {
                                ?>
                                    <a class="btn btn-xs btn-primary pull-left" href="#">
                                    <i class="fa fa-check"></i> Pengajuan</a>
                                <?php
                                }
                                else
                                if($list['status_proposal'] == '2')
                                {
                                ?>
                                    <a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Diterima</a>
                                <?php
                                }
                                else
                                if($list['status_proposal'] == '3')
                                {
                                ?>
                                    <a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Selesai</a>
                                <?php
                                }
                                else
                                if($list['status_proposal'] == '4')
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
                                if($list['status_proposal'] == '1')
                                {
                                ?>
                                    <a class="btn btn-xs btn-warning pull-left" href="<?= base_url()?>dashboardm/magister/proposal_tesis/edit/<?= $list['id_skripsi']?>">
                                    <i class="fa fa-edit"></i> Edit</a>
                                <?php
                                }
                                else
                                if($list['status_proposal'] == '2')
                                {
                                ?>
                                <?php
                                }
                                else
                                if($list['status_proposal'] == '3')
                                {
                                ?>
                                <?php
                                }
                                else
                                if($list['status_proposal'] == '4')
                                {
                                ?>
                                <?php
                                }
                                ?>
                                
                                <a class="btn btn-xs btn-primary pull-left" href="<?= base_url()?>dashboardm/magister/proposal_tesis/ujian/<?= $list['id_skripsi']?>">
                                    <i class="fa fa-calendar"></i> Detail Ujian</a>
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