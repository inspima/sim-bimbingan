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
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $subtitle ?></h3>
                <div class="pull-right">
                </div>
            </div>
            <!-- /.box-header -->

            <!-- /.box-body -->
            <div class="box-body">

				<?php $this->view('backend/widgets/skripsi/tab_link_baa_proposal'); ?>
                <hr/>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Judul</th>
                            <th>Berkas Proposal</th>
                            <th>Departemen</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Gelombang (Semester)</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->
</div>
