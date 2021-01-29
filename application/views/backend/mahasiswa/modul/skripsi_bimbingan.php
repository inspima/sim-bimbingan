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
                <a class="btn btn-xs btn-warning" href="<?= base_url()?>dashboardm/modul/skripsi"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
            <div class="box-body">
                <?php echo form_open('dashboardm/modul/skripsi/save_judul');?>
                <div class="form-group">
                    <label>Judul</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                    <textarea class="form-control" name="judul"><?php
                    $judul = $this->skripsi->read_judul($skripsi->id_skripsi);
                    echo $judul->judul;
                    ?></textarea>
                </div>   
                <div class="form-group">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Ubah Judul</button>
                </div>  

                <?php echo form_close()?>
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
            <?php echo form_open('dashboardm/modul/skripsi/bimbingan_save');?>
            <div class="box-body">
                <div class="form-group">
                    <label>Tanggal</label>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                        <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" readonly name="tanggal" value="" class="form-control pull-right" id="datepicker" required>
                        </div>              
                </div>
                <div class="form-group">
                    <label>Materi Bimbingan</label>
                        <input type="text" name="hal" value="" class="form-control" required>            
                </div>
                <div class="form-group">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close()?>
            <div class="box-footer">
                <table class="table table-bordered">    
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Materi</th>
                            <th>Status</th>
                            <th>Opsi</th>
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
                            <td>
                            <?php
                            if($list['status'] == '1')
                            {
                            ?>
                            <?php echo form_open('dashboardm/modul/skripsi/bimbingan_delete')?>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
                            <?php echo formtext('hidden', 'id_bimbingan', $list['id_bimbingan'], 'required') ?>
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
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
            
        </div>
        <!-- /.box -->
    </div>
    
</div>
