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
            <div class="box-header with-border">
                <h3 class="box-title">Tanda Tangan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('profile/signature/save'); ?>
            <div class="box-body">
                <img src="<?= $biodata->ttd ?>" width="100%"/>
                <div class="callout callout-warning">Jika ttd sudah diganti tapi belum berubah silahkan klik refresh</div>
                <a href="<?= base_url() ?>profile/signature/change" class="btn btn-sm bg-navy-active" ><i class="fa fa-pencil-square"></i> Ganti</a>
                <button type="button" class="btn btn-sm bg-aqua" onclick="window.location.reload(true);" ><i class="fa fa-repeat"></i> Refresh</button>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a class="btn btn-primary" href="<?= base_url() ?>profile"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.box -->
    </div>

</div>
