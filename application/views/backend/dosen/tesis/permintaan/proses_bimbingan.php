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
        <a class="<?= ($id == $data['id_prodi']) ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/permintaan/pembimbing/<?= $data['id_prodi']?>"><?= $data['jenjang'].' '.$data['nm_prodi'];?></a>
    <?php
    }
    ?>
</div>
<hr>
<div class="btn-group">
    <a class="<?= ($this->uri->segment(4) == 'pembimbing' OR $this->uri->segment(4) == '') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/permintaan/pembimbing/<?= $id; ?>">Pengajuan Baru</a>
    <a class="<?= ($this->uri->segment(4) == 'proses_bimbingan' OR $this->uri->segment(4) == '') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/permintaan/proses_bimbingan/<?= $id; ?>">Aktif</a>
    <a class="<?= ($this->uri->segment(4) == 'riwayat' OR $this->uri->segment(4) == '') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/permintaan/riwayat/<?= $id; ?>">Riwayat</a> 
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
                    <!-- <th>Departemen</th> -->
                    <?php
                    if($id == S2_ILMU_HUKUM){
                    ?>
                        <th>Minat</th>
                    <?php
                    }
                    ?>                    
                    <th>Tanggal Pengajuan</th>
                    <th>Berkas Proposal</th>
                    <th>Berkas Tesis</th>
                    <th>Berkas Syarat Tesis</th>
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
                            if($list['jenis'] == TAHAPAN_TESIS_UJIAN){ 
                                $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_UJIAN);
                            }
                            echo '<b>Judul : </b>'.$judul->judul.'<br>';
                            

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
                        <!-- <td><?php //echo $list['departemen'] ?></td> -->
                        <?php
                        if($id == S2_ILMU_HUKUM){
                        ?>
                            <td><?= $list['nm_minat']?></td>
                        <?php
                        }
                        ?>
                        <td>
                            Judul : <?= date('d-m-Y', strtotime($list['tgl_pengajuan'])) ?><br>
                            Proposal : <?= date('d-m-Y', strtotime($list['tgl_pengajuan_proposal'])) ?><br>
                            <?php
                            if($id == S2_ILMU_HUKUM){
                            ?>
                                MKPT : <?= date('d-m-Y', strtotime($list['tgl_pengajuan_mkpt'])) ?><br>
                            <?php
                            }
                            ?>
                            Tesis : <?= date('d-m-Y', strtotime($list['tgl_pengajuan_tesis'])) ?>
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
                        <td class="text-center">
                            <?php
                            if($list['jenis'] == TAHAPAN_TESIS_JUDUL){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_JUDUL]); 
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_PROPOSAL){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL]); 
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_MKPT){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_MKPT]); 
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_UJIAN){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_UJIAN]); 
                            }
                            if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_UJIAN) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian Proposal</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_proposal'], UJIAN_TESIS_PROPOSAL);
                            }
                            if ($list['status_mkpt'] > STATUS_TESIS_MKPT_UJIAN) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian MKPT</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_mkpt'], UJIAN_TESIS_MKPT);
                            }
                            if ($list['status_tesis'] > STATUS_TESIS_UJIAN) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian Tesis</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_tesis'], UJIAN_TESIS_UJIAN);
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            //if($list['status_judul'] < STATUS_TESIS_JUDUL_SETUJUI_PEMBIMBING){
                            if($list['nip_pembimbing_satu'] == $this->session_data['username']){
                                if($list['status_pembimbing_satu'] == NULL) {
                                ?>
                                    <a class="btn btn-xs btn-success" href="<?= base_url()?>dosen/tesis/permintaan/approve_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Approve</a>
                                    <a class="btn btn-xs btn-danger" href="<?= base_url()?>dosen/tesis/permintaan/reject_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Reject</a>
                                <?php
                                } //else if($list['status_pembimbing_satu'] != NULL && $list['nip_pembimbing_dua'] == NULL) {
                                else if($list['status_proposal'] == NULL OR $list['status_proposal'] < STATUS_TESIS_PROPOSAL_PENGAJUAN) {
                                ?>
                                    <a class="btn btn-xs btn-warning" href="<?= base_url()?>dosen/tesis/permintaan/batal_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Batal</a>
                                <?php
                                } 
                            } else if($list['nip_pembimbing_dua'] == $this->session_data['username']){
                                if($list['status_pembimbing_dua'] == NULL) {
                                ?>
                                    <a class="btn btn-xs btn-success" href="<?= base_url()?>dosen/tesis/permintaan/approve_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Approve</a>
                                    <a class="btn btn-xs btn-warning" href="<?= base_url()?>dosen/tesis/permintaan/reject_pembimbing/<?php echo $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Reject</a>
                                <?php
                                } else if($list['status_proposal'] == NULL OR $list['status_proposal'] < STATUS_TESIS_PROPOSAL_PENGAJUAN) {
                                ?>
                                    <a class="btn btn-xs btn-warning" href="<?= base_url()?>dosen/tesis/permintaan/batal_pembimbing/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Batal</a>
                                <?php
                                }
                            }
                            //}
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($list['nip_pembimbing_satu'] == $this->session_data['username'] || $list['nip_pembimbing_dua'] == $this->session_data['username']){
                                if($list['status_pembimbing_satu'] == '1' && ($list['status_pembimbing_dua'] == NULL OR $list['status_pembimbing_dua'] == '2')){
                                ?>
                                    <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/judul/setting_pembimbing_kedua/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Setting Pembimbing Kedua</a><br>
                                <?php
                                }
                                if($list['jenis'] == TAHAPAN_TESIS_JUDUL && $list['status_judul'] == STATUS_TESIS_JUDUL_SETUJUI_PEMBIMBING){
                                ?>
                                    <a href="<?= base_url() ?>dosen/tesis/permintaan/bimbingan_proposal/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-red"><i class="fa fa-file"></i> Bimbingan Proposal</a><br>
                                <?php
                                }
                                if($list['jenis'] == TAHAPAN_TESIS_PROPOSAL && $list['status_proposal'] >= STATUS_TESIS_PROPOSAL_PENGAJUAN){
                                ?>
                                    <a href="<?= base_url() ?>dosen/tesis/proposal/jadwal_pembimbing/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Lihat Jadwal & Penguji Proposal</a><br><br>
                                <?php
                                }
                                if($list['jenis'] >= TAHAPAN_TESIS_MKPT && $id == S2_ILMU_HUKUM){
                                ?>
                                    <a href="<?= base_url() ?>dosen/tesis/mkpt/setting_pengampu/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> MKPT</a><br><br>
                                <?php
                                }
                                if(($list['jenis'] == TAHAPAN_TESIS_PROPOSAL && $list['status_proposal'] == STATUS_TESIS_PROPOSAL_UJIAN_SELESAI && $id == S2_KENOTARIATAN) 
                                || ($list['jenis'] == TAHAPAN_TESIS_MKPT && $list['status_mkpt'] == STATUS_TESIS_MKPT_UJIAN_SELESAI && $id == S2_ILMU_HUKUM)){
                                ?>
                                    <a href="<?= base_url() ?>dosen/tesis/permintaan/bimbingan_tesis/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-red"><i class="fa fa-file"></i> Bimbingan Tesis</a><br>
                                <?php
                                }
                                if($list['jenis'] == TAHAPAN_TESIS_UJIAN && $list['status_tesis'] >= STATUS_TESIS_UJIAN_PENGAJUAN){
                                ?>
                                    <a href="<?= base_url() ?>dosen/tesis/ujian/jadwal_pembimbing/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Lihat Jadwal & Penguji Tesis</a>
                                <?php
                                }
                                /*if($list['jenis'] == TAHAPAN_TESIS_MKPT && $list['status_mkpt'] == STATUS_TESIS_MKPT_DISETUJUI_DOSEN_MKPT){
                                ?>
                                    <a href="<?= base_url() ?>dosen/tesis/mkpt/setting/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Setting Ujian MKPT</a>
                                <?php
                                }*/
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