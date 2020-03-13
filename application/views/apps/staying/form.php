<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="staying_name" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" name="staying_name" value="<?php echo isset($staying) ? $staying->staying_name : ''; ?>" class="form-control" id="staying_name">
            </div>
        </div>

        <div class="form-group">
            <label for="gender_id" class="col-sm-4 control-label">Gender</label>
            <div class="col-sm-8">
                <select class="form-control" name="gender_id" id="gender_id" data-allow-clear="true" data-placeholder="Select gender">
                <option value=""></option>
                    <?php foreach ($genders as $gender): ?>
                        <option value="<?php echo $gender->id ?>" <?php if(isset($staying)) echo($staying->gender_id==$gender->id)? 'selected':'' ;?>>
                            <?php echo $gender->name ;?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-4  control-label">
                <label for="date_in">Date In</label>
            </div>
            <div class="col-sm-8">
                <input type="text" name="date_in" id="date_in" value="<?php echo (isset($staying))? date("d-m-Y",strtotime($staying->date_in)) : ''; ?>" class="form-control datepicker" > <span class="help-block error-message"></span>
            </div>
        </div>

        <div class="form-group">
            <label for="id_card" class="col-sm-4 control-label">ID Card</label>
            <div class="col-sm-8">
                <input type="text" name="id_card" value="<?php echo isset($staying) ? $staying->id_card : ''; ?>" class="form-control" id="id_card">
            </div>
        </div>


        <div class="form-group">
            <label for="phone" class="col-sm-4 control-label">Phone</label>
            <div class="col-sm-8">
                <input type="text" name="phone" value="<?php echo isset($staying) ? $staying->phone : ''; ?>" class="form-control" id="phone">
            </div>
        </div>

        <div class="form-group">
            <label for="job" class="col-sm-4 control-label">Job</label>
            <div class="col-sm-8">
                <input type="text" name="job" value="<?php echo isset($staying) ? $staying->job : ''; ?>" class="form-control" id="job">
            </div>
        </div>

        <div style="display:<?php echo (isset($staying))? '':'none'; ?> ">
            <div class="form-group">
                <div class="col-sm-4"></div>
                <div class="col-sm-8">
                <label>
                    <input type="checkbox"  name="checkup" <?php echo isset($staying) ? $staying->checkup == 1 ? 'checked': '' : ''; ?> class="icheck checkup">
                    Move To Checkup / Maintenance
                </label>
                </div>
            </div>

            <div class="form-group">
                <label for="comment" class="col-sm-4 control-label">Comment</label>
                <div class="col-sm-8">
                    <textarea name="comment" class="form-control" rows="3"><?php echo isset($staying)? $staying->comment:''; ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="number_person" class="col-sm-4 control-label">Number Person</label>
            <div class="col-sm-8">
                <input type="text" name="number_person" value="<?php echo isset($staying) ? $staying->number_person : ''; ?>" class="form-control" id="number_person">
            </div>
        </div>

        <div class="form-group">
            <label for="room_id" class="col-sm-4 control-label">Room</label>
            <div class="col-sm-8">
                <input type="text" data-id="<?php echo isset($room) ? $room->room_id : ''; ?>" data-text="<?php echo isset($room)? $room->room:''; ?>" class="form-control" name="room_id" id="room_id" ata-allow-clear="true" data-placeholder="Select room" style="width: 100%">
            </div>
        </div>

        <div class="form-group">
            <label for="booking" class="col-sm-4 control-label">Booking</label>
            <div class="col-sm-8">
                <input type="text" name="booking" value="<?php echo isset($staying) ? $staying->booking : ''; ?>" class="form-control" id="booking">
            </div>
        </div>

        <div class="form-group">
            <label for="car" class="col-sm-4 control-label">Car</label>
            <div class="col-sm-8">
                <input type="number" name="car" value="<?php echo isset($staying) ? $staying->car : ''; ?>" class="form-control" id="car">
            </div>
        </div>
        <div class="form-group">
            <label for="moto" class="col-sm-4 control-label">Motocycle</label>
            <div class="col-sm-8">
                <input type="number" name="moto" value="<?php echo isset($staying) ? $staying->moto : ''; ?>" class="form-control" id="moto">
            </div>
        </div>
        <div class="form-group">
            <label for="bicycle" class="col-sm-4 control-label">Bicycle</label>
            <div class="col-sm-8">
                <input type="number" name="bicycle" value="<?php echo isset($staying) ? $staying->bicycle : ''; ?>" class="form-control" id="bicycle">
            </div>
        </div>

        <?php if(isset($staying)){
            foreach ($room_usages as $room_use) {
                if($room_use->id==$staying->room_id)
                    $room_usage=$room_use;
            }
        } ?>
        <div style="display:<?php echo (isset($staying))? '':'none'; ?> ">
            <div class="form-group">
                <label for="new_water_usage" class="col-sm-4 control-label">Old Water</label>
                <div class="col-sm-8">
                    <input type="text" name="new_water_usage" value="<?php echo isset($staying)? $room_usage->new_water_usage: ''; ?>" class="form-control" id="new_water_usage">
                </div>
            </div>

            <div class="form-group">
                <label for="new_elect_usage" class="col-sm-4 control-label">Old Elect</label>
                <div class="col-sm-8">
                    <input type="text" name="new_elect_usage" value="<?php echo isset($staying)? $room_usage->new_elect_usage: '';  ?>" class="form-control" id="new_elect_usage">
                </div>
            </div>
       
             
            <div class="form-group">
                <label for="type_id" class="col-sm-4 control-label">Is Staying</label>
                <div class="col-sm-8">
                    <input type="text" data-id="<?php echo isset($room) ? $room->type_id : ''; ?>" data-text="<?php echo isset($room)? $room->type:''; ?>"
                     name="type_id" value="<?php echo isset($room) ? $room->type_id : ''; ?>" class="form-control" id="type_id">
                </div>
            </div>
        </div>
   
        <div class="form-group">
            <div class="col-sm-4"></div>
            <div class="col-sm-8">
            <label>
                <input type="checkbox" id="status" name="status" <?php echo isset($staying) ? $staying->status == 1 ? 'checked': '' : 'checked'; ?> class="icheck">
                Status
            </label>
            </div>
        </div>
    </div>
</div>
