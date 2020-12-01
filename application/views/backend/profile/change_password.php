<?php if ($this->session->flashdata('msg')): ?>
    <?php
    $class_alert = 'alert ' . $this->session->flashdata('msg-title') . ' alert-dismissable';
    ?>
    <div class='<?= $class_alert ?>'>
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
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('profile/password/save'); ?>
            <div class="box-body">
                <div class="form-group">
                    <label>Password Lama</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('password', 'password', '', 'required') ?>
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <?php echo formtext('password', 'password_new', '', 'required') ?>
                </div>
                <div class="form-group">
                    <label>Ulangi Password Baru</label>
                    <?php echo formtext('password', 'password_new_c', '', 'required') ?>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Ubah Password</button>
                <a class="btn btn-primary" href="<?= base_url() ?>profile"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.box -->
    </div>



</div>