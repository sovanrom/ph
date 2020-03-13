<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-group">
    <label for="emp_no" class="col-sm-3 control-label">Emp No</label>
    <div class="col-sm-8">
    	<input type="text" name="emp_no" value="<?php echo isset($user) ? $user->emp_no : ''; ?>" class="form-control" id="emp_no">
    </div>
</div>

<div class="form-group">
    <label for="full_name" class="col-sm-3 control-label">Full Name</label>
    <div class="col-sm-8">
        <input type="text" name="full_name" value="<?php echo isset($user) ? $user->full_name : ''; ?>" class="form-control" id="full_name">
    </div>
</div>
<div class="form-group">
    <label for="phone" class="col-sm-3 control-label">Phone</label>
    <div class="col-sm-8">
        <input type="text" name="phone" value="<?php echo isset($user) ? $user->phone : ''; ?>" class="form-control" id="phone">
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-sm-3 control-label">Email</label>
    <div class="col-sm-8">
        <input type="text" name="email" value="<?php echo isset($user) ? $user->email : ''; ?>" class="form-control" id="email">
    </div>
</div>
<div class="form-group">
    <label for="username" class="col-sm-3 control-label">Username</label>
    <div class="col-sm-8">
        <input type="text" name="username" value="<?php echo isset($user) ? $user->username : ''; ?>" class="form-control" id="username">
    </div>
</div>
<div class="form-group">
    <label for="pass" class="col-sm-3 control-label">Password</label>
    <div class="col-sm-8">
        <input type="password" name="pass" value="<?php echo isset($user) ? $user->pass : ''; ?>" class="form-control" id="pass">
    </div>
</div>
<div class="form-group">
    <label for="confirmpass" class="col-sm-3 control-label">Confirm Password</label>
    <div class="col-sm-8">
        <input type="password" value="<?php echo isset($user) ? $user->pass : ''; ?>" class="form-control" id="confirmpass"><br><label id="wrongpass" style="color: red; display: none;">* PassWord not Match!!</label>
    </div>
</div>
<div class="form-group">
    <label for="group_id" class="col-sm-3 control-label">Group</label>
    <div class="col-sm-8">
        <select name="group_id"id="group_id"data-allow-clear="true" data-placeholder="Select group">
                <option value=""></option>
            <?php foreach ($user_groups as $group): ?>
            <option value="<?php echo $group->id ?>" <?php if(isset($user)) echo($user->group_id==$group->id)? 'selected':''; ?>>
                <?php echo $group->name; ?>
            </option>
            <?php endforeach ?>
        </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-8">
        <input type="checkbox" id="status" name="status" <?php echo isset($user) ? $user->status == 1 ? 'checked': '' : 'checked'; ?> class="icheck">
        <label for="status">Status</label>
    </div>
</div>


