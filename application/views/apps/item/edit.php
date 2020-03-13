<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal " id="form_item" action="<?php echo base_url(); ?>admin/item/edit/<?php echo $item->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>