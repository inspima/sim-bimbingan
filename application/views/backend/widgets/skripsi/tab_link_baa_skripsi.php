<div class="btn-group">
	<a class="<?= ($this->uri->segment(4) == 'index') ? 'btn btn-default' : 'btn btn-info'; ?>" href="<?php echo base_url() ?>baa/sarjanah/skripsi/index">Belum Daftar</a>
	<a class="<?= ($this->uri->segment(4) == 'pengajuan') ? 'btn btn-default' : 'btn btn-primary'; ?>" href="<?php echo base_url() ?>baa/sarjanah/skripsi/pengajuan">Pengajuan</a>
	<a class="<?= ($this->uri->segment(4) == 'diterima') ? 'btn btn-default' : 'btn btn-success'; ?>" href="<?php echo base_url() ?>baa/sarjanah/skripsi/diterima">Diterima</a>
	<a class="<?= ($this->uri->segment(4) == 'ujian') ? 'btn btn-default' : 'btn btn-danger'; ?>" href="<?php echo base_url() ?>baa/sarjanah/skripsi/ujian">Ujian</a>
	<a class="<?= ($this->uri->segment(4) == 'belum_approve') ? 'btn btn-default' : 'btn btn-warning'; ?>" href="<?php echo base_url() ?>baa/sarjanah/skripsi/belum_approve">Penguji - Belum Approve</a>
</div>
