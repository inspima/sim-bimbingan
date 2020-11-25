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
<div class="box">

    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Info Disertasi</th>
                    <th class="text-center">MPKK</th>
                    <th class="text-center">Proposal</th>
                    <th class="text-center">MKPD</th>
                    <th class="text-center">Kelayakan</th>
                    <th class="text-center">Ujian Tertutup</th>
                    <th class="text-center">Ujian Terbuka</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($disertasi as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?>
                            <br/>
                            <b>Judul Disertasi : </b><br/>
                            <?php
                            echo $list['judul']
                            ?>
                            <hr style="margin: 10px 0px;border-width:2px;border-color: grey" />

                            <h4>Promotor & Ko-Promotor : </h4>
                            <?php $this->view('backend/widgets/disertasi/column_promotor', ['id_disertasi' => $list['id_disertasi']]); ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_MPKK]); ?><br/>
                            <div class="divider5"></div>
                            <?php
                            if ($list['status_mpkk'] > 0):
                                ?>
                                <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/mpkk/<?php echo $list['berkas_mpkk'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
                                <?php
                            endif;
                            ?>
                            <?php
                            if ($list['status_mpkk'] == STATUS_DISERTASI_MPKK_PENGAJUAN):
                                ?>
                                <hr style="margin: 10px;border-width:2px;" />
                                <?php echo form_open('dosen/disertasi/permintaan/promotor/mpkk/setujui') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <?php
                            endif;
                            ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_PROPOSAL]); ?>
                            <div class="divider5"></div>
                            <?php
                            if ($list['status_proposal'] > 0):
                                ?>
                                <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/mpkk/<?php echo $list['berkas_mpkk'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
                                <?php
                            endif;
                            ?>

                            <?php
                            if ($list['status_proposal'] == STATUS_DISERTASI_PROPOSAL_PENGAJUAN):
                                ?>
                                <hr style="margin: 10px;border-width:2px;" />
                                <?php echo form_open('dosen/disertasi/permintaan/promotor/proposal/setujui') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <?php
                            endif;
                            ?>
                            <?php if ($list['status_proposal'] >= STATUS_DISERTASI_PROPOSAL_SETUJUI_PROMOTOR && $list['status_proposal'] < STATUS_DISERTASI_PROPOSAL_SELESAI):
                                ?>
                                <hr style = "margin: 10px;border-width:2px;" />
                                <a href = "<?= base_url() ?>dosen/disertasi/proposal/setting/<?= $list['id_disertasi'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-edit"></i> Ujian & Penguji</a>
                                <?php
                            endif;
                            ?>
                        </td>
                        <td class = "text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_MKPD]); ?>
                            <div class="divider5"></div>
                            <?php
                            if ($list['status_mkpd'] > 0):
                                ?>
                                <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/mkpd/<?php echo $list['berkas_mkpd'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
                                <?php
                            endif;
                            ?>
                            <?php
                            if ($list['status_mkpd'] == STATUS_DISERTASI_MKPD_PENGAJUAN):
                                ?>
                                <hr style="margin: 10px;border-width:2px;" />
                                <?php echo form_open('dosen/disertasi/permintaan/promotor/mkpd/setujui') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <?php
                            endif;
                            ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_KELAYAKAN]); ?>
                            <div class="divider5"></div>
                            <?php
                            if ($list['status_kelayakan'] > 0):
                                ?>
                                <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/kelayakan/<?php echo $list['berkas_kelayakan'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
                                <?php
                            endif;
                            ?>
                            <?php
                            if ($list['status_kelayakan'] == STATUS_DISERTASI_KELAYAKAN_PENGAJUAN):
                                ?>
                                <hr style="margin: 10px;border-width:2px;" />
                                <?php echo form_open('dosen/disertasi/permintaan/promotor/kelayakan/setujui') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <?php
                            endif;
                            ?>
                            <?php if ($list['status_kelayakan'] >= STATUS_DISERTASI_KELAYAKAN_SETUJUI_PROMOTOR && $list['status_kelayakan'] < STATUS_DISERTASI_KELAYAKAN_SELESAI):
                                ?>
                                <hr style = "margin: 10px;border-width:2px;" />
                                <a href = "<?= base_url() ?>dosen/disertasi/kelayakan/setting/<?= $list['id_disertasi'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-edit"></i> Ujian & Penguji</a>
                                <?php
                            endif;
                            ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_TERTUTUP]); ?>
                            <div class="divider5"></div>
                            <?php
                            if ($list['status_tertutup'] > 0):
                                ?>
                                <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/tertutup/<?php echo $list['berkas_tertutup'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
                                <?php
                            endif;
                            ?>
                            <?php
                            if ($list['status_tertutup'] == STATUS_DISERTASI_TERTUTUP_PENGAJUAN):
                                ?>
                                <hr style="margin: 10px;border-width:2px;" />
                                <?php echo form_open('dosen/disertasi/permintaan/promotor/tertutup/setujui') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <?php
                            endif;
                            ?>
                            <?php if ($list['status_tertutup'] >= STATUS_DISERTASI_TERTUTUP_SETUJUI_PROMOTOR && $list['status_tertutup'] < STATUS_DISERTASI_TERTUTUP_SELESAI):
                                ?>
                                <hr style = "margin: 10px;border-width:2px;" />
                                <a href = "<?= base_url() ?>dosen/disertasi/tertutup/setting/<?= $list['id_disertasi'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-edit"></i> Ujian & Penguji</a>
                                <?php
                            endif;
                            ?>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_TERBUKA]); ?>
                            <div class="divider5"></div>
                            <?php
                            if ($list['status_terbuka'] > 0):
                                ?>
                                <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/terbuka/<?php echo $list['berkas_terbuka'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
                                <?php
                            endif;
                            ?>
                            <?php
                            if ($list['status_terbuka'] == STATUS_DISERTASI_TERBUKA_PENGAJUAN):
                                ?>
                                <hr style="margin: 10px;border-width:2px;" />
                                <?php echo form_open('dosen/disertasi/permintaan/promotor/terbuka/setujui') ?>
                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                                <?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
                                <?php
                            endif;
                            ?>
                            <?php if ($list['status_terbuka'] >= STATUS_DISERTASI_TERBUKA_SETUJUI_PROMOTOR && $list['status_terbuka'] < STATUS_DISERTASI_TERBUKA_SELESAI):
                                ?>
                                <hr style = "margin: 10px;border-width:2px;" />
                                <a href = "<?= base_url() ?>dosen/disertasi/terbuka/setting/<?= $list['id_disertasi'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-edit"></i> Ujian & Penyanggah</a>
                                <?php
                            endif;
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