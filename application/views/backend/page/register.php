<div class="row">
    <div class="col-md-8">
        <p style="font-size:50px;color:#FFFFFF;">IURIS</p>
        <p style="font-size:35px;color:#FFFFFF;text-shadow: #000000 1px 0 10px;">Selamat Datang di aplikasi pengelolaan Proposal Skripsi, Skripsi Fakultas Hukum Universitas Airlangga</p>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-shadow">Registrasi Mahasiswa</h3>
            </div>
            <?php echo form_open('auth/register') ?>
            <div class="box-body">
                <?php if ($this->session->flashdata('msg')): ?>
                    <?php
                    $class_alert = 'alert ' . $this->session->flashdata('msg-title') . ' alert-dismissable';
                    ?>
                    <div class='<?= $class_alert ?>'>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Email <span class="text-info">(Pastikan email anda aktif dan bisa dibuka)</span></label>
                    <input type="email" name="email" placeholder="mahasiswa@email.com" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" placeholder="Nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" placeholder="NIM" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Program Studi</label>
                    <select name="prodi" class="form-control">
                        <?php
                        foreach ($prodis as $prodi):
                            ?>
                            <option value="<?= $prodi['id_prodi'] ?>"><?= $prodi['jenjang'] ?> <?= $prodi['nm_prodi'] ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>SKS Tempuh</label>
                    <input type="number" name="sks" placeholder="SKS Tempuh" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Masukkan Kode dalam gambar</label>
                    <div id="image_captcha" style="display: inline"><?php echo $captcha_image; ?></div>
                    <a href="javascript:void(0);" class="captcha-refresh btn btn-success btn-sm" ><i class="fa fa-repeat"></i> </a>
                    <div class="divider5"></div>
                    <input type="text" name="captcha" placeholder="Kode" class="form-control" required>
                </div>
            </div>
            <div class="box-footer">
                <input type="hidden" name="_token" value="<?= sha1(rand(90000000, 9999999)) ?>">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Register</button>
                <a href="<?= base_url() ?>login" class="btn bg-aqua pull-right"><i class="fa fa-arrow-left"></i> Halaman Login</a>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.captcha-refresh').on('click', function () {
            $.get('<?php echo base_url() . 'auth/captcha/refresh'; ?>', function (data) {
                $('#image_captcha').html(data);
            });
        });
    });
</script>
