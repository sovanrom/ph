<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal form-groups-bordered" id="form_manage_building" action="<?php echo base_url(); ?>manage_building/edit/<?php echo $manage_building->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>