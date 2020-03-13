<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<input type="hidden" name="room_id" value="<?php echo isset($checkup)? $checkup->id:''; ?>">
<input type="hidden" name="checkup_id" value="<?php echo isset($checkup)? $checkup->c_id:''; ?>">
<div class="form-group">
    <label for="type_id" class="col-sm-3 control-label">Type</label>
    <div class="col-sm-8">
       <!--  <input type="text" data-id="<?php echo isset($checkup) ? $checkup->type_id : ''; ?>" data-text="<?php echo isset($checkup)? $checkup->type:''; ?>"
         name="type_id" value="<?php echo isset($checkup) ? $checkup->type_id : ''; ?>" class="form-control" id="type_id"> -->
         <select name="type_id"  id="type_id" data-allow-clear="true"  >
             <?php foreach ($types as $type): ?>
                 <option value="<?php echo $type->id; ?>" <?php if(isset($checkup)) echo ($checkup->type_id == $type->id) ? 'selected': ''; ?>>
                     <?php echo $type->name; ?>
                 </option>
             <?php endforeach ?>
         </select>
    </div>
</div>
    
<!-- <div id="extend_day" style="display:<?php echo isset($checkup)? ($checkup->name == 'Extend day')? '': 'none': 'none'; ?>;"> -->
	<div class="form-group">
		<label for="start_date" class="col-sm-3 control-label">Start Date</label>
		<div class="col-sm-8">
	    <input type="text" name="start_date" value="<?php echo (isset($checkup)) ? ($checkup->start_date == null)? '': date("d-m-Y", strtotime($checkup->start_date)) : ''; ?>" class="form-control datepicker" id="start_date" autocomplete="off">
	     <span class="help-block error-message"></span>
	 	</div>
	</div>

	<div class="form-group">
		<label for="due_date" class="col-sm-3 control-label">Due Date</label>
		<div class="col-sm-8">
	    <input type="text" name="due_date" value="<?php echo (isset($checkup)) ?  ($checkup->due_date == null)? '': date("d-m-Y", strtotime($checkup->due_date)) : ''; ?>" class="form-control datepicker" id="due_date" autocomplete="off">
	     <span class="help-block error-message"></span>
	 	</div>
	</div>
    <div class="form-group">
     <label for="description" class="col-sm-3 control-label">Description</label>
     <div class="col-sm-8">
         <textarea name="description" class="form-control" rows="3"><?php echo isset($checkup)? $checkup->description:''; ?></textarea>
     </div>
 </div>
<!-- </div> -->
 

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <input type="checkbox" id="status" name="status" <?php echo isset($checkup) ? ($checkup->status == null)? 'checked': $checkup->status== 1 ? 'checked': '' : 'checked'; ?> class="icheck"> Status
    </div>
</div>
