<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-9">
    	<input type="text" name="name" value="<?php echo isset($type) ? $type->name : ''; ?>" class="form-control" id="name">
    </div>
</div>

<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-9">
        <textarea name="description" rows="3" class="form-control" id="description"><?php echo isset($type) ? $type->description : ''; ?></textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-9">
        <input type="checkbox" id="status" name="status" <?php echo isset($type) ? $type->status == 1 ? 'checked': '' : 'checked'; ?> class="icheck">
        <label for="status">Status</label>
    </div>
</div>
