<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_checkup" action="<?php echo base_url(); ?>admin/checkup/edit/<?php echo isset($checkup)? $checkup->id:''; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>