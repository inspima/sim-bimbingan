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
                <h3 class="box-title">Biodata</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <label>Nama</label>
                    <hr class="divider-line-thin"/>
                    <?= $this->session_data['nama'] ?>
                </div>
                <div class="form-group">
                    <label><?= $this->session_data == '3' ? 'NIM' : 'NIP' ?></label>
                    <hr class="divider-line-thin"/>
                    <?= $this->session_data['username'] ?>

                </div>
                <div class="form-group">
                    <label>Email</label>
                    <hr class="divider-line-thin"/>
                    <?= $this->session_data['email'] ?>
                </div>
                <div class="form-group">
                    <label>Sebagai</label>
                    <hr class="divider-line-thin"/>
                    <?= $this->session_data['sebagai'] == '1' ? $this->session_data == '2' ? 'Tendik' : 'Dosen' : 'Mahasiswa' ?>
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <hr class="divider-line-thin"/>
                    <?php echo form_open('profile/phone/save'); ?>
                    <div class="col-sm-4" style="padding: 0px">
                        <input type="hidden" name="id_user" value="<?php echo $biodata->id_user ?>"/>
                        <input type="text" name="no_hp" value="<?php echo $biodata->no_hp ?>" class="form-control" />
                    </div>
                    <div class="col-sm-4 text-left" style="padding: 3px">
                        <button type="submit" class="btn btn-sm btn-success">Update NO HP</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a class="btn btn-info" href="<?= base_url() ?>profile/password"><i class="fa fa-lock"></i> Ubah Password</a>
                <?php
                if ($this->session_data['sebagai'] != '3') {
                    ?>
                    <a class="btn btn-warning" href="<?= base_url() ?>profile/signature"><i class="fa fa-pencil-square"></i> Tanda Tangan</a>
                    <?php
                }
                ?>

            </div>
        </div>
        <!-- /.box -->
    </div>

</div>