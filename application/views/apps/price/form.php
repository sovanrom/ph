<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="form-group">
    <label for="price" class="col-sm-2 control-label">Price</label>
    <div class="col-sm-9">
    	<input type="text" name="price" value="<?php echo isset($price) ? $price->price : ''; ?>" class="form-control" id="price">
    </div>
</div>

<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-9">
        <textarea name="description" rows="3" class="form-control" id="description"><?php echo isset($price) ? $price->description : ''; ?></textarea>
    </div>
</div>