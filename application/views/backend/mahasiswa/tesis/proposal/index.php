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
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_PROPOSAL]); ?>
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
                    <th>Tesis</th>
                    <th>Pembimbing Utama</th>
                    <th>Pembimbing Kedua</th>
                    <!-- <th>Departemen</th> -->
                    <?php
                    if($biodata->id_prodi == S2_ILMU_HUKUM){
                    ?>
                        <th>Minat</th>
                    <?php
                    }
                    ?>
                    <th>Tanggal Pengajuan</th>
                    <th>Berkas Proposal</th>
                    <th>Status</th>
                    <th>Kontrol</th>
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
                            $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_PROPOSAL);
                            echo '<b>Judul : </b>'.$judul->judul.'<br>';
                            /*echo '<b>Latar Belakang : </b>'.$judul->latar_belakang.'<br>';
                            echo '<b>Rumusan Masalah Pertama : </b>'.$judul->rumusan_masalah_pertama.'<br>';
                            echo '<b>Rumusan Masalah Kedua : </b>'.$judul->rumusan_masalah_kedua.'<br>';
                            echo '<b>Rumusan Masalah Ketiga Dst. : </b>'.$judul->rumusan_masalah_lain.'<br>';
                            echo '<b>Penelusuran Artikel Internet : </b>'.$judul->penelusuran_artikel_internet.'<br>';
                            echo '<b>Penelusuran Artikel Repository UNAIR : </b>'.$judul->penelusuran_artikel_unair.'<br>';
                            echo '<b>Uraian Topik : </b>'.$judul->uraian_topik.'<br>';

                            if($list['berkas_orisinalitas'] != '') {
                                echo '<b>Berkas Orisinalitas : </b><a href="'.base_url().'assets/upload/mahasiswa/tesis/judul/'.$list['berkas_orisinalitas'].'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a><br>';
                            }*/

                            ?>

                            <span class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModalSelengkapnya<?= $judul->id_judul;?>">
                                <i class="fa fa-search"></i> Lihat Selengkapnya
                            </span>

                            <!-- Modal -->
                            <div class="modal fade" id="myModalSelengkapnya<?= $judul->id_judul;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Detail Tesis</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            echo '<b>Judul : </b>'.$judul->judul.'<br>';
                                            echo '<b>Latar Belakang : </b>'.$judul->latar_belakang.'<br>';
                                            echo '<b>Rumusan Masalah Pertama : </b>'.$judul->rumusan_masalah_pertama.'<br>';
                                            echo '<b>Rumusan Masalah Kedua : </b>'.$judul->rumusan_masalah_kedua.'<br>';
                                            echo '<b>Rumusan Masalah Ketiga Dst. : </b>'.$judul->rumusan_masalah_lain.'<br>';
                                            echo '<b>Penelusuran Artikel Internet : </b>'.$judul->penelusuran_artikel_internet.'<br>';
                                            echo '<b>Penelusuran Artikel Repository UNAIR : </b>'.$judul->penelusuran_artikel_unair.'<br>';
                                            echo '<b>Uraian Topik Pembeda : </b>'.$judul->uraian_topik.'<br>';

                                            if($list['berkas_orisinalitas'] != '') {
                                                echo '<b>Berkas Orisinalitas : </b><a href="'.base_url().'assets/upload/mahasiswa/tesis/judul/'.$list['berkas_orisinalitas'].'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a><br>';
                                            }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php 
                            $dosbing_satu = '<i>belum ditentukan</i>';
                            if($list['nip_pembimbing_satu'] != '' && $list['nip_pembimbing_satu'] != ''){
                                $dosbing_satu = '<b>'.$list['nama_pembimbing_satu'].'</b><br>'.$list['nip_pembimbing_satu'];
                            }
                            
                            echo $dosbing_satu.'<br>';
                            
                            if($list['nip_pembimbing_satu'] == '' && $list['status_pembimbing_satu'] == NULL) {
                                echo '';
                            } else if($list['nip_pembimbing_satu'] != '' && $list['status_pembimbing_satu'] == NULL) {
                                echo '<a class="btn btn-xs btn-warning pull-left" href="#">Menunggu Persetujuan</a>';
                            } else if($list['status_pembimbing_satu'] == '1') {
                                echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>';
                            } else if($list['status_pembimbing_satu'] == '2') {
                                echo '<a class="btn btn-xs btn-danger pull-left" href="#">
                                <i class="fa fa-close"></i> Ditolak</a>';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            $dosbing_dua = '<i>belum ditentukan</i>';
                            if($list['nip_pembimbing_dua'] != '' && $list['nip_pembimbing_dua'] != ''){
                                $dosbing_dua = '<b>'.$list['nama_pembimbing_dua'].'</b><br>'.$list['nip_pembimbing_dua'];
                            }
                                                        
                            echo $dosbing_dua.'<br>';

                            if($list['nip_pembimbing_dua'] == '' && $list['status_pembimbing_dua'] == NULL) {
                                echo '';
                            } else if($list['nip_pembimbing_dua'] != '' && $list['status_pembimbing_dua'] == NULL) {
                                echo '<a class="btn btn-xs btn-warning pull-left" href="#">Menunggu Persetujuan</a>';
                            } else if($list['status_pembimbing_dua'] == '1') {
                                echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>';
                            } else if($list['status_pembimbing_dua'] == '2') {
                                echo '<a class="btn btn-xs btn-danger pull-left" href="#">
                                <i class="fa fa-close"></i> Ditolak</a>';
                            }
                            ?>
                        </td>
                        <!-- <td><?php //echo $list['departemen'] ?></td> -->
                        <?php
                        if($biodata->id_prodi == S2_ILMU_HUKUM){
                        ?>
                            <td><?= $list['nm_minat']?></td>
                        <?php
                        }
                        ?>
                        <td><?= date('Y-m-d', strtotime($list['tgl_pengajuan_proposal'])) ?></td>
                        <td class="text-center">
                            <?php
                            if($list['berkas_proposal'] != '') {
                            ?>
                                <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                            <?php 
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL]); ?>
                            <?php if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_UJIAN) {
                                
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_proposal'], UJIAN_TESIS_PROPOSAL);
                                ?>
                                <?php 
                                
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            //if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_DIJADWALKAN) {
                            ?>
                            <a href="<?= base_url() ?>mahasiswa/tesis/proposal/info/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Detail</a>
                            <?php
                            //}
                            if ($list['status_proposal'] < STATUS_TESIS_PROPOSAL_UJIAN_SELESAI) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/proposal/edit/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Edit</a>
                                <?php
                                /*if($biodata->id_prodi == S2_KENOTARIATAN){
                                ?>
                                    <a href="<?= base_url() ?>mahasiswa/tesis/proposal/jadwal/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Ajukan Jadwal</a>
                                <?php
                                }*/
                            }

                            if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_UJIAN) {
                                $minApprovedByPembimbing1 = 0;
                                $minApprovedByPembimbing2 = 0;
                                $isReadyToPropose = false;
                                if($biodata->id_prodi == S2_ILMU_HUKUM)
                                {
                                    $minApprovedByPembimbing1 = 5;
                                    $minApprovedByPembimbing2 = 5;

                                    if ($this->tesis->get_total_bimbingan_tesis_approved1($list['id_tesis'], UJIAN_TESIS_MKPT) >= $minApprovedByPembimbing1 &&
                                    $this->tesis->get_total_bimbingan_tesis_approved2($list['id_tesis'], UJIAN_TESIS_MKPT) >= $minApprovedByPembimbing2)
                                    {
                                        $isReadyToPropose = true;
                                    }
                                }
                                else if($biodata->id_prodi == S2_KENOTARIATAN)
                                {
                                    $minApprovedByPembimbing1 = 4;
                                    $minApprovedByPembimbing2 = 4;

                                    if ($this->tesis->get_total_bimbingan_tesis_approved1($list['id_tesis'], UJIAN_TESIS_UJIAN) >= $minApprovedByPembimbing1 &&
                                    $this->tesis->get_total_bimbingan_tesis_approved2($list['id_tesis'], UJIAN_TESIS_UJIAN) >= $minApprovedByPembimbing2)
                                    {
                                        $isReadyToPropose = true;
                                    }
                                }

                                if($biodata->id_prodi == S2_ILMU_HUKUM){
                                    if ($list['status_mkpt'] < STATUS_TESIS_MKPT_PENGAJUAN && $list['status_proposal'] == STATUS_TESIS_PROPOSAL_UJIAN_SELESAI)
                                    {
                                        ?>
                                        <hr style = "margin:5px"/>
                                        <a href = "<?= base_url() ?>mahasiswa/tesis/mkpt/add/<?= $list['id_tesis'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-mail-forward"></i> Ajukan MKPT</a>
                                        <br><br><?php
                                    }
                                }
                                else if($biodata->id_prodi == S2_KENOTARIATAN)
                                {
                                    if ($list['status_tesis'] < STATUS_TESIS_UJIAN_PENGAJUAN && $list['status_proposal'] == STATUS_TESIS_PROPOSAL_UJIAN_SELESAI)
                                    {
                                        if($isReadyToPropose)
                                        {
                                        ?>
                                        <hr style = "margin:5px"/>
                                        <a href = "<?= base_url() ?>mahasiswa/tesis/ujian/add/<?= $list['id_tesis'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-mail-forward"></i> Ajukan Tesis</a>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                        <a href="<?= base_url() ?>mahasiswa/tesis/ujian/bimbingan/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-red"><i class="fa fa-calendar"></i> Bimbingan</a>
                                        <br><br>
                                        <span>Untuk mengajukan proposal, minimal bimbingan di setujui pembimbing 1 (<?= $minApprovedByPembimbing1 ?>) 
                                         dan di setujui pembimbing 2 (<?= $minApprovedByPembimbing2 ?>)</span><?php    
                                        }
                                    }
                                }
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