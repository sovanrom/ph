<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
    .modal-dialog {
        width: 50%;
    }
    th{
        text-align: center;
    }
</style>
<form role="form"  class="form-horizontal " id="form_room" action="<?php echo base_url(); ?>admin/room/bundlecreate" method="post">
    <div class="form-group">
        <label for="building_id" class="col-sm-3 control-label">Building</label>
        <div class="col-sm-6">
            <input type="text" data-id="<?php echo isset($room) ? $room->building_id : ''; ?>" data-text="<?php echo isset($room)? $room->building:''; ?>"
             name="building_id" value="<?php echo isset($room) ? $room->building_id : ''; ?>" class="form-control" id="building_id">
        </div>
    </div>
    <table class="table table-bordered" id="bundlecreate">
        <thead>
            <tr>
                <th>No</th>
                <th>Room Number</th>
                <th>Price</th>
                <th>Floor</th>
                <th>Start Water</th>
                <th>Start Elect</th>
            </tr>
        </thead>
        <tbody id="tbody"></tbody>
    </table>
</form>

<div style="display: none;">
<div id="floor">
    <select name="floor_id[]" class="form-control">
        <option>-</option>
        <?php foreach ($floors as $floor) :?>
            <option value="<?php echo $floor->id ?>"><?php echo $floor->name ?></option>
        <?php endforeach ?>
    </select>
</div>
</div>

<div  style="display: none;">
<div id="price">
     <select name="price[]" class="form-control">
        <option>-</option>
        <?php foreach ($prices as $price) :?>
            <option value="<?php echo $price->id ?>"><?php echo $price->price ?></option>
        <?php endforeach ?>
    </select>
</div>
</div>


   

