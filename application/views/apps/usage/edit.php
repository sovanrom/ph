<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_usage" action="<?php echo base_url(); ?>admin/usage/edit/<?php echo $usage->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>