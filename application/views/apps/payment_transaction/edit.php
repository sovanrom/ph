<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form role="form" class="form-horizontal" id="form_payment_transaction" action="<?php echo base_url(); ?>admin/payment_transaction/edit/<?php echo $payment_transaction->id; ?>" method="post">
    <?php require_once 'edit_form.php'; ?>
</form>