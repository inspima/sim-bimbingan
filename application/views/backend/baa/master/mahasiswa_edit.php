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
        <?php echo form_open('dashboardb/master/mahasiswa/update');?>
            <div class="box-body">
                <div class="form-group">
                    <label>NIM</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext_angka('hidden', 'id_mahasiswa', $mahasiswa->id_mahasiswa, 'required') ?>
                    <?php echo formtext_angka('hidden', 'id_user', $mahasiswa->id_user, 'required') ?>
                    <?php echo formtext_angka('text', 'nim', $mahasiswa->nim, 'required') ?>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <?php echo formtext('text', 'nama', $mahasiswa->nama, 'required') ?>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <?php echo formtext('text', 'alamat', $mahasiswa->alamat, 'required') ?>
                </div>
                <div class="form-group">
                    <label>Telp</label>
                    <?php echo formtext('text', 'telp', $mahasiswa->telp, 'required') ?>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <?php echo formtext('text', 'email', $mahasiswa->email, 'required') ?>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-sm btn-warning" href="<?= base_url()?>dashboardb/master/mahasiswa"><i class="fa fa-close"></i> Batal</a>
            </div>
        <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>

    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Ubah Password</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php echo form_open('dashboardb/master/mahasiswa/update_password');?>
            <div class="box-body">
                <div class="form-group">
                    <label>Password</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext_angka('hidden', 'id_mahasiswa', $mahasiswa->id_mahasiswa, 'required') ?>
                    <?php echo formtext_angka('hidden', 'id_user', $mahasiswa->id_user, 'required') ?>
                    <?php echo formtext('text', 'password', '', 'required') ?>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
            </div>
        <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>