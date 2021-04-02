<div class="btn-group">
	<a class="<?= ($this->uri->segment(4) == 'sarjana') ? 'btn btn-default' : 'btn btn-danger'; ?>" href="<?php echo base_url() ?>baa/utility/registrasi/sarjana">Sarjana</a>
	<a class="<?= ($this->uri->segment(4) == 'master') ? 'btn btn-default' : 'btn btn-primary'; ?>" href="<?php echo base_url() ?>baa/utility/registrasi/master">Master</a>
	<a class="<?= ($this->uri->segment(4) == 'doktor') ? 'btn btn-default' : 'btn btn-warning'; ?>" href="<?php echo base_url() ?>baa/utility/registrasi/doktor">Doktor</a>
</div>
