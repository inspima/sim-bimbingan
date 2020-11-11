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
                <div class="form-group">
                    <label>Judul</label>
                    <textarea class="form-control" name="judul" readonly><?php
                    $judul = $this->skripsi->read_judul($skripsi->id_skripsi);
                    echo $judul->judul;
                    ?></textarea>
                </div>
                <div class="form-group">
                    <label>Berkas Skripsi, Turnitin & TOEFL (max 10mb)</label>
                    <p>
                    <?php if($skripsi->turnitin){?>
                    <a href="<?php echo base_url()?>assets/upload/turnitin/<?php echo $skripsi->turnitin?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="50px" height="auto"></a>
                    <?php 
                    }
                    else
                    {
                        echo 'Belum Upload';
                    }
                    ?>
                    </p>
                </div>
                <div class="form-group">
                    <label>Toefl</label>
                    <p>
                    <?php echo $skripsi->toefl;?>
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
            <h3 class="box-title">1. Berkas Skripsi, Turnitin & TOEFL (1 PDF)</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
            <?php echo form_open_multipart('dashboardm/modul/skripsi/syarat_upload');?>
            <div class="box-body">
                <div class="form-group">
                    <label>Upload Berkas Skripsi, Turnitin & TOEFL</label>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                        <input type="file" name="file" value="" class="form-control">              
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-upload"></i> Upload</button>
            </div>
            <?php echo form_close()?>
        </div>
        <!-- /.box -->
    </div>

    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">2. Toefl</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
            <?php echo form_open('dashboardm/modul/skripsi/update_toefl');?>
            <div class="box-body">
                <div class="form-group">
                    <label>Nilai Toefl</label>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                        <input type="text" name="toefl" value="<?php echo $skripsi->toefl?>" class="form-control">              
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
            </div>
            <?php echo form_close()?>
        </div>
        <!-- /.box -->
    </div>
    
</div>