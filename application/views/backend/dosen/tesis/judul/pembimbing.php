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
<div class="btn-group">
    <?php 
    foreach($prodi as $data){
    $id = $this->uri->segment(5) ? $this->uri->segment(5) : $max_id_prodi;
    ?>
        <a class="<?= ($id == $data['id_prodi']) ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/judul/pembimbing/<?= $data['id_prodi']?>"><?= $data['jenjang'].' '.$data['nm_prodi'];?></a>   
    <?php
    }
    ?>
</div>
<div class="divider10"></div>
<div class="box">
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Tesis</th>
                    <th>Status Pembimbing</th>
                    <th>Departemen</th>                    
                    <th>Tanggal Pengajuan</th>
                    <th>Berkas Proposal</th>
                    <th>Berkas MKPT</th>
                    <th>Status</th>
                    <th>Opsi</th>
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
                        <td><?= '<b>' . $list['nama'] . '</b><br>' . $list['nim'].'<br>';?></td>
                        <td><?php
                            if($list['jenis'] == TAHAPAN_TESIS_JUDUL){ 
                                $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_JUDUL);
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_PROPOSAL){ 
                                $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_PROPOSAL);
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_MKPT){ 
                                $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_MKPT);
                            }
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
                            <?php
                            if ($list['nip_pembimbing_satu'] == $this->session_data['username']){
                                echo '<b>Pembimbing Utama</b><br>';
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
                                echo '<br><br>';
                                echo '<b>Pembimbing Kedua</b><br>';
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
                            }   
                            if ($list['nip_pembimbing_dua'] == $this->session_data['username']){
                                echo '<b>Pembimbing Utama</b><br>';
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
                                echo '<br><br>';
                                echo '<b>Pembimbing Kedua</b><br>';
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
                            }
                            ?>                            
                        </td>
                        <td><?= $list['departemen'] ?></td>
                        <td><?= date('d-m-Y', strtotime($list['tgl_pengajuan'])) ?></td>
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
                            <?php
                            if($list['berkas_mkpt'] != '') {
                            ?>
                                <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/mkpt/<?php echo $list['berkas_mkpt'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                            <?php 
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if($list['jenis'] == TAHAPAN_TESIS_JUDUL){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_JUDUL]); 
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_PROPOSAL){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL]); 
                                if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_UJIAN) {
                                    ?>
                                    <hr style="margin:5px"/>
                                    <b>Hasil Ujian</b><br/>
                                    <?php
                                    echo $this->tesis->get_status_ujian($list['status_ujian_proposal'], UJIAN_TESIS_PROPOSAL);
                                }
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_MKPT){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_MKPT]); 
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if($list['nip_pembimbing_satu'] == $this->session_data['username']){
                                if($list['status_pembimbing_satu'] == NULL) {
                                ?>
                                    <a class="btn btn-xs btn-success" href="<?= base_url()?>dosen/tesis/judul/approve_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Approve</a>
                                    <a class="btn btn-xs btn-danger" href="<?= base_url()?>dosen/tesis/judul/reject_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Reject</a>
                                <?php
                                } else if($list['status_pembimbing_satu'] != NULL && $list['nip_pembimbing_dua'] == NULL) {
                                ?>
                                    <a class="btn btn-xs btn-warning" href="<?= base_url()?>dosen/tesis/judul/batal_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Batal</a>
                                <?php
                                } 
                            } else if($list['nip_pembimbing_dua'] == $this->session_data['username']){
                                if($list['status_pembimbing_dua'] == NULL) {
                                ?>
                                    <a class="btn btn-xs btn-success" href="<?= base_url()?>dosen/tesis/judul/approve_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Approve</a>
                                    <a class="btn btn-xs btn-warning" href="<?= base_url()?>dosen/tesis/judul/reject_pembimbing/<?php echo $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Reject</a>
                                <?php
                                } else {
                                ?>
                                    <a class="btn btn-xs btn-warning" href="<?= base_url()?>dosen/tesis/judul/batal_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Batal</a>
                                <?php
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($list['nip_pembimbing_satu'] == $this->session_data['username']){
                                if($list['status_pembimbing_satu'] == '1' && $list['nip_pembimbing_dua'] == NULL){
                                ?>
                                    <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/judul/setting_pembimbing_kedua/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Setting Pembimbing Kedua</a><br>
                                <?php
                                }
                                if($list['jenis'] == TAHAPAN_TESIS_PROPOSAL && $list['status_proposal'] == STATUS_TESIS_PROPOSAL_PENGAJUAN){
                                ?>
                                    <a href="<?= base_url() ?>dosen/tesis/proposal/jadwal_pembimbing/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Lihat Jadwal & Penguji</a>
                                <?php
                                }
                                if($list['jenis'] == TAHAPAN_TESIS_MKPT && $list['status_mkpt'] == STATUS_TESIS_MKPT_PENGAJUAN){
                                ?>
                                    <a href="<?= base_url() ?>dosen/tesis/mkpt/pengampu/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Setting MKPT</a>
                                <?php
                                }
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