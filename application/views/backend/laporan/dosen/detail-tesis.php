<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header bg-primary ">
				<h3 class="box-title" style="color: white">Informasi Dosen</h3>
				<div class="pull-right">
				</div>
			</div>
			<div class="box-body">
				<table class="table table-condensed">
					<tr>
						<td style="width: 15%">Nama</td>
						<td><b><?=$pegawai->nama ?></b></td>
					</tr>
					<tr>
						<td>NIP</td>
						<td><b><?=$pegawai->nip ?></b></td>
					</tr>
					<tr>
						<td>Sebagai</td>
						<td><b><?=$sebagai ?></b></td>
					</tr>
				</table>
			</div>

		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-body">

				<table class="datatable-report table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Mahasiswa</th>
						<th>Tesis</th>
						<th>Status</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($laporans as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= '<b>' . $list['nama'] . '</b><br>' . $list['nim'].'<br>';?></td>
								<td><?php
										if($list['jenis'] == TAHAPAN_TESIS_JUDUL){
											$judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_JUDUL);
										}
										if($list['jenis'] == TAHAPAN_TESIS_PROPOSAL){
											$judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_PROPOSAL);
										}
										if($list['jenis'] == TAHAPAN_TESIS_MKPT){
											$judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_MKPT);
										}
										if($list['jenis'] == TAHAPAN_TESIS_UJIAN){
											$judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_UJIAN);
										}
										echo '<b>Judul : </b>'.$judul->judul.'<br>';


									?>

									<span class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModalSelengkapnya<?= $judul->id_judul;?>">
                                <i class="fa fa-search"></i> Lihat Selengkapnya
                            </span>

									<!-- Modal -->
									<div class="modal fade" id="myModalSelengkapnya<?= $judul->id_judul;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog modal-lg" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Detail Tesis</h4>
												</div>
												<div class="modal-body">
													<?php
														echo '<b>Judul : </b>'.$judul->judul.'<br>';
														echo '<b>Latar Belakang : </b>'.$judul->latar_belakang.'<br>';
														echo '<b>Rumusan Masalah Pertama : </b>'.$judul->rumusan_masalah_pertama.'<br>';
														echo '<b>Rumusan Masalah Kedua : </b>'.$judul->rumusan_masalah_kedua.'<br>';
														echo '<b>Rumusan Masalah Ketiga Dst. : </b>'.$judul->rumusan_masalah_lain.'<br>';
														echo '<b>Penelusuran Artikel Internet : </b>'.$judul->penelusuran_artikel_internet.'<br>';
														echo '<b>Penelusuran Artikel Repository UNAIR : </b>'.$judul->penelusuran_artikel_unair.'<br>';
														echo '<b>Uraian Topik Pembeda : </b>'.$judul->uraian_topik.'<br>';

														if($list['berkas_orisinalitas'] != '') {
															echo '<b>Berkas Orisinalitas : </b><a href="'.base_url().'assets/upload/mahasiswa/tesis/judul/'.$list['berkas_orisinalitas'].'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a><br>';
														}
													?>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
										</div>
									</div>
								</td>
								<td class="text-center">
									<?php
										if($list['jenis'] == TAHAPAN_TESIS_JUDUL){
											$this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_JUDUL]);
										}
										if($list['jenis'] == TAHAPAN_TESIS_PROPOSAL){
											$this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL]);
										}
										if($list['jenis'] == TAHAPAN_TESIS_MKPT){
											$this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_MKPT]);
										}
										if($list['jenis'] == TAHAPAN_TESIS_UJIAN){
											$this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_UJIAN]);
										}
									?>
								</td>
							</tr>
							<?php
							$no++;
						}
					?>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
