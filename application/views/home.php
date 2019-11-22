<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/apps/img/ape.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url(); ?>assets/apps/img/ape.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/plugins/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/plugins/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/plugins/datetimepicker/datetimepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/plugins/wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/plugins/datatables.net-bs/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/apps/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <?php $this->load->view('apps/sidebar/menu'); ?>
            </section>
        </aside>

        <div class="content-wrapper">
            <?php isset($content) ? $this->load->view($content) : ''; ?>
        </div>
        <!-- <?php $this->load->view('apps/modal'); ?> -->
    </div>

    <script src="<?php echo base_url(); ?>assets/apps/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/apps/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/apps/plugins/datatables/datatables.js"></script>
    <script src="<?php echo base_url(); ?>assets/apps/plugins/datatables.net-bs/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/apps/plugins/iCheck/icheck.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/apps/plugins/datetimepicker/datetimepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/apps/plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/apps/plugins/wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/apps/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/apps/plugins/fastclick/fastclick.js"></script>
</body>
</html>