<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="display: none;">

<div id="add" class="row pull-right" style="margin-left: 20px;margin-right: 5px;">   
    <a href="<?php echo base_url(); ?>admin/room/bundlecreate" rel='addbundle' class="btn btn-info">
        <i class="entypo-plus-circled"></i>
        Bundle Entry
    </a>
    <a href="<?php echo base_url(); ?>admin/room/create" rel='add' class="btn btn-info pull-right" style="margin-left: 20px;">
        <i class="entypo-plus-circled"></i>
        Add new
    </a> 
</div>
</div>
<div class="row">
    <div class="col-sm-3"><h4 class="modal-title">Buildings</h4><br>
        <div class="tabs-vertical-env">
            <ul class="nav tabs-vertical">
                <?php
                   $is_active =true;
                    foreach ($buildings as $building) :?>
                    <li class="<?php echo ($is_active)  ? 'active': ''; ?>">
                        <a class="building-tab" href="<?php echo $building->id; ?>" data-building-id= "<?php echo $building->id; ?>"  data-toggle="tab">
                            <i class="entypo-dot"></i>
                            <?php echo $building->building_name;?>
                        </a>
                    </li>
                    <?php $is_active = false; ?>
                    <?php endforeach ?>
            </ul>
        </div>
    </div>
    
   
    <div class="col-sm-9">
    <h4 class="modal-title">Rooms List</h4><br>
    <div class="tab-content">
        <div class="tab-pane active">
            <table class="table table-bordered datatable" id="room">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Room Name</th>
                        <th>Building</th>
                        <th>Floor</th>
                        <th>Price</th>
                        <th>Beginning Water</th>
                        <th>Beginning Electricity</th>
                       
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    </div>
</div>
<style type="text/css">
    .tabs-vertical{
        width: 100%;
    }
</style>
