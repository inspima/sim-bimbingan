<!DOCTYPE html>
<html>
<?php $this->load->view('backend/incl_sidebar/head') ?>
<body class="hold-transition skin-red sidebar-mini">
<input type="hidden" id="base_url" value="<?= base_url() ?>">
<div class="wrapper">

	<?php $this->load->view('backend/incl_sidebar/header') ?>
	<?php $this->load->view('backend/incl_sidebar/sidebar') ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<div class="row">
				<div class="col-md-8 col-xs-12"><font style="font-size: 21px;font-weight: 600"><?php echo $title ?> </font><font style="font-size: 15px;"> > <?php echo $subtitle ?> </font></div>
				<?php
					if (!empty($use_back)) {
						?>
						<div class="col-md-4 col-xs-12"><a class="btn bg-blue pull-right" href="<?php echo base_url() . $back_link ?>"><i class="fa fa-arrow-left"></i> Kembali</a></div>
						<?php
					}
				?>
			</div>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php $this->load->view($section) ?>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<?php $this->load->view('backend/incl_sidebar/footer') ?>

</div>
<!-- ./wrapper -->

<?php $this->load->view('backend/incl_sidebar/script') ?>
</body>
</html>
