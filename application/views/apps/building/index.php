<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="display: none;">
<?php if ($GP['building-add']): ?>
    <a id="add" href="<?php echo base_url(); ?>admin/building/create" rel='add' class="btn btn-info pull-right" style="margin-left: 20px;">
        <i class="entypo-plus-circled"></i>
        Add new
    </a>
<?php endif ?>
</div>
<table class="table table-bordered datatable" id="building">
    <thead>
        <tr>
            <th>#</th>
            <th>#</th>
            <th>Building Name</th>
            <th>Pref</th>
            <th>Building Type</th>
            <th>Rooms</th>
            <th>Contact Person</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Description</th>
            <th>Address</th>
           <!--  <th>Address1</th>
            <th>Address2</th>
            <th>Address3</th> -->
        </tr>
    </thead>
    <tbody></tbody>
</table> 