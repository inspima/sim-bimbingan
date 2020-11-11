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
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $subtitle?></h3>
            <div class="pull-right">
                <a class="btn btn-xs btn-warning" href="<?= base_url()?>dashboardb/skripsi/skripsi_pengajuan"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <label>Nama</label>
                    <p><?php echo $skripsi->nama?></p>
                </div>    
                <div class="form-group">
                    <label>Judul</label>
                    <textarea class="form-control" name="judul"><?php
                    $judul = $this->skripsi->read_judul($skripsi->id_skripsi);
                    echo $judul->judul;
                    ?></textarea>
                </div>     
                <div class="form-group">
                    <label>Dosen Pembimbing</label>
                    <p>
                    <?php
                    $pembimbing = $this->skripsi->read_pembimbing($skripsi->id_skripsi);
                    echo $pembimbing->nama;
                    ?>
                    </p>
                </div>                                
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Bimbingan</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
            <div class="box-body">
                <table class="table table-bordered">    
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Materi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($bimbingan as $list){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?php echo toindo($list['tanggal'])?>
                            </td>
                            <td><?php echo $list['hal']?></td>
                            <td>
                            <?php 
                            if($list['status'] == '1')
                            {
                                echo 'Belum disetujui';
                            }
                            else
                            if($list['status'] == '2')
                            {
                                echo 'Disetujui';
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
            
        </div>
        <!-- /.box -->
    </div>
    
</div>