<!DOCTYPE html>
<html>
<?php $this->load->view('frontend/incl/head') ?>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php $this->load->view('frontend/incl/header') ?>
	<div class="content-wrapper">
		<div class="container-fluid">
			<section class="content">

				<?php $this->load->view($section) ?>
			</section>
		</div>
		<!-- /.container -->
	</div>
	<!-- /.content-wrapper -->
	<?php $this->load->view('frontend/incl/footer') ?>
</div>
<!-- ./wrapper -->
</body>
</html>
