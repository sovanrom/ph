<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_apartment" action="<?php echo base_url(); ?>admin/apartment/edit/<?php echo $apartment->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>