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

<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_PROPOSAL]); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $subtitle ?></h3>
                <div class="pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Judul</th>
                            <th>Departemen</th>
                            <th>Tgl.Pengajuan</th>
                            <th class="text-center">Penguji</th>
                            <th class="text-center">Jadwal</th>
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($disertasi as $list) {
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?></td>
                                <td>
                                    <?php
                                    $judul = $this->disertasi->read_judul($list['id_disertasi']);
                                    echo $judul->judul;
                                    ?>
                                </td>                            
                                <td><?php echo $list['departemen'] ?></td>
                                <td><?php echo toindo($list['tgl_pengajuan']) ?></td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/disertasi/column_penguji', ['id_disertasi' => $list['id_disertasi'], 'jenis' => UJIAN_DISERTASI_PROPOSAL]); ?>
                                </td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/disertasi/column_jadwal', ['id_disertasi' => $list['id_disertasi'], 'jenis' => UJIAN_DISERTASI_PROPOSAL]); ?>
                                </td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_PROPOSAL]); ?>
                                    <?php
                                    if ($list['status_proposal'] >= 4) {
                                        ?>
                                        <hr style="margin: 5px"/>
                                        <!-- Undangan -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('baa/doktoral/disertasi/proposal/cetak_undangan', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Undangan</button>
                                        <?php echo form_close() ?>                                         
                                        <hr style="margin: 2px"/>
                                        <!-- Berita Acara -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('baa/doktoral/disertasi/proposal/cetak_berita', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Berita Acara</button>
                                        <?php echo form_close() ?>                                        
                                        <hr style="margin: 2px"/>
                                        <!-- Penilaian -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('baa/doktoral/disertasi/proposal/cetak_penilaian', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Form Penilaian</button>
                                        <?php echo form_close() ?>                                      
                                        <hr style="margin: 2px"/>
                                        <!-- Daftar Hadir -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('baa/doktoral/disertasi/proposal/cetak_absensi', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Daftar Hadir</button>
                                        <?php echo form_close() ?>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>      
                            <?php
                            $no++;
                        }
                        ?>
                        </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>