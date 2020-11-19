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
                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" value="<?php echo $disertasi->nim ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $disertasi->nama ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <?php
                    $judul = $this->disertasi->read_judul($disertasi->id_disertasi);
                    ?>
                    <textarea class="form-control" name="judul" readonly><?php echo $judul->judul ?></textarea>
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
                <h3 class="box-title">Promotor & Ko-Promotor</h3>
            </div>
            <?php echo form_open('mahasiswa/disertasi/proposal/promotor_save'); ?>
            <div class="box-body table-responsive">
                <?php
                if ($disertasi->status_kualifikasi > 4) {
                    ?>
                    <div class="form-group">
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
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
                        <select name="status_tim" class="form-control">
                            <option value="1">Promotor</option>
                            <option value="2">Ko Promotor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                    <?php echo form_close() ?>                
                    <div class="form-group">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <th>Tim</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                            <?php
                            $str_status_tim = '';
                            $promotors = $this->disertasi->read_promotor_kopromotor($disertasi->id_disertasi);
                            foreach ($promotors as $promotor) {
                                if ($promotor['status_tim'] == '1') {
                                    $str_status_tim = 'Promotor';
                                } else if ($promotor['status_tim'] == '2') {
                                    $str_status_tim = 'Co-Promotor';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $promotor['nama'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-xs bg-blue-gradient" style="color:white" >
                                            <?php echo $str_status_tim ?>
                                        </button>
                                    <td>
                                        <?php
                                        if ($promotor['status'] == '1') {
                                            ?>
                                            <button type="submit" class="btn btn-xs btn-warning"> Belum Approve</button>
                                            <?php
                                        } else
                                        if ($promotor['status'] == '2') {
                                            ?>
                                            <button type="submit" class="btn btn-xs btn-success"> Approved</button>
                                            <?php
                                        } else
                                        if ($promotor['status'] == '3') {
                                            ?>
                                            <button type="submit" class="btn btn-xs btn-danger"> Rejected</button>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($promotor['status'] != '2'):
                                            ?>
                                            <?php echo form_open('mahasiswa/disertasi/proposal/promotor_delete') ?>
                                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                            <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
                                            <?php echo formtext('hidden', 'id_promotor', $promotor['id_promotor'], 'required') ?>
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                            <?php echo form_close() ?>
                                            <?php
                                        endif;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>

                    <?php
                } else {
                    ?>
                    <div class="form-group">
                        <p>Ujian dah hasil belum ditentukan</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <!-- /.box -->
    </div>

    <!-- left column -->


</div>

<div class="row">
    <div class="col-sm-6">
        <!-- general form elements -->

        <!-- /.box -->
    </div>
</div>