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
                <h3 class="box-title"><?=$title?></h3>
                <div class="pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Struktur</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Departemen</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($struktural as $list){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$list['nama_struktur']?></td>
                            <td><?=$list['nama']?></td>
                            <td><?=$list['nama_dosen'].'<br>'.$list['nip']?></td>      
                            <td><?=$list['departemen']?></td>      
                            <td><a class="btn btn-xs btn-warning pull-left" href="<?= base_url()?>dashboarda/master/struktural/detail/<?= $list['id_struktural']?>">
                                <i class="fa fa-edit"></i> Edit</a></td>          
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