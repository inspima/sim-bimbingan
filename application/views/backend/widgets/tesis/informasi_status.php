<div class="box box-info collapsed-box">
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
        if ($jenis == TAHAPAN_TESIS_JUDUL) :// JUDUL PROPOSAL
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->tesis->read_status_tahapan(TAHAPAN_TESIS_JUDUL);
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
        elseif ($jenis == TAHAPAN_TESIS_PROPOSAL) :// PROPOSAL
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->tesis->read_status_tahapan(TAHAPAN_TESIS_PROPOSAL);
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
        elseif ($jenis == TAHAPAN_TESIS_MKPT) :// MKPT
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->tesis->read_status_tahapan(TAHAPAN_TESIS_MKPT);
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
        elseif ($jenis == TAHAPAN_TESIS_UJIAN) :// UJIAN
            ?>
            <dl style="margin-left: 20px">
                <?php
                $tahapan_statuses = $this->tesis->read_status_tahapan(TAHAPAN_TESIS_UJIAN);
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