<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_actual_stock" action="<?php echo base_url(); ?>admin/actual_stock/edit/<?php echo $actual_stock->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>