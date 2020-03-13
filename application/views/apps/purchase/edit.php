<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_purchase" action="<?php echo base_url(); ?>admin/purchase/edit/<?php echo $purchase->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>