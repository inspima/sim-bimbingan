<div class="btn-group">
	<a class="<?= ($this->uri->segment(4) == 'kualifikasi') ? 'btn btn-default' : 'btn bg-aqua'; ?>" href="<?php echo base_url() ?>prodi/doktoral/disertasi/kualifikasi">Ujian Kualifikasi</a>
	<a class="<?= ($this->uri->segment(4) == 'promotor') ? 'btn btn-default' : 'btn bg-teal'; ?>" href="<?php echo base_url() ?>prodi/doktoral/disertasi/promotor">Promotor</a>
	<a class="<?= ($this->uri->segment(4) == 'proposal') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>prodi/doktoral/disertasi/proposal">Ujian Proposal</a>
	<a class="<?= ($this->uri->segment(4) == 'kelayakan') ? 'btn btn-default' : 'btn bg-green'; ?>" href="<?php echo base_url() ?>prodi/doktoral/disertasi/kelayakan">Ujian Kelayakan</a>
	<a class="<?= ($this->uri->segment(4) == 'tertutup') ? 'btn btn-default' : 'btn bg-orange'; ?>" href="<?php echo base_url() ?>prodi/doktoral/disertasi/tertutup">Ujian Tertutup</a>
	<a class="<?= ($this->uri->segment(4) == 'terbuka') ? 'btn btn-default' : 'btn bg-red'; ?>" href="<?php echo base_url() ?>prodi/doktoral/disertasi/terbuka">Ujian Terbuka</a>
</div>
