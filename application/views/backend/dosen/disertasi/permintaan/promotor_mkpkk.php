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
    <div class="col-sm-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">Informasi Disertasi</h2>

            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <?php $this->view('backend/widgets/disertasi/informasi_disertasi_judul', ['disertasi' => $disertasi]); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">MKPKK</h3>
            </div>
            <div class="box-body table-responsive">
                <?php $this->view('backend/widgets/disertasi/list_mkpkk_dosen', ['disertasi' => $disertasi]); ?>
            </div>
        </div>
    </div>
</div>