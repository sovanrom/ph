<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-group">
    <label for="item_id" class="col-sm-2 control-label">Latin</label>
   <!--  <div class="col-sm-9"> -->
   <!--  <select name="item_id" id="item_id" class="form-control" style="width: 100%">
        <option value="">-</option>
        <?php foreach ($items as $item) :?>
            <option value="<?php echo $item->id ?>" <?php echo(isset($actual_stock))? ($actual_stock->item_id==$item->id)? 'selected':'':'' ?>>
                <?php echo $item->latin; ?>
            </option>
        <?php endforeach ?>
    </select> -->
    <div class="col-sm-9">
        <input type="text" disabled class="form-control" value="<?php echo isset($actual_stock) ? $actual_stock->latin : ''; ?>">
    </div>
    </div>
</div>

<div class="form-group">
    <label for="qty" class="col-sm-2 control-label">Qty</label>
    <div class="col-sm-9">
        <input type="text" name="qty" id="qty" class="form-control" value="<?php echo isset($actual_stock) ? $actual_stock->qty : ''; ?>">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-9">
        <input type="checkbox" id="status" name="status" <?php echo isset($actual_stock) ? $actual_stock->status == 1 ? 'checked': '' : 'checked'; ?> class="icheck">
        <label for="status">Status</label>
    </div>
</div>
