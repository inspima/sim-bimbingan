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
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_MPKK]); ?>
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
                    <th>Judul</th>
					<th>Penasehat</th>
                    <th>Berkas</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Info</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($disertasi as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php
                            $judul = $this->disertasi->read_judul($list['id_disertasi']);
                            echo $judul->judul;
                            ?>
                        </td>
						<td><?php echo $list['nama_penasehat'] ?><br/><b><?php echo $list['nip_penasehat'] ?></b></td>
						<td>
                            <a href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/mpkk/<?php echo $list['berkas_mpkk'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                        </td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_MPKK]); ?>
                            <?php if ($list['status_mpkk'] >= STATUS_DISERTASI_MPKK_SELESAI && $list['status_proposal'] < STATUS_DISERTASI_PROPOSAL_PENGAJUAN) {
                                ?>
                                <hr style = "margin:5px"/>
                                <a href = "<?= base_url() ?>mahasiswa/disertasi/proposal/add/<?= $list['id_disertasi'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-mail-forward"></i> Ajukan Proposal</a>
                                <?php
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php if ($list['status_mpkk'] >= STATUS_DISERTASI_MPKK_PENGAJUAN) {
                                ?>
                                <a href="<?= base_url() ?>mahasiswa/disertasi/mpkk/info/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Detail</a>
                                <?php
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
