<div class="btn-group">
    <a class="<?= ($this->uri->segment(3) == 'proposal') ? 'btn bg-yellow' : 'btn bg-aqua'; ?>" href="<?php echo base_url() ?>dosen/tesis/proposal">Ujian Proposal</a>
    <a class="<?= ($this->uri->segment(3) == 'tesis') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/tesis">Ujian Tesis</a>   
</div>