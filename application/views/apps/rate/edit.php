<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_rate" action="<?php echo base_url(); ?>admin/rate/edit/<?php echo $rate->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>