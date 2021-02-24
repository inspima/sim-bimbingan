<div class="row">
    <div class="col-md-8">
        <p class="hidden-xs hidden-sm" style="font-size:35px;color:black;margin-top:30px;font-weight: bold">Selamat Datang di SIM Tugas Akhir</p>
    </div>
    <div class="col-md-4">
        <div class="box box-default box-solid">
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
				<p>Tidak menerima <b>Email Registrasi</b>, <b>Lupa Password</b> dan <b>Reset Akun</b> silahkan klik <a href="<?= base_url() ?>reset-account"><b>disini</b></a></p>
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
        <div class="box">
            <div class="box-header">
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
