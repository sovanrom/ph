<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="display: none;">
<div id="add" class="row pull-right" style="margin-left: 20px;margin-right: 5px;">   
    <a href="<?php echo base_url(); ?>admin/usage/bundlecreate" rel='addbundle' class="btn btn-info">
        <i class="entypo-plus-circled"></i>
        Bundle Entry
    </a>
    <a href="<?php echo base_url(); ?>admin/usage/create" rel='add' class="btn btn-info">
        <i class="entypo-plus-circled"></i>
        Add new
    </a>      
</div>
</div>

<div class="row">
    <div class="tab-content">
        <div class="tab-pane active">
            <table class="table table-bordered datatable" id="usage">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Room</th>
                        <th>Date</th>
                        <th>New Water Usage</th>
                        <th>Old Water Usage</th>
                        <th>Total Water Usage</th>
                        <th>New Elect Usage</th>
                        <th>Old Elect Usage</th>
                        <th>Total Elect Usage</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<style type="text/css">
    .tabs-vertical{
        width: 100%;
    }
</style>
