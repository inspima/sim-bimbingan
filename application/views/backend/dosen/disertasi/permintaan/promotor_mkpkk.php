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
                <?php
                if ($disertasi->status_mpkk == STATUS_DISERTASI_MPKK_SETUJUI_KPS):
                    ?>
                    <?php echo form_open('dosen/disertasi/permintaan/promotor/mkpkk/save'); ?>
                    <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <div class="form-group">
                        <label>Pilih MKPKK</label>
                        <select name="id_mkpkk[]" class="form-control select2" style="width: 100%;" required multiple="true">
                            <?php
                            foreach ($mkpkks as $mkpkk) {
                                ?>
                                <option value="<?php echo $mkpkk['id_mkpkk'] ?>"><?php echo $mkpkk['nama'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Ubah</button>
                    <?= form_close() ?>
                    <?php
                endif;
                ?>

                <?php $this->view('backend/widgets/disertasi/list_mkpkk_dosen', ['disertasi' => $disertasi]); ?>
                <?php
                if ($disertasi->status_mpkk == STATUS_DISERTASI_MPKK_SETUJUI_KPS):
                    ?>
                    <div class="divider10"></div>
                    <?php echo form_open('dosen/disertasi/permintaan/promotor/mpkk/setujui') ?>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                    <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
                    <?php echo form_close() ?>
                    <?php
                endif;
                ?>

            </div>
        </div>
    </div>
</div>