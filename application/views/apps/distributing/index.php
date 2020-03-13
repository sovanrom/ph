<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- <a href="<?php echo base_url(); ?>admin/distributing/create" rel='add' class="btn btn-primary pull-right">
    <i class="entypo-plus-circled"></i> Add new
</a> -->
<div class="row">
    <div class="col-sm-2">
<select  id="purchase" class="form-control pull-left" style="width: 200px;">
    <option value="">Select Purchase ID </option>
    <?php foreach ($purchases as $purchase) :?>
        <option value="<?php echo $purchase->id; ?>"><?php echo $purchase->id; ?></option>
    <?php endforeach ?>
</select>
</div>
</div>

<br>

<form role="form"  class="form-horizontal " id="form_distributing" action="<?php echo base_url(); ?>admin/distributing/create" method="post">

    <table class="table table-bordered" id="distributing">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Department</th>
                <th>Confirm</th>
            </tr>
        </thead>
        <tbody id="tbody"></tbody>
    </table>
</form>
<br>
<div class="row">
    <button id="click_submit" class="btn btn-info pull-right" style="margin-right: 20px;">Save</button>
</div>

<div style="display: none;">
    <select id="department" name="department" class="form-control">
        <option value="">-</option>
        <?php foreach ($departments as $department) : ?>
            <option value="<?php echo $department->id ?>">
                <?php echo $department->name ?>
            </option>
        <?php endforeach ?>
    </select>
</div>

<style type="text/css">
    tr{
        text-align: center;
    }
</style>

