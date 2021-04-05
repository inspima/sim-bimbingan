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
    <div class="col-sm-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">Informasi Tesis</h2>

            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <label>Pembimbing Utama</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                    <?php echo formtext('hidden', 'id_gelombang', $gelombang->id_gelombang, 'required') ?>
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
                    <?php $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_MKPT);?>
                    <textarea class="form-control" name="judul" readonly><?php echo $judul->judul?></textarea>
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
                <h3 class="box-title">Penilaian Pengampu MKPT</h3>
            </div>
            <?php echo form_open('dosen/tesis/mkpt/nilai_save'); ?>
            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
            <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
            <div class="box-body table-responsive">
                <div class="form-group">
                    <label>Mata Kuliah MKPT</label>
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 10%">Kode MK</th>
                            <th style="width: 25%">Nama MK</th>
                            <th style="width: 10%">SKS</th>
                            <th style="width: 25%">Dosen</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%">Nilai</th>
                            <th style="width: 10%">Status Ujian</th>
                            <th style="width: 10%">Publish Nilai</th>
                        </tr>
                        <?php
                        $tesis_mkpts = $this->tesis->read_tesis_mkpt($tesis->id_tesis);    
                        $hitung_nilai_publish = 0;
                        if (!empty($tesis_mkpts)) {
                            $sudah_publish_semua=$this->tesis->cek_mkpt_sudah_publish($tesis->id_tesis);
                            foreach ($tesis_mkpts as $index => $mkpt) {
                                $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                                foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                                    if($pengampu['status'] == '1' && $pengampu['nip'] == $this->session_data['username']){

                                        $status = '<button type="button" class="btn btn-xs btn-success"> Disetujui</button>';

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
                                            <td>'.$mkpt['kode'].'</td>
                                            <td>'.$mkpt['mkpt'].'</td>
                                            <td>'.$mkpt['sks'].'</td>
                                            <td><b>'.$pengampu['nip'].'</b><br>'.$pengampu['nama'].'</td>
                                            <td>'.$status.'</td>
                                            <td>'.(($mkpt['nilai_publish'] == NULL) ? '<input name="nilai_angka'.$mkpt['id_tesis_mkpt'].'" type="text" class="form-control" value="'.$pengampu['nilai_angka'].'">' : $pengampu['nilai_angka']).'</td>
                                            <td>'.(($mkpt['nilai_publish'] == NULL) ? '
                                                <select name="status_ujian'.$mkpt['id_tesis_mkpt'].'" class="form-control" style="width: 100%;">
                                                    <option value="1" '.($pengampu['status_ujian'] == '1' ? 'selected' : '').'>Lulus</option>
                                                    <option value="2" '.($pengampu['status_ujian'] == '2' ? 'selected' : '').'>Tidak Lulus</option>
                                                </select>' : $status_ujian[$pengampu['status_ujian']]).'
                                            </td>
                                            <td>'.(($mkpt['nilai_publish'] == NULL) ? '<a class="btn btn-xs btn-success" href="'.base_url().'dosen/tesis/mkpt/publish_nilai/'.$pengampu['id_tesis_mkpt_pengampu'].'/'.$mkpt['id_tesis'].'">
                                                <i class="fa fa-edit"></i> Publish Nilai</a>' : '<a class="btn btn-xs btn-warning" href="'.base_url().'dosen/tesis/mkpt/batal_publish_nilai/'.$pengampu['id_tesis_mkpt_pengampu'].'/'.$mkpt['id_tesis'].'">
                                                <i class="fa fa-edit"></i> Batal Publish Nilai</a>').'
                                            </td>
                                        </tr>
                                        ';
                                    }
                                    ?>
                                <?php
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php 
            if($hitung_nilai_publish == 0){
            ?>
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan & Publish Nilai</button>
                    <a class="btn btn-sm btn-warning" href="<?= base_url()?>dosen/tesis/permintaan/pembimbing/<?= $id_prodi?>"><i class="fa fa-close"></i> Batal</a>
                </div>
            <?php
            }
            ?>
            <?= form_close() ?>
        </div>
        <!-- /.box -->
    </div>


</div>