<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="display: none; ">
<a id="add" href="<?php echo base_url(); ?>admin/purchase/create" rel='add' class="btn btn-info pull-right" style="margin-left: 20px;">
    <i class="entypo-plus-circled"></i>
    Add new
</a>
</div>
<table class="table table-bordered datatable" id="purchase">
    <thead>
        <tr>
            <th>#</th>
            <th>Action</th>
            <th>Date</th>
            <th>Requested by</th>
            <th>Comment</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>