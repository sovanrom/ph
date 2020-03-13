<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal " id="form_vendor" action="<?php echo base_url(); ?>admin/vendor/edit/<?php echo $vendor->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>