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
                <h2 class="box-title">Informasi Tesis</h2>

            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <?php $this->view('backend/widgets/tesis/informasi_tesis_judul', ['tesis' => $tesis]); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">1. Dosen Penguji</h3>
            </div>
            <?php echo form_open('dosen/tesis/proposal/penguji_usulan_penguji_save'); ?>
            <div class="box-body table-responsive">
                <?php
                if ($ujian) {
                    ?>
                    <div class="form-group">
                        <label>Penguji</label>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
                        <select name="nip" class="form-control select2" style="width: 100%;" required>
                            <option value="">- Pilih -</option>
                            <?php
                            foreach ($mdosen as $list) {
                                ?>
                                <option value="<?php echo $list['nip'] ?>"><?php echo $list['nama'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Tolak dan Usulkan Pengganti</button>
                    </div>

                    <?php echo form_close() ?>
                    <?php $this->view('backend/widgets/tesis/list_penguji_dosen_temp', ['tesis' => $tesis, 'asal_pengusul' => '2']); ?>
                    <?php
                } else {
                    ?>
                    <div class="form-group">
                        <p>Setting ujian terlebih dahulu</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <!-- /.box -->
    </div>


</div>