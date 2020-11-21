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
<?php
$promotors = $this->disertasi->read_promotor_kopromotor($disertasi->id_disertasi);
if (count($promotors) == 0) {
    ?>
    <div class="callout callout-warning">
        <h4>Perhatian!</h4>
        <p>Anda belum mengajukan Promotor/Ko Promotor.</p>
    </div>
    <?php
}
?>
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart('mahasiswa/disertasi/terbuka/save'); ?>
            <div class="box-body">
                <div class="form-group">
                    <label>Departemen</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
                    <select name="id_departemen" class="form-control select2" style="width: 100%;" required>
                        <option value="">Pilih</option>
                        <?php
                        foreach ($departemen as $list) {
                            ?>
                            <option value="<?php echo $list['id_departemen'] ?>" <?php if ($disertasi->id_departemen == $list['id_departemen']) echo 'selected'; ?>><?php echo $list['departemen'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <textarea class="form-control" name="judul" required><?php echo $disertasi->judul ?></textarea>
                </div>

                <div class="form-group">
                    <label>Upload Bukti TOEFL & TOEFL PENDAMPING  & FORM PERBAIKAN UJIAN KELAYAKAN dijadikan 1 File(format file .pdf maks 10mb)</label>
                    <input type="file" name="berkas_terbuka" class="form-control" required>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-up"></i> Ajukan</button>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Pengajuan Promotor & Ko-Promotor</h3>
            </div>
            <?php echo form_open('mahasiswa/disertasi/terbuka/promotor_save'); ?>
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
                                        <?php echo form_open('mahasiswa/disertasi/terbuka/promotor_delete') ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
                                        <?php echo formtext('hidden', 'id_promotor', $promotor['id_promotor'], 'required') ?>
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                        <?php echo form_close() ?>
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
</div>