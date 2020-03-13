<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="display: none;">
<a id="add" href="<?php echo base_url(); ?>admin/receive/create" rel='add' class="btn btn-info pull-right" style="margin-left: 20px;">
    <i class="entypo-plus-circled"></i>
    Receive
</a>
</div>
<table class="table table-bordered datatable" id="receive">
    <thead>
        <tr>
            <th>#</th>
            <th>Action</th>
            <!-- <th>Id</th> -->
            <th>Item</th>
            <th>Quantity</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>