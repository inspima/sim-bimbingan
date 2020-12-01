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
                <div id="signature-pad" class="signature-pad">
                    <div class="signature-pad--body">
                        <canvas></canvas>
                    </div>
                    <div class="signature-pad--footer">
                        <div class="text-success">Tanda Tangan dalam Kotak warna merah</div>

                        <div class="signature-pad--actions">
                            <div>
                                <button type="button" class="btn btn-sm btn-default clear" data-action="clear">Bersihkan</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-success clear save" data-action="save-png">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

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
