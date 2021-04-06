<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $subtitle ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body">
                <div class="form-group">
                    <label>Pembimbing Utama</label>
                    <select name="nip_pembimbing_satu" class="form-control select2" style="width: 100%;" disabled>
                        <option value="">- Pilih -</option>
                        <?php
                        foreach ($mdosen as $list) {
                            $selected = '';
                            if($list['nip'] == $tesis->nip_pembimbing_satu){
                                $selected = 'selected';
                            }
                            else {
                                $selected = '';
                            }
                            ?>
                            <option value="<?php echo $list['nip'] ?>" <?php echo $selected;?> ><?php echo $list['nama'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pembimbing Kedua</label>
                    <select name="nip_pembimbing_dua" class="form-control select2" style="width: 100%;" disabled>
                        <option value="">- Pilih -</option>
                        <?php
                        foreach ($mdosen as $list) {
                            $selected = '';
                            if($list['nip'] == $tesis->nip_pembimbing_dua){
                                $selected = 'selected';
                            }
                            else {
                                $selected = '';
                            }
                            ?>
                            <option value="<?php echo $list['nip'] ?>" <?php echo $selected;?> ><?php echo $list['nama'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <?php $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_PROPOSAL);?>
                    <textarea class="form-control" name="judul" readonly><?php echo $judul->judul?></textarea>
                </div>
                <div class="form-group">
                <label>Mata Kuliah MKPT</label>
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 45%">Topik</th>
                            <th style="width: 10%">SKS</th>
                            <th style="width: 45%">Dosen</th>
                            <th style="width: 45%">Status</th>
                            <th style="width: 10%">Nilai</th>
                            <th style="width: 10%">Status Ujian</th>
                        </tr>
                        <?php
                        $tesis_mkpts = $this->tesis->read_tesis_mkpt($tesis->id_tesis); 
                        $hitung_pengampu_setuju = 0;   
                        $hitung_nilai_publish = 0;
                        if (!empty($tesis_mkpts)) {
                            $sudah_publish_semua=$this->tesis->cek_mkpt_sudah_publish($tesis->id_tesis);
                            foreach ($tesis_mkpts as $index => $mkpt) {
                                $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                                foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                                    if($pengampu['status'] == '1' OR $pengampu['status'] == '2'){
                                        if($pengampu['status'] == '1'){
                                        	$hitung_pengampu_setuju = $hitung_pengampu_setuju + 1;
                                            $status = '<button type="button" class="btn btn-xs btn-success"> Disetujui</button>';
                                        } 
                                        else if($pengampu['status'] == '2'){
                                            $status = '<button type="button" class="btn btn-xs btn-danger"> Ditolak</button>';
                                        }

                                        foreach ($mdosen as $list) {
                                            $dosen_mkpt = '';
                                            if($pengampu['nip'] == $list['nip']){
                                                $dosen_mkpt = $list['nama'];
                                            }
                                        }

                                        if($mkpt['nilai_publish'] != ''){
                                        	$hitung_nilai_publish = $hitung_nilai_publish + 1;
                                        }

                                        $status_ujian = ['1' => 'Lulus', '2' => 'Tidak Lulus', '0' => '', NULL => ''];

                                        echo '
                                        <tr>
                                            <td>'.$mkpt['mkpt'].'</td>
                                            <td>'.$mkpt['sks'].'</td>
                                            <td><b>'.$pengampu['nip'].'</b><br>'.$pengampu['nama'].'</td>
                                            <td>'.$status.'</td>
                                            <td>'.$pengampu['nilai_angka'].'</td>
                                            <td>'.$status_ujian[$pengampu['status_ujian']].'</td>
                                        </tr>
                                        ';
                                    }
                                    ?>
                                <?php
                                }
                            }
                        }
                        else {
                        ?>
                        <?php
                            for ($i = 1; $i <= 2; $i++) {
                                ?>
                                <tr>
                                    <td>
                                        <input name="kode<?=$i?>" type="text" class="form-control" >
                                    </td>
                                    <td>
                                        <textarea name="nama<?=$i?>" class="form-control" style="resize: none" ></textarea>
                                    </td>
                                    <td>
                                        <input name="sks<?=$i?>" type="number" class="form-control" >
                                    </td>
                                    <td>
                                        <select name="pengampu<?=$i?>[]" class="form-control select2" style="width: 100%;"  multiple>
                                            <option value="">- Pilih -</option>
                                            <?php
                                                foreach ($mdosen as $list) {
                                                    ?>
                                                    <option value="<?php echo $list['nip'] ?>"><?php echo $list['nip'].' - '.$list['nama'] ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Status Ujian</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <?php
                    if($hitung_nilai_publish == '2'){
                    ?>
                        <label>Status Ujian</label>
                        <?php 
                        foreach ($status_ujians as $status_ujian) {
                            if ($status_ujian['value'] == $tesis->status_ujian_mkpt) {
                                echo '<br>'.$status_ujian['text'];
                            }
                        }
                        ?>
                        
                    <?php
                    }
                    else {
                        echo "<b>Nilai belum lengkap</b>";
                    }
                    ?>
                </div>
            </div>
        <!-- /.box -->
    </div>
</div>