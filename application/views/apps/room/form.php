<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="form-group">
    <label for="building_id" class="col-sm-4 control-label">Building</label>
    <div class="col-sm-7">
        <input type="text" data-id="<?php echo isset($room) ? $room->building_id : ''; ?>" data-text="<?php echo isset($room)? $room->building:''; ?>"
         name="building_id" value="<?php echo isset($room) ? $room->building_id : ''; ?>" class="form-control" id="building_id">
    </div>
</div>


<div class="form-group">
    <label for="floor_id" class="col-sm-4 control-label">Floor</label>
    <div class="col-sm-7">
        <input type="text" data-id="<?php echo isset($room) ? $room->floor_id : ''; ?>" data-text="<?php echo isset($room)? $room->floor:''; ?>"
         name="floor_id" value="<?php echo isset($room) ? $room->floor_id : ''; ?>" class="form-control" id="floor_id">
    </div>
</div>

<div class="form-group">
    <label for="name" class="col-sm-4 control-label">Room Number</label>
    <div class="col-sm-7">
        <input type="text" autocomplete="off" name="name" value="<?php echo isset($room) ? $room->name : ''; ?>" class="form-control" id="name">
    </div>
</div>


<div class="form-group">
    <label for="price" class="col-sm-4 control-label">Price</label>
    <div class="col-sm-7">
        <input type="text" data-id="<?php echo isset($room) ? $room->price_id : ''; ?>" data-text="<?php echo isset($room)? $room->price:''; ?>"
         name="price" value="<?php echo isset($room) ? $room->price_id : ''; ?>" class="form-control" id="price">
    </div>
</div>


<div class="form-group">
    <label for="begin_water" class="col-sm-4 control-label">Beginning Water Usage</label>
    <div class="col-sm-7">
        <input type="number" name="begin_water" value="<?php echo isset($room) ? $room->begin_water : ''; ?>" class="form-control" id="begin_water">
    </div>
</div>

<div class="form-group">
    <label for="begin_elect" class="col-sm-4 control-label">Beginning Electricity Usage</label>
    <div class="col-sm-7">
        <input type="number" name="begin_elect" value="<?php echo isset($room) ? $room->begin_elect : ''; ?>" class="form-control" id="begin_elect">
    </div>
</div>


<!--div class="form-group">
    <label for="new_water_usage" class="col-sm-3 control-label">New Water Usage</label>
    <div class="col-sm-6">
        <input type="text" name="new_water_usage" value="<?php echo isset($room) ? $room->new_water_usage : ''; ?>" class="form-control" id="new_water_usage">
    </div>
</div>

<div class="form-group">
    <label for="new_elect_usage" class="col-sm-3 control-label">New Elect Usage</label>
    <div class="col-sm-6">
        <input type="text" name="new_elect_usage" value="<?php echo isset($room) ? $room->new_elect_usage : ''; ?>" class="form-control" id="new_elect_usage">
    </div>
</div-->

<div class="form-group">
    <div class="col-sm-4"></div>
    <div class="col-sm-7">
    <label>
        <input type="checkbox" id="status" name="status" <?php echo isset($room) ? $room->status == 1 ? 'checked': '' : 'checked'; ?> class="iCheck">
        Status
    </label>
    </div>
</div>
   

