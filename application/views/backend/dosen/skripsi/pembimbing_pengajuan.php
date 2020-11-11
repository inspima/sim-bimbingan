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
                            <th>Departemen</th>
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
                            <td><?=$list['nama'].'<br>('.$list['nim'].')'?></td>
                            <td>
                            <?php 
                            $judul = $this->pembimbing->read_judul($list['id_skripsi']);
                            echo $judul->judul;
                            ?>
                            </td>
                            <td>
                            <?php echo $list['departemen']?>
                            </td>
                            <td>
                                <?php echo form_open('dashboardd/skripsi/pembimbing_pengajuan/update_pembimbing');?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <?php echo formtext('hidden', 'id_pembimbing', $list['id_pembimbing'], 'required') ?>
                                <?php echo formtext('hidden', 'status', '2', 'required') ?>
                                <button type="submit" class="btn btn-xs btn-success"> Approve</button>
                                <?php echo form_close();?>

                                <?php echo form_open('dashboardd/skripsi/pembimbing_pengajuan/update_pembimbing');?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <?php echo formtext('hidden', 'id_pembimbing', $list['id_pembimbing'], 'required') ?>
                                <?php echo formtext('hidden', 'status', '3', 'required') ?>
                                <button type="submit" class="btn btn-xs btn-danger"> Tolak</button>
                                <?php echo form_close();?>
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