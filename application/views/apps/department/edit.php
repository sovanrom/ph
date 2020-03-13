<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_departments" action="<?php echo base_url(); ?>admin/department/edit/<?php echo $department->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>