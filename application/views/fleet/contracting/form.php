<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="building_name" class="col-sm-3 control-label">Building Name</label>
            <div class="col-sm-9">
                <input type="text" name="building_name" value="<?php echo isset($manage_building) ? $manage_building->building_name_en : ''; ?>" class="form-control" id="building_name">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="address" class="col-sm-3 control-label">address</label>
            <div class="col-sm-9">
                <input type="text" name="address" value="<?php echo isset($manage_building) ? $manage_building->address : ''; ?>" class="form-control" id="address">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="rooms" class="col-sm-3 control-label">room</label>
            <div class="col-sm-9">
                <input type="text" name="rooms" value="<?php echo isset($manage_building) ? $manage_building->rooms : ''; ?>" class="form-control" id="rooms">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="address1" class="col-sm-3 control-label">address1</label>
            <div class="col-sm-9">
                <input type="text" name="address1" value="<?php echo isset($manage_building) ? $manage_building->address1 : ''; ?>" class="form-control" id="address1">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="contact_person" class="col-sm-3 control-label">Contact Person</label>
            <div class="col-sm-9">
                <input type="text" name="contact_person" value="<?php echo isset($manage_building) ? $manage_building->contact_person : ''; ?>" class="form-control" id="contact_person">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="address2" class="col-sm-3 control-label">address2</label>
            <div class="col-sm-9">
                <input type="text" name="address2" value="<?php echo isset($manage_building) ? $manage_building->address2 : ''; ?>" class="form-control" id="address2">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="phone" class="col-sm-3 control-label">Phone</label>
            <div class="col-sm-9">
                <input type="text" name="phone" value="<?php echo isset($manage_building) ? $manage_building->phone : ''; ?>" class="form-control" id="phone">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="address3" class="col-sm-3 control-label">address3</label>
            <div class="col-sm-9">
                <input type="text" name="address3" value="<?php echo isset($manage_building) ? $manage_building->address3 : ''; ?>" class="form-control" id="address2">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
                <input type="text" name="email" value="<?php echo isset($manage_building) ? $manage_building->email : ''; ?>" class="form-control" id="email">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
                <textarea name="description" rows="3" class="form-control" id="description"><?php echo isset($manage_building) ? $manage_building->description : ''; ?></textarea>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
            <label>
                <input type="checkbox" id="status" name="status" <?php echo isset($manage_building) ? $manage_building->status == 1 ? 'checked': '' : 'checked'; ?> class="minimal">
                Status
            </label>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        // $('input[type="checkbox"].minimal').iCheck({
        //     checkboxClass: 'icheckbox_minimal-blue'
        // });
    });
</script>
