<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-group">
    <label for="pref" class="col-sm-2 control-label">Pref</label>
    <div class="col-sm-9">
    	<input type="text" name="pref" value="<?php echo isset($category) ? $category->pref : ''; ?>" class="form-control" id="pref">
    </div>
</div>

<div class="form-group">
    <label for="khmer" class="col-sm-2 control-label">Khmer</label>
    <div class="col-sm-9">
        <input type="text" name="khmer" value="<?php echo isset($category) ? $category->khmer : ''; ?>" class="form-control" id="khmer">
    </div>
</div>

<div class="form-group">
    <label for="latin" class="col-sm-2 control-label">latin</label>
    <div class="col-sm-9">
        <input type="text" name="latin" value="<?php echo isset($category) ? $category->latin : ''; ?>" class="form-control" id="latin">
    </div>
</div>

<div class="form-group">
    <label for="parent" class="col-sm-2 control-label">Parent</label>
    <div class="col-sm-9">
        <input type="text" data-id="<?php echo isset($category) ? $category->category_id : ''; ?>" data-text="<?php echo isset($category)? $category->category:''; ?>"
         name="parent" value="<?php echo isset($category) ? $category->category_id : ''; ?>" class="form-control" id="parent">
    </div>
</div>

<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-9">
        <textarea name="description" rows="3" class="form-control" id="description"><?php echo isset($category) ? $category->description : ''; ?></textarea>
    </div>
</div>


<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-9">
        <input type="checkbox" id="status" name="status" <?php echo isset($category) ? $category->status == 1 ? 'checked': '' : 'checked'; ?> class="icheck">
        <label for="status">Status</label>
    </div>
</div>

