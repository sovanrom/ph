<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<table  class="table table-bordered datatable" id="bundleadd">
    <thead>
        <tr>
            <th>ID</th>
            <th>Room</th>
            <th>Date</th>
            <th>Old Water</th>
            <th>New Water</th>
            <th>Total Usage</th>
            <th>Old Elect</th>
            <th>New Elect</th>
            <th>Total Usage</th>
        </tr>
    </thead>
    <tbody>
        <tr  id="1" class="item">
            <td><label id="id">1</label></td>
            <td width="150px">
                <select class="form-control room_id" name="room_id[]" style="width: 100%;" >
                    <option value="">-</option>
                    <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo $room->id ?>" <?php if(isset($usage)) echo($usage->room_id==$room->id)? 'selected':'' ;?>>
                            <?php echo $room->name ;?>        
                    </option>
                    <?php endforeach ?>
                </select>
            </td>
            <td>
               <input type="text" name="date[]" id="date" value="<?php echo (isset($usage))? date("d-m-Y",strtotime($usage->date)) : ''; ?>" class="form-control datepicker" > <span class="help-block error-message"></span>
            </td>
            <td>
                <input type="text" name="old_water_usage[]" readonly placeholder="Old" value="<?php echo isset($usage) ? $usage->old_water_usage : ''; ?>" class="form-control old-water-usage" id="old_water_usage">
            </td>
            <td>
                <input type="text" placeholder="New" name="new_water_usage[]" value="<?php echo isset($usage) ? $usage->new_water_usage : ''; ?>" class="form-control new-water-usage" id="new-water-usage">
            </td>
            <td>
                <input type="text" name="water_usage[]" readonly placeholder="Usage"  class="form-control water-usage" id="water_usage">
            </td>
            <td>
                <input type="text" name="old_elect_usage[]" readonly placeholder="Old" value="<?php echo isset($usage) ? $usage->old_elect_usage : ''; ?>" class="form-control old-elect-usage" id="old_elect_usage">
            </td>
            <td>
                <input type="text" name="new_elect_usage[]" placeholder="New" value="<?php echo isset($usage) ? $usage->new_elect_usage : ''; ?>" class="form-control new-elect-usage" id="new_elect_usage">
            </td>
            <td>
                <input type="text" name="elect_usage[]" readonly placeholder="Usage"  class="form-control elect-usage" id="elect_usage">
            </td>
        </tr>
    </tbody>
</table>
<div class="row">
<div class="form-group pull-right" style="padding-right: 40px; display: none">
    <label>
        <input type="checkbox" id="status" name="status" <?php echo isset($usage) ? $usage->status == 1 ? 'checked': '' : 'checked'; ?> class="icheck">
        Status
    </label>
</div>
</div>
<div class="row">
    <button class="btn btn-info pull-right" id="addrow" style="margin-right: 20px;">Add Row</button>
</div>

<style type="text/css">
    .modal-dialog {
      min-width: 60%;
    }
    th{
        text-align: center;
    }
    tr{
        height: 20px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
       
    });
</script>