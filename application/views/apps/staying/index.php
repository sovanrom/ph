<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <select class="form-control pull-left building" style="width:220px;" >
        <option value="">Select Building..</option>
        <?php foreach ($buildings as $building): ?>
        <option value="<?php echo $building->id ?>" data-building-id="<?php echo $building->id ?>">
                <?php echo $building->building_name;?>
        </option>
        <?php endforeach ?>
    </select>

<a  id="add" href="<?php echo base_url(); ?>admin/staying/create" rel='add' class="btn btn-info pull-right" style="margin-left: 20px;">
    <i class="entypo-plus-circled"></i>
    Add new
</a>
<br><br><br>

<div class="row">
    <div class="col-sm-3">
    <div class="tabs-vertical-env">
            <ul class="nav tabs-vertical room" style="width: 220px;" id="room" data-elect-price="<?php echo $settings->elect_price ?>" data-water-price="<?php echo $settings->water_price ?>">
            </ul>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="modal-title">Profiles</h4>
                <table class="table table-bordered responsive profile">
                    <tr>
                        <td width="100px">Staying Name</td>
                        <td id="name"></td>
                    </tr>
                     <tr>
                        <td width="100px">Date In</td>
                        <td id="date_in"></td>
                    </tr>
                     <tr>
                        <td width="100px">Phone</td>
                        <td id="phone"></td>
                    </tr> <tr>
                        <td width="100px">Type</td>
                        <td id="type"></td>
                    </tr> <tr>
                        <td width="100px">People</td>
                        <td id="people"></td>
                    </tr> <tr>
                        <td width="100px">Next Paid </td>
                        <td id="next_paid"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <a id="link"  class='edit' title='edit'><i class='entypo-pencil'></i></a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                    <h4 class="modal-title">Usages</h4>
                    <table class="table table-bordered responsive usage" >
                        <tr>
                            <td width="100px">Room Price</td>
                            <td id="room_price"></td>
                        </tr>
                         <tr>
                            <td width="100px">Water Price</td>
                            <td id="water_price"></td>
                        </tr>   
                         <tr>
                            <td width="100px">Elect Price</td>
                            <td id="elect_price"></td>
                        </tr> <tr>
                            <td width="100px">Paid Date</td>
                            <td id="paid_date"></td>
                        </tr><tr>
                            <td width="100px">Next Paid </td>
                            <td id="next_paid"></td>
                        </tr>
                    </table>
            </div>
    </div>
        <div class="row history" >
            <h4 class="modal-title">Staying History</h4>
            <table class="table table-bordered datatable"  id="staying">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>#</th>
                        <th>Name</th>
                        <!-- <th>Gender</th> -->
                        <th>Date In</th>
                        <th>Paid Date</th>
                        <th>Next Paid</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <!-- <th>Number People</th> -->
                        <!-- <th>Room</th> -->
                        <!-- <th>Booking</th> -->
                        
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div> 
    </div> 
</div>