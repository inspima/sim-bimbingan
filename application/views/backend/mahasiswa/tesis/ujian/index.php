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
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_UJIAN]); ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Tabel <?= $subtitle ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Pembimbing Utama</th>
                    <th>Pembimbing Kedua</th>
                    <th>Minat</th>
                    <th>Berkas Tesis</th>
                    <th>Berkas Syarat</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($tesis as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php
                            $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_UJIAN);
                            echo '<b>Judul : </b>'.$judul->judul.'<br>';
                            echo '<b>Latar Belakang : </b>'.$judul->latar_belakang.'<br>';
                            echo '<b>Rumusan Masalah Pertama : </b>'.$judul->rumusan_masalah_pertama.'<br>';
                            echo '<b>Rumusan Masalah Kedua : </b>'.$judul->rumusan_masalah_kedua.'<br>';
                            echo '<b>Rumusan Masalah Ketiga Dst. : </b>'.$judul->rumusan_masalah_lain.'<br>';
                            echo '<b>Penelusuran Artikel Internet : </b>'.$judul->penelusuran_artikel_internet.'<br>';
                            echo '<b>Penelusuran Artikel Repository UNAIR : </b>'.$judul->penelusuran_artikel_unair.'<br>';
                            echo '<b>Uraian Topik : </b>'.$judul->uraian_topik.'<br>';

                            if($list['berkas_orisinalitas'] != '') {
                                echo '<b>Berkas Orisinalitas : </b><a href="'.base_url().'assets/upload/mahasiswa/tesis/judul/'.$list['berkas_orisinalitas'].'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a><br>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $list['nama_pembimbing_satu'] ?><br/>
                            <b><?php echo $list['nip_pembimbing_satu'] ?></b><br/>
                            <?php
                            if($list['status_pembimbing_satu'] == NULL) {
                            ?>
                                <a class="btn btn-xs btn-primary pull-left" href="#">
                                <i class="fa fa-check"></i> Pengajuan</a>
                            <?php
                            } else if($list['status_pembimbing_satu'] == '1') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>
                            <?php
                            } else if($list['status_pembimbing_satu'] == '2') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Ditolak</a>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $list['nama_pembimbing_dua'] ?><br/>
                            <b><?php echo $list['nip_pembimbing_dua'] ?></b><br/>
                            <?php
                            if($list['status_pembimbing_dua'] == NULL) {
                            ?>
                                <a class="btn btn-xs btn-primary pull-left" href="#">
                                <i class="fa fa-check"></i> Pengajuan</a>
                            <?php
                            } else if($list['status_pembimbing_dua'] == '1') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>
                            <?php
                            } else if($list['status_pembimbing_dua'] == '2') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Ditolak</a>
                            <?php
                            }
                            ?>
                        </td>
                        <td><?= $list['nm_minat']?></td>
                        <td class="text-center">
                            <?php
                            if($list['berkas_tesis'] != '') {
                            ?>
                                <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/ujian/<?php echo $list['berkas_tesis'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                            <?php 
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if($list['berkas_syarat_tesis'] != '') {
                            ?>
                                <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/ujian/<?php echo $list['berkas_syarat_tesis'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                            <?php 
                            }
                            ?>
                        </td>
                        <td><?= date('Y-m-d', strtotime($list['tgl_pengajuan'])) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_UJIAN]); 
                            if ($list['status_tesis'] == STATUS_TESIS_UJIAN_DITOLAK){
                                echo '<br>
                                <b>Keterangan : </b><br>'.$list['keterangan_judul'];
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            if ($list['status_tesis'] > STATUS_TESIS_UJIAN_DIJADWALKAN) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/ujian/info/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Detail</a>
                                <?php
                            }
                            if ($list['status_pembimbing_satu'] == '' && $list['status_pembimbing_dua'] == '') {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/ujian/edit/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Edit</a>
                                <?php
                            }
                            if ($list['status_tesis'] == STATUS_TESIS_UJIAN_SETUJUI_BAA && $biodata->id_prodi == S2_KENOTARIATAN) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/ujian/jadwal/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Ajukan Jadwal</a>
                                <?php
                            }
                            if ($list['status_tesis'] == STATUS_TESIS_UJIAN_DIJADWALKAN) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/ujian/jadwal/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Lihat Jadwal</a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>      
                    <?php
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->