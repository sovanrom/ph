<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal " id="form_room" action="<?php echo base_url(); ?>admin/room/edit/<?php echo $room->id; ?>" method="post">
    <?php require_once 'form.php'; ?>
</form>