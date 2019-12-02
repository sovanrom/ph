<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal form-groups-bordered" id="form_price" action="<?php echo base_url(); ?>price/edit/<?php echo $price->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>