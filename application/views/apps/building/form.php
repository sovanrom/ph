    <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
           <label for="pref" class="col-sm-4 control-label">Pref</label>
           <div class="col-sm-8">
               <input type="text" name="pref" value="<?php echo isset($building) ? $building->pref : ''; ?>" class="form-control" id="pref">
           </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="rooms" class="col-sm-4 control-label">Rooms</label>
            <div class="col-sm-8">
                <input type="number" name="rooms" value="<?php echo isset($building) ? $building->rooms : ''; ?>" class="form-control" id="rooms">
            </div>
        </div>
    </div>
   
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="building_name_kh" class="col-sm-4 control-label">Building Khmer</label>
            <div class="col-sm-8">
                <input type="text" name="building_name_kh" value="<?php echo isset($building) ? $building->building_name_kh : ''; ?>" class="form-control" id="building_name_kh">
            </div>
        </div>
    </div>
     <div class="col-sm-6">
        <div class="form-group">
            <label for="contact_person" class="col-sm-4 control-label">Contact Person</label>
            <div class="col-sm-8">
                <input type="text" name="contact_person" value="<?php echo isset($building) ? $building->contact_person : ''; ?>" class="form-control" id="contact_person">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="building_name" class="col-sm-4 control-label">Building Latin</label>
            <div class="col-sm-8">
                <input type="text" name="building_name" value="<?php echo isset($building) ? $building->building_name : ''; ?>" class="form-control" id="building_name">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
           <label for="phone" class="col-sm-4 control-label">Phone</label>
           <div class="col-sm-8">
               <input type="text" name="phone" value="<?php echo isset($building) ? $building->phone : ''; ?>" class="form-control" id="phone">
           </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="type_id" class="col-sm-4 control-label">Type</label>
            <div class="col-sm-8">
                <input type="text" data-id="<?php echo isset($types) ? $types->type_id : ''; ?>" data-text="<?php echo isset($types)? $types->type:''; ?>"
                 name="type_id" value="<?php echo isset($types) ? $types->type_id : ''; ?>" class="form-control" id="type_id">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="email" class="col-sm-4 control-label">Email</label>
            <div class="col-sm-8">
                <input type="text" name="email" value="<?php echo isset($building) ? $building->email : ''; ?>" class="form-control" id="email">
            </div>
        </div>
    </div>
</div>

<div class="row">
   <div class="form-group">
       <label for="address" class="col-sm-2 control-label">Address</label>
       <div class="col-sm-9">
           <input type="text" name="address" value="<?php echo isset($building) ? $building->address : ''; ?>" class="form-control" id="address">
       </div>
   </div>
</div>

<div class="row">
    <div class="form-group">
        <label for="address1" class="col-sm-2 control-label">Address1</label>
        <div class="col-sm-9">
            <input type="text" name="address1" value="<?php echo isset($building) ? $building->address1 : ''; ?>" class="form-control" id="address1">
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <label for="address2" class="col-sm-2 control-label">Address2</label>
        <div class="col-sm-9">
            <input type="text" name="address2" value="<?php echo isset($building) ? $building->address2 : ''; ?>" class="form-control" id="address2">
        </div>
    </div>
</div>

<div class="row">   
    <div class="form-group">
        <label for="address3" class="col-sm-2 control-label">Address3</label>
        <div class="col-sm-9">
            <input type="text" name="address3" value="<?php echo isset($building) ? $building->address3 : ''; ?>" class="form-control" id="address2">
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-9">
            <textarea name="description" rows="3" class="form-control" id="description"><?php echo isset($building) ? $building->description : ''; ?></textarea>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="col-sm-4"></div>
            <div class="col-sm-8">
            <label>
                <input type="checkbox" id="status" name="status" <?php echo isset($building) ? $building->status == 1 ? 'checked': '' : 'checked'; ?> class="iCheck">
                Status
            </label>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .modal-dialog {
      min-width: 50%;
    }
    .col-sm-9{
        margin-left: 10px;
        width: 80%;
    }

</style>