<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal " id="form_supplier" action="<?php echo base_url(); ?>admin/supplier/edit/<?php echo $supplier->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>