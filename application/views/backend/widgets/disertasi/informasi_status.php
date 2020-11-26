<div class="box box-default collapsed-box">
    <div class="box-header with-border">

        <h3 class="box-title">Informasi Status</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="display: none;">
        <?php
        if ($jenis == '1') :// KUALIFIKASI
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_KUALIFIKASI);
                $index = 0;
                foreach ($tahapan_statuses as $status):
                    if ($index > 0) {
                        ?>
                        <dt><label class="label <?= $status['color'] ?>"><?= $status['text'] ?></label></dt>
                        <dd><?= $status['keterangan'] ?> </dd>
                        <?php
                    }
                    $index++;
                endforeach;
                ?>

            </dl>
            <?php
        elseif ($jenis == '2') :// MPKK
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_MPKK);
                $index = 0;
                foreach ($tahapan_statuses as $status):
                    if ($index > 0) {
                        ?>
                        <dt><label class="label <?= $status['color'] ?>"><?= $status['text'] ?></label></dt>
                        <dd><?= $status['keterangan'] ?> </dd>
                        <?php
                    }
                    $index++;
                endforeach;
                ?>
            </dl>
            <?php
        elseif ($jenis == '3') :// PROPOSAL
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_PROPOSAL);
                $index = 0;
                foreach ($tahapan_statuses as $status):
                    if ($index > 0) {
                        ?>
                        <dt><label class="label <?= $status['color'] ?>"><?= $status['text'] ?></label></dt>
                        <dd><?= $status['keterangan'] ?> </dd>
                        <?php
                    }
                    $index++;
                endforeach;
                ?>
            </dl>
            <?php
        elseif ($jenis == '4') :// MKPD
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_MKPD);
                $index = 0;
                foreach ($tahapan_statuses as $status):
                    if ($index > 0) {
                        ?>
                        <dt><label class="label <?= $status['color'] ?>"><?= $status['text'] ?></label></dt>
                        <dd><?= $status['keterangan'] ?> </dd>
                        <?php
                    }
                    $index++;
                endforeach;
                ?>
            </dl>
            <?php
        elseif ($jenis == '5') :// KELAYAKAN
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_KELAYAKAN);
                $index = 0;
                foreach ($tahapan_statuses as $status):
                    if ($index > 0) {
                        ?>
                        <dt><label class="label <?= $status['color'] ?>"><?= $status['text'] ?></label></dt>
                        <dd><?= $status['keterangan'] ?> </dd>
                        <?php
                    }
                    $index++;
                endforeach;
                ?>
            </dl>
            <?php
        elseif ($jenis == '6') :// UJIAN TERTUTUP
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_TERTUTUP);
                $index = 0;
                foreach ($tahapan_statuses as $status):
                    if ($index > 0) {
                        ?>
                        <dt><label class="label <?= $status['color'] ?>"><?= $status['text'] ?></label></dt>
                        <dd><?= $status['keterangan'] ?> </dd>
                        <?php
                    }
                    $index++;
                endforeach;
                ?>
            </dl>
            <?php
        elseif ($jenis == '7') :// UJIAN TERBUKA
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_TERBUKA);
                $index = 0;
                foreach ($tahapan_statuses as $status):
                    if ($index > 0) {
                        ?>
                        <dt><label class="label <?= $status['color'] ?>"><?= $status['text'] ?></label></dt>
                        <dd><?= $status['keterangan'] ?> </dd>
                        <?php
                    }
                    $index++;
                endforeach;
                ?>
            </dl>
            <?php
        endif;
        ?>


    </div>
    <!-- /.box-body -->
</div>