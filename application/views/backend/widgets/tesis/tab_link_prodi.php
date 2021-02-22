<div class="btn-group">

    <a class="<?= ($this->uri->segment(4) == 'judul') ? 'btn btn-default' : 'btn bg-aqua'; ?>" href="<?php echo base_url() ?>prodi/magister/tesis/judul">Judul</a>
    <a class="<?= ($this->uri->segment(4) == 'proposal') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>prodi/magister/tesis/proposal">Proposal</a>
    <a class="<?= ($this->uri->segment(4) == 'mkpt') ? 'btn btn-default' : 'btn bg-green'; ?>" href="<?php echo base_url() ?>prodi/magister/tesis/mkpt">MKPT</a>
    <a class="<?= ($this->uri->segment(4) == 'ujian') ? 'btn btn-default' : 'btn bg-orange'; ?>" href="<?php echo base_url() ?>prodi/magister/tesis/ujian">Tesis</a>   

</div>