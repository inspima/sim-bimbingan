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
    <div class="col-sm-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">Informasi Tesis</h2>

            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><label>NIM</label></td>
                            <td><?php echo $tesis->nim ?></td>            
                        </tr>
                        <tr>
                            <td><label>Nama</label></td>
                            <td><?php echo $tesis->nama; ?></td>            
                        </tr>
                        <tr>
                            <td><label>Tesis</label></td>
                            <td>
                            <?php 
                                $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_UJIAN);
                                echo '<b>Judul : </b>'.$judul->judul.'<br>';
                                
                                if($tesis->berkas_orisinalitas != '') {
                                    echo '<b>Berkas Orisinalitas : </b><a href="'.base_url().'assets/upload/mahasiswa/tesis/judul/'.$tesis->berkas_orisinalitas.'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a><br>';
                                }
                            ?>
                            </td>            
                        </tr>
                        <tr>
                            <td><label>Pembimbing Utama</label></td>
                            <td>
                                <b><?php echo $tesis->nip_pembimbing_satu ?></b><br>
                                <?php echo $tesis->nama_pembimbing_satu ?>
                            </td>            
                        </tr>
                        <tr>
                            <td><label>Pembimbing Kedua</label></td>
                            <td>
                                <b><?php echo $tesis->nip_pembimbing_dua ?></b><br>
                                <?php echo $tesis->nama_pembimbing_dua ?>
                            </td>            
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-sm-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Informasi Jadwal</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <?php
                if (!empty($ujian)) {
                    ?>  
                    <div class="form-group">
                        <label>Tanggal</label>
                        <hr class="divider-line-thin"/>
                        <p>
                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;
                            <?php echo hari($ujian->tanggal) ?>, <?php echo woday_toindo($ujian->tanggal) ?>
                        </p>

                    </div>

                    <div class="form-group">
                        <label>Ruang</label>
                        <hr class="divider-line-thin"/>
                        <p>
                            <i class="fa fa-building-o"></i>&nbsp;&nbsp;
                            Ruang <?= $ujian->ruang . ' Gedung ' . $ujian->gedung ?>
                        </p>
                    </div>

                    <div class="form-group">
                        <label>Jam</label>
                        <hr class="divider-line-thin"/>
                        <p>
                            <i class="fa fa-clock-o"></i>&nbsp;&nbsp;
                            <?= $ujian->jam; ?>
                        </p>
                    </div>
                    <?php
                    if($ujian->link_zoom != ''){
                        echo '
                        <div class="form-group">
                            <label>Link Zoom</label>
                            <br>
                            '.$ujian->link_zoom.'
                        </div>';   
                    }
                    ?>
                    <?php
                } else {
                    ?>
                    <div class="form-group">
                        <p>Jadwal ujian belum ada</p>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (!empty($ujian)) {
                    if ($ujian->status_apv_kaprodi == '1') {
                        ?>
                        <p align="center"><b><i class="fa fa-check text-green"></i> Sudah Diverifikasi Kaprodi</b></p>
                        <!--
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Ubah Ruang</button>
                        -->
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- left column -->

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Penilaian Penguji</h3>
            </div>
            <?php echo form_open('dosen/tesis/ujian/penguji_nilai_save'); ?>
            <div class="box-body table-responsive">
                <?php
                $dosen_tim = '';
                $penguji_dosen = $this->tesis->read_penguji_id($id_penguji);
                foreach ($penguji_dosen as $pd) {
                    $dosen_tim = $pd['status_tim'];
                }
                if ($ujian) {
                    if(date('Y-m-d') >= $ujian->tanggal) {
                        $penguji = $this->tesis->read_penguji($ujian->id_ujian);
                        $total_seluruh_nilai_terbobot = 0;
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kriteria</th>
                                    <th>Bobot</th>
                                    <th>Nilai</th>
                                    <th>Nilai Terbobot</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $nilai = $this->tesis->read_kriteria_nilai();
                            $no = 0;
                            $nilai_ujian = 0;
                            $total_bobot = 0;
                            $total_nilai = 0;
                            $total_nilai_terbobot = 0;
                            foreach($nilai as $data) {
                                $nilai_penguji = $this->tesis->read_penilaian($id_penguji, $data['id']);
                                if(!empty($nilai_penguji)){
                                    $nilai_ujian = $nilai_penguji->nilai;
                                }
                                else {
                                    $nilai_ujian = 0;
                                }
                                $no++;
                                $total_bobot = $total_bobot + $data['bobot'];
                                $total_nilai = $total_nilai + $nilai_ujian;
                                $total_nilai_terbobot = $total_nilai_terbobot + ($nilai_ujian*$data['bobot']);

                                if($dosen_tim == '1'){
                                    echo '
                                    <tr>
                                        <td>'.$no.'</td>
                                        <td>'.$data['nama_kriteria_penilaian'].'</td>
                                        <td class="text-right">'.(number_format($data['bobot'],1)*100).'%</td>
                                        <td class="text-right"><input type="text" class="text-right form-control" size="10" name="nilai_'.$data['id'].'" value="'.number_format($nilai_ujian,1).'" id="nilai"></td>
                                        <td class="text-right">'.number_format(($nilai_ujian*$data['bobot']),1).'</td>
                                    </tr>';
                                }
                                else {
                                    echo '
                                    <tr>
                                        <td>'.$no.'</td>
                                        <td>'.$data['nama_kriteria_penilaian'].'</td>
                                        <td class="text-right">'.(number_format($data['bobot'],1)*100).'%</td>
                                        <td class="text-right"><input type="text" class="text-right" size="10" name="nilai_'.$data['id'].'" value="'.number_format($nilai_ujian,1).'" id="nilai" hidden="true">'.number_format($nilai_ujian,1).'</td>
                                        <td class="text-right">'.number_format(($nilai_ujian*$data['bobot']),1).'</td>
                                    </tr>';
                                }
                            }
                            $total_seluruh_nilai_terbobot = ($total_seluruh_nilai_terbobot + $total_nilai_terbobot)*count($penguji);
                            echo '
                            <tr>
                                <td colspan="2"><b>SKOR TOTAL</b></td>
                                <td class="text-right">'.(number_format($total_bobot,1)*100).'%</td>
                                <td class="text-right">'.number_format($total_nilai,1).'</td>
                                <td class="text-right">'.number_format($total_nilai_terbobot,1).'</td>
                            </tr>';
                            ?>
                            </tbody>
                        </table>
                        <?php
                        $rata_nilai_ujian = $ujian->rata_nilai_ujian ? number_format($ujian->rata_nilai_ujian,1) : 0;
                        $bobot_nilai_konversi = $ujian->bobot_nilai_konversi ? number_format($ujian->bobot_nilai_konversi,1) : 0;
                        $nilai_ujian = $ujian->nilai_ujian ? number_format($ujian->nilai_ujian,1) : 0;
                        ?>
                        <table class="table">
                            <tbody>
                                <!-- <tr>
                                    <td><b>RATA-RATA NILAI</b></td>
                                    <td class="text-right"><?php //echo $rata_nilai_ujian?></td>
                                </tr> -->
                                <tr>
                                    <td><b>BOBOT NILAI KONVERSI PUBLIKASI</b></td>
                                    <td class="text-right"><?= $bobot_nilai_konversi?></td>
                                </tr>
                                <tr>
                                    <td><b>NILAI UJIAN</b></td>
                                    <td class="text-right"><?= $nilai_ujian?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_penguji', $id_penguji, 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <br>
                        <b>Catatan :</b><br>
                        1. Nilai skor yang diberikan paling rendah 40 dan paling tinggi 100<br>
                        2. Skor Terbobot = bobot x nilai skor
                        <br><br>
                        <?php
                        if($dosen_tim == '1'){
                        ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan & Setujui Berita Acara</button>
                        </div>
                        <?php
                        } 
                        echo form_close() ?>
                        <?php
                    }
                    else {
                        echo "<b>Ujian belum dilaksanakan</b>";
                    }
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
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">4. Status Ujian</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('dosen/tesis/ujian/update_status_ujian'); ?>
            <div class="box-body">
                <div class="form-group">
                    <?php
                    if($ujian){
                        $penguji = $this->tesis->read_penguji($ujian->id_ujian);
                        $status_tim = '';
                        foreach ($penguji as $listpenguji) {
                            if($listpenguji['nip'] == $this->session_data['username']){
                                $status_tim = $listpenguji['status_tim'];
                            }
                        }
                        if(date('Y-m-d') >= $ujian->tanggal) {
                    ?>
                        <label>Status Ujian</label>
                        <select name="status_ujian" class="form-control select2" style="width: 100%;" required <?= ($status_tim != '1') ? 'disabled' : ''; ?>>
                            <?php
                            foreach ($status_ujians as $status_ujian) {
                                ?>
                                <option value="<?php echo $status_ujian['value'] ?>" <?php if ($status_ujian['value'] == $tesis->status_ujian_tesis) echo 'selected' ?>><?php echo $status_ujian['text'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    <?php
                        } else {
                            echo "<b>Ujian belum dilaksanakan</b>";
                        }
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label>Catatan Pelaksanaan Ujian</label>
                    <textarea class="form-control" name="catatan_ujian" id="catatan_ujian" required <?= ($status_tim != '1') ? 'disabled' : ''; ?>><?= $ujian->catatan_ujian ? $ujian->catatan_ujian : ''; ?></textarea>
                </div>
            </div>
            <div class="box-footer">
                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                <?php echo formtext('hidden', 'id_penguji', $id_penguji, 'required') ?>
                <?php
                if($ujian){
                    $penguji = $this->tesis->read_penguji($ujian->id_ujian);
                    $status_tim = '';
                    foreach ($penguji as $listpenguji) {
                        if($listpenguji['nip'] == $this->session_data['username']){
                            $status_tim = $listpenguji['status_tim'];
                        }
                    }
                    if(date('Y-m-d') >= $ujian->tanggal && $status_tim == '1') {
                        echo '<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Status Ujian</button>';
                    }
                }
                ?>
            </div>
            <!-- /.box-body -->
            <?php echo form_close() ?>
            <?php 
            if($tesis->status_ujian_tesis != '' OR $tesis->status_ujian_tesis != '0'){
                echo form_open('dosen/tesis/ujian/kirim_berita_acara'); ?>
                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                <?php echo formtext('hidden', 'id_penguji', $id_penguji, 'required') ?>
                <?php
                if($tesis->status_ujian_tesis != ''){
                    if($tesis->status_ujian_tesis == '3'){
                    ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tanggal Ujian Ulang (Hanya untuk keterangan di berita acara ujian tesis)</label>
                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="tanggal_ujian_ulang" value="<?php echo $dokumen->date_doc ? date('d/m/Y', strtotime($dokumen->date_doc)) : date('d/m/Y'); ?>" class="form-control pull-right" id="datepicker">
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    
                    echo '
                    <div class="box-footer">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan & Setujui Berita Acara</button>
                    </div>';
                }
                ?>
                <?php 
                echo form_close(); 
            }
            ?>
            <?php 
            if($tesis->status_ujian_tesis != '' AND $tesis->status_ujian_tesis = '3'){
                echo form_open('dosen/tesis/ujian/setting_ujian_ulang'); ?>
                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                <?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
                <?php                    
                    echo '
                    <div class="box-footer">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-cog"></i> Setting Ujian Ulang</button>
                    </div>';
                ?>
                <?php 
                echo form_close(); 
            }
            ?>
        </div>
        <!-- /.box -->
    </div>

</div>
<script type="text/javascript">
    function hitungNilai() {
        var rata = document.getElementById('rata_nilai_ujian').value;
        var bobot = document.getElementById('bobot_nilai_konversi').value;
        var result = parseFloat(rata) * parseFloat(bobot);
        if (!isNaN(result)) {
            document.getElementById('nilai_ujian').value = result;
        }
    }
</script>