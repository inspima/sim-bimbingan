<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
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
                <dl>
                    <dt>Nama Dokumen</dt>
                    <dd><?= $dokumen->nama ?></dd>
                </dl>
                <dl>
                    <dt>Tanggal Dokumen</dt>
                    <dd><?php echo hari($dokumen->date) ?>, <?php echo woday_toindo($dokumen->date) ?></dd>
                </dl>
                <dl>
                    <dt>Untuk</dt>
                    <dd><?= $dokumen_persetujuan->nama ?> (<?= $dokumen_persetujuan->identitas ?>)</dd>
                </dl>
                <dl>
                    <dt>Status Persetujuan</dt>
                    <?php
                    if (!empty($dokumen_persetujuan->waktu)):
                        ?>
                        <dd><button class="btn btn-xs btn-danger">Belum disetujui</button> pada <span class="text-muted"><?= $dokumen_persetujuan->waktu ?></span></dd>
                        <?php
                    else:
                        ?>                        
                        <dd><button class="btn btn-xs btn-danger">Belum disetujui</button></dd>
                    <?php
                    endif;
                    ?>
                </dl>
                <?php
                if (empty($dokumen_persetujuan->waktu)):
                    ?>
                    <?php echo form_open('dokumen/persetujuan/save'); ?>
                    <?php echo formtext('hidden', '_token', rand(99999, 100000), 'required') ?>
                    <?php echo formtext('hidden', 'username', $dokumen_persetujuan->identitas, 'required') ?>
                    <?php echo formtext('hidden', 'id_dokumen_persetujuan', $dokumen_persetujuan->id_dokumen_persetujuan, 'required') ?>
                    <dl>
                        <dt>Masukkan Password</dt>
                        <dd>
                            <input type="password" name="password" class="form-control"/>
                        </dd>
                    </dl>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Setujui</button>
                    <?php
                    echo form_close();
                endif;
                ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>