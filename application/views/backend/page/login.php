<div class="row">
    <div class="col-md-8">
        <p style="font-size:50px;color:#FFFFFF;">IURIS</p>
        <p style="font-size:35px;color:#FFFFFF;text-shadow: #000000 1px 0 10px;">Selamat Datang di aplikasi pengelolaan Proposal Skripsi, Skripsi Fakultas Hukum Universitas Airlangga</p>
    </div>
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title text-shadow" >Login</h3>
            </div>
            <?php echo form_open('login/auth') ?>
            <div class="box-body">
                <?php echo validation_errors() ?>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Masuk</button>
                <a href="<?= base_url() ?>register" class="btn bg-orange pull-right"><i class="fa fa-user-plus"></i> Registrasi</a>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
    <div class="col-md-8">
        <p>&nbsp;</p>
    </div>
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title text-shadow">Butuh bantuan ?</h3>
            </div>
            <div class="box-body">
                <p>Unit Sistem Informasi <br>
                    Gedung A Fakultas Hukum <br>
                    Universitas Airlangga
            </div>
        </div>
    </div>
</div>