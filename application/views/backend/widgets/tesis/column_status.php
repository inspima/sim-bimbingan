<?php
if ($jenis == '1'): // PROPOSAL
    $status = $this->tesis->get_status_tahapan($tesis['status_proposal'], 1);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == '2') :// UJIAN
    $status = $this->tesis->get_status_tahapan($tesis['status_skripsi'], 2);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
    
endif;