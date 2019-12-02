<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<a href="<?php echo base_url(); ?>price/create" rel='add' class="btn btn-primary pull-right">
    <i class="entypo-plus-circled"></i>
    Add new
</a>
<br><br><br>
<table class="table table-bordered datatable" id="price">
    <thead>
        <tr>
            <th>#</th>
            <th>Price</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>