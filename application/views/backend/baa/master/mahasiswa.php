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
                    <a class="btn btn-xs btn-primary" href="<?= base_url()?>dashboardb/master/mahasiswa/add">
                    <i class="fa fa-plus"></i> Tambah</a>
                    <a class="btn btn-xs btn-primary" href="<?= base_url()?>dashboardb/master/mahasiswa/import">
                    <i class="fa fa-upload"></i> Import</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telp</th>
                            <th>Email</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($mahasiswa as $list){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$list['nim']?></td>
                            <td><?=$list['nama']?></td>
                            <td><?=$list['alamat']?></td>
                            <td><?=$list['telp']?></td>
                            <td><?=$list['email']?></td>
                            <td>                               
                                <a class="btn btn-xs btn-warning pull-left" href="<?= base_url()?>dashboardb/master/mahasiswa/edit/<?= $list['id_mahasiswa']?>">
                                <i class="fa fa-edit"></i> Edit</a>
                                <?php 
                                if($list['status'] == '0')
                                {
                                ?>
                                <?php echo form_open('dashboardb/master/mahasiswa/aktifkan');?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <?php echo formtext('hidden', 'id_mahasiswa', $list['id_mahasiswa'], 'required') ?>
                                <button type="submit" class="btn btn-xs btn-success"></i> Aktifkan</button>
                                <?php echo form_close()?>
                                <?php 
                                }
                                else
                                {

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
    </div>
    <!-- /.col -->
</div>