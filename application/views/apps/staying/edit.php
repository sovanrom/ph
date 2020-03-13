<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal " id="form_staying" action="<?php echo base_url(); ?>admin/staying/edit/<?php echo $staying->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>