<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <link rel="icon" href="<?php echo base_url(); ?>assets/neon/images/favicon.ico">

    <title>Neon | Data Tables</title>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/css/neon-core.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/css/neon-theme.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/css/neon-forms.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/css/custom.css">

    <script src="<?php echo base_url(); ?>assets/neon/js/jquery-1.11.3.min.js"></script>

    <!--[if lt IE 9]><script src="<?php echo base_url(); ?>assets/neon/js/ie8-responsive-file-warning.js"></script><![endif]-->
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="page-body" data-url="<?php echo base_url(); ?>">
    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
    </script>
    <div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-menu-inner">
                <?php $this->load->view('apps/header'); ?>
                <?php $this->load->view('apps/menu'); ?>
            </div>
        </div>
        <div class="main-content">
            <div class="row">
                <div class="col-md-6 col-sm-8 clearfix">
                    <?php $this->load->view('apps/profile'); ?>
                    <?php $this->load->view('apps/notification'); ?>
                </div>
                <?php $this->load->view('apps/link'); ?>
            </div>
            <hr />
            <?php $this->load->view('apps/breadcrumb'); ?>
            <?php isset($content) ? $this->load->view($content) : ''; ?>
            <?php $this->load->view('apps/footer'); ?>
        </div>
    </div>
    <?php $this->load->view('apps/modal'); ?>

    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/js/datatables/datatables.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/js/select2/select2.css">

    <!-- Imported scripts on this page -->
    <script src="<?php echo base_url(); ?>assets/neon/js/datatables/datatables.js"></script>
    <script src="<?php echo base_url(); ?>assets/neon/js/select2/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/neon/js/fullcalendar/fullcalendar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/neon/js/neon-calendar.js"></script>
    
    <!-- Bottom scripts (common) -->
    <script src="<?php echo base_url(); ?>assets/neon/js/gsap/TweenMax.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/neon/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/neon/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/neon/js/joinable.js"></script>
    <script src="<?php echo base_url(); ?>assets/neon/js/resizeable.js"></script>
    <script src="<?php echo base_url(); ?>assets/neon/js/neon-api.js"></script>

    <!-- JavaScripts initializations and stuff -->
    <script src="<?php echo base_url(); ?>assets/neon/js/neon-custom.js"></script>

    <!-- Demo Settings -->
    <script src="<?php echo base_url(); ?>assets/neon/js/neon-demo.js"></script>

    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?php echo base_url(); ?>assets/apps/js/<?php echo $script; ?>.js"></script>
        <?php endforeach ?>
    <?php endif ?>

</body>
</html>