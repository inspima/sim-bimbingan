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
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_PROPOSAL, 'prodi' => $biodata->id_prodi]); ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Tabel <?= $subtitle ?></h3>
        <div class="pull-right">
            <a class="btn btn-primary" href="<?= base_url() ?>mahasiswa/tesis/proposal/add">
                <i class="fa fa-plus"></i> TAMBAH</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Departemen</th>
                    <th>Pembimbing Utama</th>
                    <th>Pembimbing Kedua</th>
                    <th class="text-center">Berkas Ujian Proposal Tesis</th>
                    <th>Tanggal Pengajuan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Info</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($tesis as $list) {
                    ?>
                    <tr>
                        <td><?= $no.' '.$list['id_tesis']; ?></td>
                        <td><?php
                            $judul = $this->tesis->read_judul($list['id_tesis']);
                            echo '<b>Judul : </b>'.$judul->judul.'<br>';
                            if($biodata->id_prodi == S2_KENOTARIATAN){
                                echo '<b>Latar Belakang : </b>'.$judul->latar_belakang.'<br>';
                                echo '<b>Rumusan Masalah Pertama : </b>'.$judul->rumusan_masalah_pertama.'<br>';
                                echo '<b>Rumusan Masalah Kedua : </b>'.$judul->rumusan_masalah_kedua.'<br>';
                                echo '<b>Rumusan Masalah Ketiga Dst. : </b>'.$judul->rumusan_masalah_lain.'<br>';
                                echo '<b>Penelusuran Artikel Internet : </b>'.$judul->penelusuran_artikel_internet.'<br>';
                                echo '<b>Penelusuran Artikel Repository UNAIR : </b>'.$judul->penelusuran_artikel_unair.'<br>';
                                echo '<b>Uraian Topik :</b>'.$judul->uraian_topik.'<br>';
                                if($list['berkas_orisinalitas'] != '') {
                                    echo '<b>Berkas Orisinalitas : :</b><a href="'.base_url().'assets/upload/mahasiswa/tesis/proposal/'.$list['berkas_orisinalitas'].'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a>';
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo $list['departemen']; ?></td>
                        <td>
                            <?php 
                            if($list['nip_pembimbing_satu'] != NULL) {
                                echo $list['nama_pembimbing_satu'].'<br/>'; 
                                echo '<b>'.$list['nip_pembimbing_satu'].'</b><br/>';
                                if($list['status_pembimbing_satu'] == NULL) {
                                    echo '<a class="btn btn-xs btn-primary pull-left" href="#">
                                    <i class="fa fa-check"></i> Pengajuan</a>';
                                } 
                                else if($list['status_pembimbing_satu'] == '1') {
                                    echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Diterima</a>';
                                } 
                                else if($list['status_pembimbing_satu'] == '2') {
                                    echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Ditolak</a>';
                                }
                            }
                            else {
                                echo '<a class="btn btn-xs btn-warning pull-left" href="#">
                                <i class="fa fa-clock-o"></i> Belum Ditentukan</a>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if($list['nip_pembimbing_dua'] != NULL) {
                                echo $list['nama_pembimbing_dua'].'<br/>'; 
                                echo '<b>'.$list['nip_pembimbing_dua'].'</b><br/>';
                                if($list['status_pembimbing_satu'] == NULL) {
                                    echo '<a class="btn btn-xs btn-primary pull-left" href="#">
                                    <i class="fa fa-check"></i> Pengajuan</a>';
                                } 
                                else if($list['status_pembimbing_dua'] == '1') {
                                    echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Diterima</a>';
                                } 
                                else if($list['status_pembimbing_dua'] == '2') {
                                    echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                    <i class="fa fa-check"></i> Ditolak</a>';
                                }
                            }
                            else {
                                echo '<a class="btn btn-xs btn-warning pull-left" href="#">
                                <i class="fa fa-clock-o"></i> Belum Ditentukan</a>';
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if($list['berkas_proposal'] != '') {
                            ?>
                                <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                            <?php 
                            }
                            ?>
                        </td>
                        <td><?= date('Y-m-d', strtotime($list['tgl_pengajuan'])) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL, 'prodi' => $biodata->id_prodi]); ?>
                            <?php if (($biodata->id_prodi == S2_ILMU_HUKUM && $list['status_proposal'] > MIH_STATUS_TESIS_PROPOSAL_UJIAN) OR ($biodata->id_prodi == S2_KENOTARIATAN && $list['status_proposal'] > MKN_STATUS_TESIS_PROPOSAL_UJIAN)) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_proposal'], UJIAN_TESIS_PROPOSAL);
                                ?>
                                <?php if (($biodata->id_prodi == S2_ILMU_HUKUM && $list['status_tesis'] < MIH_STATUS_TESIS_UJIAN_PENGAJUAN && $list['status_proposal'] == MIH_STATUS_TESIS_PROPOSAL_UJIAN_SELESAI) OR ($biodata->id_prodi == S2_KENOTARIATAN && $list['status_tesis'] < MKN_STATUS_TESIS_UJIAN_PENGAJUAN && $list['status_proposal'] == MKN_STATUS_TESIS_PROPOSAL_UJIAN_SELESAI)):
                                    ?>
                                    <hr style = "margin:5px"/>
                                    <a href = "<?= base_url() ?>mahasiswa/tesis/ujian/add/<?= $list['id_tesis'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-mail-forward"></i> Ajukan Tesis</a>
                                    <?php
                                endif;
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            if (($biodata->id_prodi == S2_ILMU_HUKUM && $list['status_proposal'] > MIH_STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS) OR ($biodata->id_prodi == S2_KENOTARIATAN && $list['status_proposal'] > MKN_STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS)) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/proposal/info/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Detail</a>
                                <?php
                            }
                            if ($list['status_pembimbing_satu'] == '' && $list['status_pembimbing_dua'] == '') {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/proposal/edit/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Edit</a>
                                <?php
                            }
                            /*if ($list['status_proposal'] == STATUS_TESIS_PROPOSAL_DIJADWALKAN_KPS) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/proposal/jadwal/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Lihat Jadwal</a>
                                <?php
                            }*/
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