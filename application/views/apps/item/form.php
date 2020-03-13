    <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="form-group">
        <label for="khmer" class="col-sm-2 control-label">Khmer</label>
        <div class="col-sm-9">
            <input type="text" name="khmer" value="<?php echo isset($item) ? $item->khmer : ''; ?>" class="form-control" id="khmer">
        </div>
    </div>

    <div class="form-group">
        <label for="latin" class="col-sm-2 control-label">latin</label>
        <div class="col-sm-9">
            <input type="text" name="latin" value="<?php echo isset($item) ? $item->latin : ''; ?>" class="form-control" id="latin">
        </div>
    </div>

    <div class="form-group">
        <label for="item_type" class="col-sm-2 control-label">Item Type</label>
        <div class="col-sm-9">
            <select class="form-control" name="item_type">
                <option value="">-</option>
                <option value="1" <?php echo isset($item)? ($item->item_type == 1)? 'selected': '':''; ?>>Item</option>
                <option value="2" <?php echo isset($item)? ($item->item_type == 2)? 'selected': '':''; ?>>Service</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="category_id" class="col-sm-2 control-label">Category</label>
        <div class="col-sm-9">
            <input type="text" data-id="<?php echo isset($item) ? $item->category_id : ''; ?>" data-text="<?php echo isset($item)? $item->category:''; ?>"
             name="category_id" value="<?php echo isset($item) ? $item->category_id : ''; ?>" class="form-control" id="category_id">
        </div>
    </div>
    
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-9">
            <textarea name="description" rows="3" class="form-control" id="description"><?php echo isset($item) ? $item->description : ''; ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="checkbox" id="status" name="status" <?php echo isset($item) ? $item->status == 1 ? 'checked': '' : 'checked'; ?> class="iCheck">
            <label>Status</label>
        </div>
    </div>