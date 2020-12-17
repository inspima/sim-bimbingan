<div class="btn-group">
    <a class="<?= ($this->uri->segment(3) == 'kualifikasi') ? 'btn btn-default' : 'btn bg-aqua'; ?>" href="<?php echo base_url() ?>dosen/disertasi/kualifikasi">Ujian Kualifikasi</a>
    <a class="<?= ($this->uri->segment(3) == 'promotor') ? 'btn btn-default' : 'btn bg-yellow'; ?>" href="<?php echo base_url() ?>dosen/disertasi/promotor">Pengajuan Promotor</a>
    <a class="<?= ($this->uri->segment(3) == 'mpkk') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/disertasi/mpkk">MKPKK</a>
    <a class="<?= ($this->uri->segment(3) == 'proposal') ? 'btn btn-default' : 'btn bg-teal-active'; ?>" href="<?php echo base_url() ?>dosen/disertasi/proposal">Ujian Proposal</a>
    <a class="<?= ($this->uri->segment(3) == 'mkpd') ? 'btn btn-default' : 'btn bg-green'; ?>" href="<?php echo base_url() ?>dosen/disertasi/mkpd">MKPD</a>
    <a class="<?= ($this->uri->segment(3) == 'kelayakan') ? 'btn btn-default' : 'btn bg-purple'; ?>" href="<?php echo base_url() ?>dosen/disertasi/kelayakan">Ujian Kelayakan</a>
    <a class="<?= ($this->uri->segment(3) == 'tertutup') ? 'btn btn-default' : 'btn bg-maroon'; ?>" href="<?php echo base_url() ?>dosen/disertasi/tertutup">Ujian Tertutup</a>
    <a class="<?= ($this->uri->segment(3) == 'terbuka') ? 'btn btn-default' : 'btn bg-red'; ?>" href="<?php echo base_url() ?>dosen/disertasi/terbuka">Ujian Terbuka</a>    
</div>