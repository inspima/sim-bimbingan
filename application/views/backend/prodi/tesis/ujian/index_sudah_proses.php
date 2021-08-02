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
    <a class="<?= ($this->uri->segment(4) == 'index' OR $this->uri->segment(4) == '') ? 'btn btn-default' : 'btn bg-aqua'; ?>" href="<?php echo base_url() ?>prodi/tesis/ujian/index">Pengajuan</a>
    <a class="<?= ($this->uri->segment(4) == 'index_sudah_proses') ? 'btn btn-default' : 'btn bg-yellow'; ?>" href="<?php echo base_url() ?>prodi/tesis/ujian/index_sudah_proses">Sudah Diproses</a>
</div>
<?php //$this->view('backend/widgets/tesis/tab_link_program_studi_baa'); ?>
<div class="divider10"></div>
<?php //$this->view('backend/widgets/tesis/tab_link_persetujuan_dosen'); ?>
<!--<div class="divider10"></div>-->
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_UJIAN]); ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Tabel <?= $subtitle ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="datatable-export" class="