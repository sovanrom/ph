<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_receive" action="<?php echo base_url(); ?>admin/receive/edit/<?php echo $receives[0]->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>