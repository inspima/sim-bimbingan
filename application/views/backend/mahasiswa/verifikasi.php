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
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Biodata</h3>
            </div>
            <!-- /.box-header -->

            <?php echo form_open_multipart('auth/verifikasi'); ?>
            <div class="box-body">
                <?php
                if (!empty($biodata->berkas_verifikasi)) {
                    ?>
                    <div class="callout callout-success">Anda sudah mengirimkan berkas, anda akan menerima email ketika sudah diverifikasi</div>
                    <?php
                }
                ?>
                <table class="table table-bordered">
                    <tr>
                        <td>Email</td>
                        <td style="width: 5%">:</td>
                        <td>
                            <?php echo $biodata->email ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td style="width: 5%">:</td>
                        <td>
                            <input name="nama" type="text" class="form-control" value="<?php echo $biodata->nama ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>NIM</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo $biodata->nim ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td style="width: 5%">:</td>
                        <td>
                            <textarea name="alamat" class="form-control" required><?php echo $biodata->alamat ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Telp</td>
                        <td style="width: 5%">:</td>
                        <td>
                            <input name="telp" type="text" class="form-control" value="<?php echo $biodata->telp ?>"/>
                        </td>
                    </tr>
					<tr>
						<td>No HP</td>
						<td style="width: 5%">:</td>
						<td>
							<input name="no_hp" type="text" class="form-control" value="<?php echo $biodata->no_hp ?>"/>
						</td>
					</tr>
                    <tr>
                        <td style="width: 20%">Berkas - Bukti KRS <br/><b>(format file .pdf maks 1mb)</b>
                            <?php
                            if (!empty($biodata->berkas_verifikasi)) {
                                ?>
                                <br/>
                                <a href="<?= base_url() ?>/assets/upload/mahasiswa/verifikasi/<?= $biodata->berkas_verifikasi ?>" target="_blank" class="btn btn-xs btn-danger">Berkas</a>
                                <?php
                            }
                            ?>
                        </td>
                        <td style="width: 5%">:</td>
                        <td>
                            <input name="berkas_verifikasi" type="file" class="form-control" required/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="box-footer">
				<input type="hidden" name="id_user" value="<?= $biodata->id_user ?>">
                <input type="hidden" name="id_mhs" value="<?= $biodata->id_mahasiswa ?>">
                <input type="hidden" name="_token" value="<?= sha1(rand(90000000, 9999999)) ?>">                
                <button type="submit" class="btn btn-sm btn-success pull-right"><i class="fa fa-check"></i> Simpan</button>
            </div>
            <?= form_close() ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
