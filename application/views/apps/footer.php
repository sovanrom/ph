<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
    <?php $this->load->view('apps/breadcrumb'); ?>
    <?php isset($content) ? $this->load->view($content) : ''; ?>

    <footer class="main">
        &copy; 2016 <strong>Developed by Team</strong>.
    </footer>

</div>
</div>
<?php $this->load->view('apps/modal'); ?>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/js/datatables/datatables.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/js/select2/select2.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/js/datetimepicker/datetimepicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/neon/js/icheck/skins/square/_all.css">

<!-- Imported scripts on this page -->
<script src="<?php echo base_url(); ?>assets/neon/js/datatables/datatables.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/select2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/datetimepicker/datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/neon-calendar.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/icheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/moment.js"></script>

<!-- Bottom scripts (common) -->
<script src="<?php echo base_url(); ?>assets/neon/js/gsap/TweenMax.min.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/joinable.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/resizeable.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/neon-api.js"></script>
<script src="<?php echo base_url(); ?>assets/neon/js/bootstrap3-typeahead.min.js"></script>

<!-- JavaScripts initializations and stuff -->
<script src="<?php echo base_url(); ?>assets/neon/js/neon-custom.js"></script>


<?php if (isset($scripts)): ?>
    <?php foreach ($scripts as $script): ?>
        <script src="<?php echo base_url(); ?>assets/apps/js/<?php echo $script; ?>.js"></script>
    <?php endforeach ?>
<?php endif ?>

</body>
</html>