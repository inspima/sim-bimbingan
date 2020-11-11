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
            <h3 class="box-title">Password</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php echo form_open('dashboarda/master/struktural/update');?>
            <div class="box-body">
                <div class="form-group">
                    <label>Nama Struktur</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_struktural', $struktural->id_struktural, 'required') ?>
                    <?php echo formtext('text', 'username', $struktural->nama_struktur, 'readonly') ?>
                </div>
                <div class="form-group">
                    <label>Nama Struktural</label>
                    <?php echo formtext('text', 'username', $struktural->nama, 'readonly') ?>
                </div>
                <div class="form-group">
                    <label>Pilih</label>
                    <select name="nip" class="form-control select2" style="width: 100%;" required>
                        <option value="<?php echo $struktural->nip?>"><?php echo $struktural->nama_dosen?></option>
                        <?php 
                        foreach($user as $list){
                        ?>
                        <option value="<?php echo $list['username']?>"><?php echo $list['nama']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-sm btn-warning" href="<?= base_url()?>dashboarda/master/struktural"><i class="fa fa-close"></i> Batal</a>
            </div>
        <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>