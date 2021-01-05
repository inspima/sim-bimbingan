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
                    <label>NIM</label>
                    <hr class="divider-line-thin"/>
                    <?php echo $tesis->nim ?>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <hr class="divider-line-thin"/>
                    <?php echo $tesis->nama ?>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <hr class="divider-line-thin"/>
                    <?php
                    $judul = $this->tesis->read_judul($tesis->id_tesis);
                    ?>
                    <?php echo $judul->judul ?>
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
                <h3 class="box-title">Penilaian Penguji</h3>
            </div>
            <div class="box-body table-responsive">
                <?php
                if ($ujian) {
                    $penguji = $this->tesis->read_penguji($id_ujian);
                    $no_penguji = 0;
                    echo form_open('baa/tesis/ujian/nilai_ujian_save');
                    $total_seluruh_nilai_terbobot = 0;
                    foreach($penguji as $data_penguji)
                    {
                        $no_penguji++;
                        $id_penguji = $data_penguji['id_penguji'];
                        echo '<b>'.$no_penguji.'. '.$data_penguji['nip'].' '.$data_penguji['nama'].'</b><br><br>';
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
                                echo '
                                <tr>
                                    <td>'.$no.'</td>
                                    <td>'.$data['nama_kriteria_penilaian'].'</td>
                                    <td class="text-right">'.(number_format($data['bobot'],1)*100).'%</td>
                                    <td class="text-right">'.number_format($nilai_ujian,1).'</td>
                                    <td class="text-right">'.number_format(($nilai_ujian*$data['bobot']),1).'</td>
                                </tr>';
                            }
                            $total_seluruh_nilai_terbobot = $total_seluruh_nilai_terbobot + $total_nilai_terbobot;
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
                    }
                    $rata_nilai_ujian = $ujian->rata_nilai_ujian ? number_format($ujian->rata_nilai_ujian,1) : 0;
                    $bobot_nilai_konversi = $ujian->bobot_nilai_konversi ? number_format($ujian->bobot_nilai_konversi,1) : 0;
                    $nilai_ujian = $ujian->nilai_ujian ? number_format($ujian->nilai_ujian,1) : 0;
                    ?>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><b>Rata-rata Nilai</b></td>
                                <td><input type="text" class="form-control" name="rata_nilai_ujian" id="rata_nilai_ujian" value="<?php echo number_format(($total_seluruh_nilai_terbobot/count($penguji)),1);?>" value="<?= $rata_nilai_ujian?>" readonly></td>
                            </tr>
                            <tr>
                                <td><b>Bobot Nilai Konversi</b></td>
                                <td><input onkeyup="hitungNilai()" type="text" class="form-control" name="bobot_nilai_konversi" id="bobot_nilai_konversi" value="<?= $bobot_nilai_konversi?>"></td>
                            </tr>
                            <tr>
                                <td><b>Nilai Ujian</b></td>
                                <td><input type="text" class="form-control" name="nilai_ujian" id="nilai_ujian" value="<?= $nilai_ujian?>" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    echo '
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan Nilai Ujian</button>
                    </div>';
                    echo form_close();
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