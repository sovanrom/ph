<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_category" action="<?php echo base_url(); ?>admin/category/edit/<?php echo $category->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>