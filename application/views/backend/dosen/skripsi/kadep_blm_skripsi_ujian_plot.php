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
    <div class="col-md-4">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <label>NIM</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                    <input type="text" name="nim" class="form-control" value="<?php echo $skripsi->nim ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $skripsi->nama ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <?php
                    $judul = $this->skripsi->read_judul($skripsi->id_skripsi);
                    ?>
                    <textarea class="form-control" name="judul" readonly><?php echo $judul->judul ?></textarea>
                </div>  
                <div class="form-group">
                    <label>Pembimbing</label>
                    <?php
                    $pembimbing = $this->skripsi->read_pembimbing($skripsi->id_skripsi);
                    ?>
                    <input type="text" name="nama" class="form-control" value="<?php echo $pembimbing->nama ?>" readonly>
                </div>             

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">1. Setting Jadwal</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('dashboardd/skripsi/kadep_blm_skripsi/ujian_plot_save'); ?>
            <div class="box-body">

                <div class="form-group">
                    <label>Tanggal</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                    <?php echo formtext('hidden', 'id_ujian', $nid_ujian->id_ujian, 'required') ?>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?php
                        if ($ujian) {
                            $id_ujian = $ujian->id_ujian;
                            $tanggal = toindo($ujian->tanggal);
                            $id_ruang = $ujian->id_ruang;
                            $ruang = $ujian->ruang . ' - ' . $ujian->gedung;
                            $id_jam = $ujian->id_jam;
                            $jam = $ujian->jam;
                        } else {
                            $id_ujian = '';
                            $tanggal = '';
                            $id_ruang = '';
                            $ruang = '-Pilih Ruang-';
                            $id_jam = '';
                            $jam = '-Pilih Jam-';
                        }
                        ?>

                        <input type="text" readonly name="tanggal" value="<?php echo $tanggal ?>" class="form-control pull-right" id="datepicker" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Ruang</label>
                    <select name="id_ruang" class="form-control select2" style="width: 100%;" required>
                        <option value="<?php echo $id_ruang ?>"><?php echo $ruang ?></option>
                        <?php
                        foreach ($mruang as $list) {
                            ?>
                            <option value="<?php echo $list['id_ruang'] ?>"><?php echo $list['ruang'] . ' - ' . $list['gedung'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jam</label>
                    <select name="id_jam" class="form-control select2" style="width: 100%;" required>
                        <option value="<?php echo $id_jam ?>"><?php echo $jam ?></option>
                        <?php
                        foreach ($mjam as $list) {
                            ?>
                            <option value="<?php echo $list['id_jam'] ?>"><?php echo $list['jam'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?php
                if ($skripsi->status_skripsi > STATUS_SKRIPSI_UJIAN_SETUJUI_KPS) {
                    echo 'Ujian sudah selesai';
                } else {
                    if ($ujian) {
                        //print_r($skripsi);die();
                        ?>
                        <button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i>  Perbarui</button>
                        <?php
                    } else {
                        ?>
                        <button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i>  Simpan</button>
                        <?php
                    }
                }
                ?>
            </div>
            <?php echo form_close() ?>
        </div>
        <!-- /.box -->
    </div>

    <!-- left column -->
    <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">2. Penguji</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('dashboardd/skripsi/kadep_blm_skripsi/penguji_plot_save'); ?>
            <div class="box-body table-responsive">
                <?php
                if ($ujian) {
                    ?>
                    <div class="form-group">
                        <label>Penguji</label>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                        <?php echo formtext('hidden', 'id_ujian', $nid_ujian->id_ujian, 'required') ?>
                        <select name="nip" class="form-control select2" style="width: 100%;" required>
                            <option value="">- Pilih Penguji -</option>
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
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                    <?php echo form_close() ?>
                    <?php
                    $ketua = $this->skripsi->read_pengujiketua($nid_ujian->id_ujian);
                    if ($ketua) {
                        echo '';
                    } else {
                        ?>
                        <div class="form-group">
                            <label>Catatan</label>
                            <p>Belum Set Ketua Penguji</p>
                        </div>
                        <?php
                    }
                    ?>
                    <?php echo form_close() ?>                
                    <div class="form-group">
                        <table class="table table-bordered">
                            <tr>
                                <th>Namas</th>
                                <th>Tim</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                            <?php
                            $penguji = $this->skripsi->read_penguji($ujian->id_ujian);
                            foreach ($penguji as $listpenguji) {
                                ?>
                                <tr>
                                    <td><?php echo $listpenguji['nama'] ?><br/><?php echo $listpenguji['nip'] ?></td>
                                    <td>
                                        <?php
                                        if ($listpenguji['status_tim'] == '1') {
                                            ?>
                                            <?php echo form_open('dashboardd/skripsi/kadep_blm_skripsi/penguji_update_statustim') ?>
                                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                            <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                                            <?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
                                            <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                                            <?php echo formtext('hidden', 'status_tim', '2', 'required'); ?>
                                            <button type="submit" class="btn btn-xs btn-primary"> Ketua</button>
                                            <?php echo form_close(); ?>
                                            <?php
                                        } else
                                        if ($listpenguji['status_tim'] == '2') {
                                            ?>
                                            <?php echo form_open('dashboardd/skripsi/kadep_blm_skripsi/penguji_update_statustim') ?>
                                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                            <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                                            <?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
                                            <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                                            <?php echo formtext('hidden', 'status_tim', '1', 'required'); ?>
                                            <button type="submit" class="btn btn-xs btn-primary"> Anggota</button>
                                            <?php echo form_close(); ?>
                                            <?php
                                        }
                                        ?>

                                        <!--pembimbing dan pengajuan penguji-->
                                        <?php
                                        if ($listpenguji['usulan_dosbing'] == '0') {
                                            
                                        } else
                                        if ($listpenguji['usulan_dosbing'] == '1') {
                                            ?>
                                            <a class="btn btn-xs btn-success" href="#"> Usulan pembimbing</a>
                                            <?php
                                        } else
                                        if ($listpenguji['usulan_dosbing'] == '2') {
                                            ?>
                                            <a class="btn btn-xs btn-success" href="#">Pembimbing</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($listpenguji['status'] == '1') {
                                            ?>
                                            <button type="submit" class="btn btn-xs btn-warning"> Belum Approve</button>
                                            <?php
                                        } else
                                        if ($listpenguji['status'] == '2') {
                                            ?>
                                            <button type="submit" class="btn btn-xs btn-success"> Approved</button>
                                            <?php
                                        } else
                                        if ($listpenguji['status'] == '3') {
                                            ?>
                                            <button type="submit" class="btn btn-xs btn-danger"> Rejected</button>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo form_open('dashboardd/skripsi/kadep_blm_skripsi/penguji_delete') ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_skripsi', $skripsi->id_skripsi, 'required') ?>
                                        <?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
                                        <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
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
