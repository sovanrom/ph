<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-group">
    <label for="company_name" class="col-sm-3 control-label">Company Name</label>
    <div class="col-sm-8">
        <input type="text" name="company_name" value="<?php echo isset($supplier) ? $supplier->company_name : ''; ?>" class="form-control" id="company_name">
    </div>
</div>

<div class="form-group">
    <label for="title" class="col-sm-3 control-label">Title</label>
    <div class="col-sm-8">
        <select name="title"  id="title" data-allow-clear="true" data-placeholder="Select title">
                <option value=""></option>
            <?php foreach ($honorifics as $honorific): ?>
                <option value="<?php echo $honorific->id; ?>" <?php if(isset($supplier)) echo ($supplier->title == $honorific->id) ? 'selected': ''; ?>>
                    <?php echo $honorific->name; ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="last_name" class="col-sm-3 control-label">Last Name</label>
    <div class="col-sm-8">
        <input type="text" name="last_name" value="<?php echo isset($supplier) ? $supplier->last_name : ''; ?>" class="form-control" id="last_name">
    </div>
</div>
<div class="form-group">
    <label for="first_name" class="col-sm-3 control-label">First Name</label>
    <div class="col-sm-8">
        <input type="text" name="first_name" value="<?php echo isset($supplier) ? $supplier->first_name : ''; ?>" class="form-control" id="first_name">
    </div>
</div>
<div class="form-group">
    <label for="phone1" class="col-sm-3 control-label">Phone1</label>
    <div class="col-sm-8">
        <input type="text" name="phone1" value="<?php echo isset($supplier) ? $supplier->phone1 : ''; ?>" class="form-control" id="phone1">
    </div>
</div>
<div class="form-group">
    <label for="phone2" class="col-sm-3 control-label">Phone2</label>
    <div class="col-sm-8">
        <input type="text" name="phone2" value="<?php echo isset($supplier) ? $supplier->phone2 : ''; ?>" class="form-control" id="phone2">
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-sm-3 control-label">Email</label>
    <div class="col-sm-8">
        <input type="text" name="email" value="<?php echo isset($supplier) ? $supplier->email : ''; ?>" class="form-control" id="email">
    </div>
</div>
<div class="form-group">
    <label for="website" class="col-sm-3 control-label">Website</label>
    <div class="col-sm-8">
        <input type="text" name="website" value="<?php echo isset($supplier) ? $supplier->website : ''; ?>" class="form-control" id="website">
    </div>
</div>
<div class="form-group">
    <label for="address" class="col-sm-3 control-label">Address</label>
    <div class="col-sm-8">
        <textarea name="address" rows="3" class="form-control" id="address"><?php echo isset($supplier) ? $supplier->address : ''; ?></textarea>
    </div>
    </div>
<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-8">
        <input type="checkbox" id="status" name="status" <?php echo isset($supplier) ? $supplier->status == 1 ? 'checked': '' : 'checked'; ?> class="icheck">
        <label for="status">Status</label>
    </div>
</div>


