<div class="btn-group">

    <a class="<?= ($this->uri->segment(4) == 'proposal') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>baa/magister/tesis/proposal">Ujian Proposal</a>

    <a class="<?= ($this->uri->segment(4) == 'tesis') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>baa/magister/tesis/ujian">Ujian Tesis</a>   

</div>