<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form  role="form" class="form-horizontal " id="form_create_payment" action="<?php echo base_url(); ?>admin/create_payment/create" method="post">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs bordered">
                <li class="active">
                    <a aria-expanded="true" href="#unpaid" data-toggle="tab">
                        <span class="hidden-xs">Create Single Invoice</span>
                    </a>
                </li>
                <li >
                    <a aria-expanded="true" href="#paid" data-toggle="tab">
                        <span class="hidden-xs">Create Multiple Invoices</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content"> 
                <input type="hidden" id="staying_id" name="staying_id" />
                <input type="hidden" id="rate" name="rate" value="<?php echo isset($rate)? $rate->rate:''; ?>" />
                <input type="hidden" id="next_paid_date" name="next_paid_date" />
                <input type="hidden" id="usage_id" name="usage_id" />

                <div class="tab-pane" id="paid">
                    <div class="row"><br>
                        <div class="col-sm-6" style="border-right: 1px solid black;">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Start Date</label>
                                <div class="col-sm-6">
                                    <input type="text" id="start_date" autocomplete="off" name="start_date" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">End Date</label>
                                <div class="col-sm-6">
                                    <input type="text" id="end_date" autocomplete="off" name="end_date" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                    <div class="col-sm-6"><br><br>
                    <button  id="invoices" class="btn btn-info">Run Bill</button>
                    </div>
                    </div>
                </div>

                <div class="tab-pane active" id="unpaid" data-elect-price="<?php echo $settings->elect_price ?>" data-water-price="<?php echo $settings->water_price ?>" data-rate="<?php echo $rate->rate ?>">
                    <div class="row">
                        <div class="col-md-6">
                                <div class="panel panel-default panel-shadow" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title">Invoice Informations</div>
                                    </div>
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <label for="building_id" class="col-sm-3 control-label">Building</label>
                                            <div class="col-sm-9">
                                                <input 
                                                    type="text"
                                                    data-id="<?php echo isset($room) ? $room->building_id : ''; ?>" 
                                                    data-text="<?php echo isset($room)? $room->building:''; ?>" 
                                                    name="building_id" 
                                                    value="<?php echo isset($room) ? $room->building_id : ''; ?>" 
                                                    class="form-control" id="building_id">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="room_id" class="col-sm-3 control-label">Room</label>
                                            <div class="col-sm-9">
                                             <input 
                                                type="text" 
                                                data-id="<?php echo isset($room) ? $room->room_id : ''; ?>" 
                                                data-text="<?php echo isset($room)? $room->room:''; ?>" 
                                                class="form-control" 
                                                name="room_id" 
                                                id="room_id" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="date_in"  class="col-sm-3 control-label">Water</label>
                                            <div class="col-sm-3">
                                                <input type="text" name="water_old" readonly placeholder="Old" class="form-control" id="water_old">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="number" step="any" placeholder="New" name="water_new"  class="form-control" id="water_new">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" name="water_usage" readonly placeholder="Usage" class="form-control" id="water_usage">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="date_in"  class="col-sm-3 control-label">Electricity</label>
                                            <div class="col-sm-3">
                                                <input type="text" name="elect_old" readonly placeholder="Old" class="form-control" id="elect_old">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="number" name="elect_new" placeholder="New" class="form-control" id="elect_new">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" name="elect_usage" readonly placeholder="Usage" class="form-control" id="elect_usage">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Start Date</label>
                                            <div class="col-sm-3">
                                                <input type="text" id="start_billing_date" autocomplete="off" name="start_billing_date" class="form-control datepicker">
                                            </div>
                                            <label class="control-label col-sm-3">End Date</label>
                                            <div class="col-sm-3">
                                                <input type="text" id="end_billing_date" autocomplete="off" name="end_billing_date" class="form-control datepicker">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="description" class="col-sm-3 control-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea rows="3" name="description" class="form-control" id="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="panel panel-default panel-shadow" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title">Payment Informations</div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="" class="col-sm-3 control-label">Room amount</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="amount" readonly name="amount"  placeholder="Enter Amount" class="form-control"><span class="help-block error-message"></span>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="" class="col-sm-3 control-label">Water amount</label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly id="amount_water" name="amount_water" placeholder="Enter Amount"  class="form-control"><span class="help-block error-message"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="" class="col-sm-3 control-label">Elect amount</label>
                                            <div class="col-sm-9">
                                                <input type="text"  readonly id="amount_elect" name="amount_elect" placeholder="Enter Amount"  class="form-control"><span class="help-block error-message"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Forward amount</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="forward_amount_display"  readonly placeholder="Enter Amount"  type="text"><span class="help-block error-message" ></span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="forward_amount" id="forward_amount">


                                        <div class="form-group">
                                            <label for="is_paid" class="col-sm-3 control-label">Status</label>
                                            <div class="col-sm-9">
                                            <select class="form-control" name="is_paid" id="is_paid" style="width: 100%;" >
                                                <option value="Unpaid">Unpaid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                            </div><span class="help-block error-message"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="payment_method" class="col-sm-3 control-label">Method</label>
                                            <div class="col-sm-9">
                                            <select class="form-control" name="payment_method" id="payment_method" style="width: 100%;" >
                                                <option value="1">Cash</option>
                                                <option value="2">Check</option>
                                                <option value="3">Card</option>
                                            </select>
                                            </div><span class="help-block error-message"></span>
                                        </div>
                                        <div class="paid" style="display: none;">   
                                            <div class="form-group"  >
                                                <label class="col-sm-3 control-label">Paid amount</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" id="paid_amount" name="paid_amount" placeholder="Enter Paid Amount"  type="text">
                                                    <span class="help-block error-message"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                    <label for="paid_date"  class="col-sm-3 control-label">Paid Date</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="paid_date" autocomplete="off" class="form-control datepicker" id="paid_date">
                                                    <span class="help-block error-message"></span>                                                 
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                    <button type="button" class="btn btn-info" id="click_submit">Add Invoice</button>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style type="text/css">
    input::-webkit-input-placeholder {
            font-size: 10px;
        }
</style>