<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal " id="form_floor" action="<?php echo base_url(); ?>admin/floor/edit/<?php echo $floor->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>