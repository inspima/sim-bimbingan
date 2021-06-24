<table align="center" width="100%" border="0">
	<tbody>
	<tr>
		<td width="10%"><img src="assets/backend/cetak/logo.png" width="100px"></td>
		<td width="90%" align="center">
			<strong>
				<p style="font-size:17px;margin-bottom: 0px;">
					<?= strtoupper($this->setting->get_value('kementrian_txt')) ?><br>
					<?= strtoupper($this->setting->get_value('universitas_txt')) ?><br>
					<?= strtoupper($this->setting->get_value('universitas_fakultas_txt')) ?><br>
				</p>
			</strong>

			<p style="font-size:12px;margin: 0px 0 0px 0;">
				<?= $this->setting->get_value('universitas_alamat_txt') ?><br>
				<?= $this->setting->get_value('universitas_web_email_txt') ?>
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="line">&nbsp;
		</td>
	</tr>
	</tbody>
</table>
