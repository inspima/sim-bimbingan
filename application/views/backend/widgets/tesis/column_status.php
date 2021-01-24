<?php
if ($jenis == TAHAPAN_TESIS_JUDUL_PROPOSAL): // PROPOSAL
    $status = $this->tesis->get_status_tahapan($tesis['status_judul_proposal'], TAHAPAN_TESIS_JUDUL_PROPOSAL);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
	<?php
elseif ($jenis == TAHAPAN_TESIS_PROPOSAL): // PROPOSAL
    $status = $this->tesis->get_status_tahapan($tesis['status_proposal'], TAHAPAN_TESIS_PROPOSAL);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>

	<?php
elseif ($jenis == TAHAPAN_TESIS_MKPT): // PROPOSAL
    $status = $this->tesis->get_status_tahapan($tesis['status_mkpt'], TAHAPAN_TESIS_MKPT);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == TAHAPAN_TESIS_UJIAN) :// UJIAN
    $status = $this->tesis->get_status_tahapan($tesis['status_tesis'], TAHAPAN_TESIS_UJIAN);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
    
endif;