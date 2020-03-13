<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <label for="date_in">Date</label>
        </div>
        <div class="col-sm-8">
            <div class="form-group">
            <input type="text" name="date" value="<?php echo (isset($usage)) ? date("d-m-Y", strtotime($usage->date)) : ''; ?>" class="form-control datepicker" id="date" autocomplete="off">
             <span class="help-block error-message"></span>
             </div>
        </div>
    </div>

       <div class="row">
        <div class="col-sm-3">
            <label for="room_id" class="control-label">Room</label>
        </div>
        <div class="col-sm-8">
            <div class="form-group">
                <input type="text" data-id="<?php echo isset($usage) ? $usage->room_id : ''; ?>" data-text="<?php echo isset($usage)? $usage->room:''; ?>" class="form-control" name="room_id" id="room_id" ata-allow-clear="true" data-placeholder="Select room" style="width: 100%">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
        <label for="old_water_usage" class="control-label">Water</label>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="old_water_usage" readonly placeholder="Old" value="<?php echo isset($usage) ? $usage->old_water_usage : ''; ?>" class="form-control" id="old_water_usage">
            </div>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" placeholder="New" name="new_water_usage" value="<?php echo isset($usage) ? $usage->new_water_usage : ''; ?>" class="form-control" id="new_water_usage">
            </div>
        </div>
        <div class="col-sm-1"></div>
         <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="water_usage" readonly placeholder="Total" value="<?php echo isset($usage) ? $usage->water_usage : ''; ?>" class="form-control" id="water_usage">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
        <label for="old_elect_usage" class="control-label">Electric</label>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
            <input type="text" name="old_elect_usage" readonly placeholder="Old" value="<?php echo isset($usage) ? $usage->old_elect_usage : ''; ?>" class="form-control" id="old_elect_usage">
            </div>
        </div>
        <div class="col-sm-1"></div>
         <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="new_elect_usage" placeholder="New" value="<?php echo isset($usage) ? $usage->new_elect_usage : ''; ?>" class="form-control" id="new_elect_usage">
            </div>
        </div>
        <div class="col-sm-1"></div>
         <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="elect_usage" readonly placeholder="Total" value="<?php echo isset($usage) ? $usage->elect_usage : ''; ?>" class="form-control" id="elect_usage">
            </div>
        </div>
    </div>

    
    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
        <label>
            <input type="checkbox" id="status" name="status" <?php echo isset($usage) ? $usage->status == 1 ? 'checked': '' : 'checked'; ?> class="icheck">
            Status
        </label>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#new_water_usage').on('input', function(event) {
            event.preventDefault();
            $('#water_usage').val($(this).val()-$('#old_water_usage').val());
        
        });
        $('#new_elect_usage').on('input', function(event) {
            event.preventDefault();
            $('#elect_usage').val($(this).val()-$('#old_elect_usage').val());
        
        });
    });
</script>

