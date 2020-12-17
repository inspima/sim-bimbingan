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
                <?php $this->view('backend/widgets/tesis/informasi_tesis_judul', ['tesis' => $tesis]); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Penilaian Penguji</h3>
            </div>
            <?php echo form_open('dosen/tesis/ujian/penguji_nilai_save'); ?>
            <div class="box-body table-responsive">
                <?php
                if ($ujian) {
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
                                <td class="text-right"><input type="text" class="text-right form-control" size="10" name="nilai_'.$data['id'].'" value="'.number_format($nilai_ujian,1).'" id="nilai"></td>
                                <td class="text-right">'.number_format(($nilai_ujian*$data['bobot']),1).'</td>
                            </tr>';
                        }
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
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_penguji', $id_penguji, 'required') ?>
                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                    <br>
                    <b>Catatan :</b><br>
                    1. Nilai skor yang diberikan paling rendah 40 dan paling tinggi 100<br>
                    2. Skor Terbobot = bobot x nilai skor
                    <br><br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan & Setujui Berita Acara</button>
                    </div>

                    <?php echo form_close() ?>
                    <?php
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