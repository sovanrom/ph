<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_user" action="<?php echo base_url(); ?>admin/user/edit/<?php echo $user->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>