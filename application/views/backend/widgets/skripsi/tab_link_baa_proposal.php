<div class="btn-group">
	<a class="<?= ($this->uri->segment(4) == 'index') ? 'btn btn-default' : 'btn btn-info'; ?>" href="<?php echo base_url() ?>baa/sarjanah/proposal/index">Pengajuan</a>
	<a class="<?= ($this->uri->segment(4) == 'diterima') ? 'btn btn-default' : 'btn btn-primary'; ?>" href="<?php echo base_url() ?>baa/sarjanah/proposal/diterima">Diterima</a>
	<a class="<?= ($this->uri->segment(4) == 'selesai') ? 'btn btn-default' : 'btn btn-succes'; ?>s" href="<?php echo base_url() ?>baa/sarjanah/proposal/selesai">Selesai</a>
	<a class="<?= ($this->uri->segment(4) == 'ditolak') ? 'btn btn-default' : 'btn btn-danger'; ?>" href="<?php echo base_url() ?>baa/sarjanah/proposal/ditolak">Ditolak</a>
	<a class="<?= ($this->uri->segment(4) == 'belum_approve') ? 'btn btn-default' : 'btn btn-warning'; ?>" href="<?php echo base_url() ?>baa/sarjanah/proposal/belum_approve">Penguji - Belum Approve</a>
</div>
