<div class="btn-group">
	<?php 
	foreach($prodi as $data){
	$id = $this->uri->segment(5) ? $this->uri->segment(5) : $max_id_prodi;
	?>
	    <a class="<?= ($id == $data['id_prodi']) ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/proposal/index/<?= $data['id_prodi']?>"><?= $data['jenjang'].' '.$data['nm_prodi'];?></a>   
    <?php
	}
	?>
</div>