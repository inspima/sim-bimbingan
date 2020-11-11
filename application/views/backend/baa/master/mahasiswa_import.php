<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $subtitle?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        
            <div class="box-body">
                <?php echo form_open('dashboardb/master/mahasiswa/download_excel');?>
                <div class="form-group">
                    <label>Download Excel</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <p><button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Download</button></p>
                </div>
                <?php echo form_close()?>
        <?php echo form_open_multipart('dashboardb/master/mahasiswa/import_save');?>
                <div class="form-group">
                    <label>Upload Excel</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <input type="file" name="file" required>
                </div>
                
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-upload"></i> Upload</button>
                <a class="btn btn-sm btn-warning" href="<?= base_url()?>dashboardb/master/mahasiswa"><i class="fa fa-close"></i> Batal</a>
            </div>
        <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>