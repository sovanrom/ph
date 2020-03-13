<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-9">
        <input type="text" name="name" value="<?php echo isset($floor) ? $floor->name : ''; ?>" class="form-control" id="name">
    </div>
</div>

<div class="form-group">
    <label for="pref" class="col-sm-2 control-label">Pref</label>
    <div class="col-sm-9">
        <input type="text" name="pref" value="<?php echo isset($floor) ? $floor->pref : ''; ?>" class="form-control" id="pref">
    </div>
</div>

<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-9">
        <textarea name="description" rows="3" class="form-control" id="description"><?php echo isset($floor) ? $floor->description : ''; ?></textarea>
    </div>
</div>
  

<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-9">
    <label>
        <input type="checkbox" id="status" name="status" <?php echo isset($floor) ? $floor->status == 1 ? 'checked': '' : 'checked'; ?> class="iCheck">
       <label for="status">Status</label>
    </label>
    </div>
</div>
