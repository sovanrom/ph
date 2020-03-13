<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="form-group" style="display:<?php echo isset($rate)? 'none':''; ?>">
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-9">
        <input type="text" name="description" value="<?php echo isset($rate) ? $rate->description : ''; ?>" class="form-control " id="description">
    </div>
</div>
<div class="form-group">
    <label for="rate" class="col-sm-2 control-label">Rate</label>
    <div class="col-sm-9">
        <input type="text" name="rate" value="<?php echo isset($rate) ? $rate->rate : ''; ?>" class="form-control " id="rate">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-9">
        <input type="checkbox" id="status" name="status" <?php echo isset($rate) ? $rate->status == 1 ? 'checked': '' : 'checked'; ?> class="icheck">
        <label for="status">Status</label>
    </div>
</div>
