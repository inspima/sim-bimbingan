<div class="btn-group">
	<a class="<?= ($this->uri->segment(4) == '') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/disertasi/penilaian">MKPKK</a>
	<a class="<?= ($this->uri->segment(4) == 'mkpd') ? 'btn btn-default' : 'btn bg-yellow'; ?>" href="<?php echo base_url() ?>dosen/disertasi/penilaian/mkpd">MKPD</a>
</div>
