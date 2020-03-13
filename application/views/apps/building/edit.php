<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal " id="form_building" action="<?php echo base_url(); ?>admin/building/edit/<?php echo $building->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>