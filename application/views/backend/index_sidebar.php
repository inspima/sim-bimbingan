<!DOCTYPE html>
<html>
    <?php $this->load->view('backend/incl_sidebar/head') ?>
    <body class="hold-transition skin-red sidebar-mini">
        <div class="wrapper">

            <?php $this->load->view('backend/incl_sidebar/header') ?>
            <?php $this->load->view('backend/incl_sidebar/sidebar') ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <p>
                        <font style="font-size: 21px;font-weight: 600"><?php echo $title ?> </font><font style="font-size: 15px;"> > <?php echo $subtitle ?> </font>
                        <?php
                        if (!empty($use_back)) {
                            ?>
                            <a class="btn bg-blue pull-right" href="#" onclick="window.history.back();"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <?php
                        }
                        ?>
                    </p>
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
