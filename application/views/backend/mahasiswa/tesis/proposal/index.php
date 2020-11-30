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

<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => '1']); ?>

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

                    <th colspan="2">Pembimbing</th>

                    <th class="text-center">Berkas</th>

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

                        <td><?= $no ?></td>

                        <td><?php

                            $judul = $this->tesis->read_judul($list['id_tesis']);

                            echo $judul->judul;

                            ?>

                        </td>

                        <td><?php echo $list['nama_pembimbing_satu'] ?><br/><b><?php echo $list['nip_pembimbing_satu'] ?></b></td>

                        <td><?php echo $list['nama_pembimbing_dua'] ?><br/><b><?php echo $list['nip_pembimbing_dua'] ?></b></td>

                        <td class="text-center">

                            <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>

                        </td>

                        <td><?= date('Y-m-d', strtotime($list['tgl_pengajuan'])) ?></td>

                        <td>

                                <?php 

                                if($list['status_proposal'] == '1')

                                {

                                ?>

                                    <a class="btn btn-xs btn-primary pull-left" href="#">

                                    <i class="fa fa-check"></i> Pengajuan</a>

                                <?php

                                }

                                else

                                if($list['status_proposal'] == '2')

                                {

                                ?>

                                    <a class="btn btn-xs btn-success pull-left" href="#">

                                    <i class="fa fa-check"></i> Diterima</a>

                                <?php

                                }

                                else

                                if($list['status_proposal'] == '3')

                                {

                                ?>

                                    <a class="btn btn-xs btn-success pull-left" href="#">

                                    <i class="fa fa-check"></i> Selesai</a>

                                <?php

                                }

                                else

                                if($list['status_proposal'] == '4')

                                {

                                ?>

                                    <a class="btn btn-xs btn-danger pull-left" href="#">

                                    <i class="fa fa-check"></i> Ditolak</a>

                                <?php

                                }

                                else

                                if($list['status_proposal'] == '5')

                                {

                                ?>

                                    <a class="btn btn-xs btn-success pull-left" href="#">

                                    <i class="fa fa-check"></i> Dijadwalkan</a>

                                <?php

                                }

                                ?>

                            </td>

                            <td>

                            <?php 

                                if($list['status_proposal'] == '1')

                                {

                                ?>

                                    <a class="btn btn-xs btn-warning pull-left" href="<?= base_url()?>mahasiswa/tesis/proposal/edit/<?= $list['id_tesis']?>">

                                    <i class="fa fa-edit"></i> Edit</a>

                                <?php

                                }

                                else

                                if($list['status_proposal'] == '2')

                                {

                                ?>

                                <?php

                                }

                                else

                                if($list['status_proposal'] == '3')

                                {

                                ?>

                                <?php

                                }

                                else

                                if($list['status_proposal'] == '4')

                                {

                                ?>

                                <?php

                                }

                                ?>

                                <a class="btn btn-xs btn-primary pull-left" href="<?= base_url()?>mahasiswa/tesis/proposal/info/<?= $list['id_tesis']?>"><i class="fa fa-calendar"></i> Detail Ujian</a>

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