<div class="btn-group">
	<a class="<?= ($this->uri->segment(5) == 'pengajuan') ? 'btn btn-default' : 'btn btn-primary'; ?>" href="<?php echo base_url() ?>dosen/sarjana/kadep/proposal/pengajuan">Pengajuan</a>
	<a class="<?= ($this->uri->segment(5) == 'diterima') ? 'btn btn-default' : 'btn btn-success'; ?>" href="<?php echo base_url() ?>dosen/sarjana/kadep/proposal/diterima">Diterima</a>
	<a class="<?= ($this->uri->segment(5) == 'selesai') ? 'btn btn-default' : 'btn btn-danger'; ?>" href="<?php echo base_url() ?>dosen/sarjana/kadep/proposal/selesai">Selesai</a>
	<a class="<?= ($this->uri->segment(5) == 'ditolak') ? 'btn btn-default' : 'btn btn-warning'; ?>" href="<?php echo base_url() ?>dosen/sarjana/kadep/proposal/ditolak">Tidak Layak</a>
</div>
