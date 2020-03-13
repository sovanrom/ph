<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-shadow" data-collapsed="0" id="invoice_id"   data-water-price="<?php echo isset($invoice)? $invoice->water_price:''; ?>"  
               data-elect-price="<?php echo isset($invoice)? $invoice->elect_price:''; ?>"  >
            <div class="panel-heading">
                <div class="panel-title">Usage</div>
            </div>
            <div class="panel-body"> 
                <div class="form-group">
                    <label for="date_in"  class="col-sm-2 control-label">Water</label>
                    <div class="col-sm-3">
                        <input type="text" name="water_old" readonly placeholder="Old" class="form-control"  id="water_old" 
                            value="<?php echo isset($invoice) ? ($invoice->water_old == 0)? $invoice->old_water_usage : $invoice->water_old : ''; ?>" >
                    </div>
                    <div class="col-sm-3">
                        <input type="number" step="any" placeholder="New" name="water_new"  class="form-control" id="water_new" value="<?php echo isset($invoice) ? $invoice->water_new: ''; ?>"  >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="water_usage" readonly placeholder="Usage" class="form-control" id="water_usage" value="<?php echo isset($invoice) ? $invoice->water_usage: ''; ?>"  >
                    </div>
                </div>

                <div class="form-group">
                    <label for="date_in"  class="col-sm-2 control-label">Electricity</label>
                    <div class="col-sm-3">
                        <input type="text" name="elect_old" readonly placeholder="Old" class="form-control" id="elect_old" 
                                value="<?php echo isset($invoice) ? ($invoice->elect_old == 0)? $invoice->old_elect_usage : $invoice->elect_old : ''; ?>"  >
                    </div>
                    <div class="col-sm-3">
                        <input type="number" name="elect_new" placeholder="New" class="form-control" id="elect_new" value="<?php echo isset($invoice) ? $invoice->elect_new: ''; ?>"  >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="elect_usage" readonly placeholder="Usage" class="form-control" id="elect_usage" value="<?php echo isset($invoice) ? $invoice->elect_usage: ''; ?>"  >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-shadow" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">Take Payment</div>
            </div>
            <div class="panel-body"> 
                <div class="form-group">
                    <label for="room_amount" class="col-sm-4 control-label">Room Amount</label>
                    <div class="col-sm-6">
                        <input type="text" readonly value="<?php echo isset($invoice) ? $invoice->room_amount.' USD': ''; ?>" class="form-control" id="room_amount">
                    </div>
                    <input type="hidden" name="room_amount" value="<?php echo isset($invoice) ? $invoice->room_amount: ''; ?>" >
                </div>

                <div class="form-group">
                    <label for="water_amount" class="col-sm-4 control-label">Water Amount</label>
                    <div class="col-sm-6">
                        <input type="text"  readonly value="<?php echo isset($invoice) ? number_format($invoice->water_usage * $invoice->water_price).' Reils': ''; ?>" class="form-control" id="water_amount">
                    </div>
                    <input type="hidden" id="amount_water" name="water_amount" value="<?php echo isset($invoice) ? ($invoice->water_usage * $invoice->water_price): ''; ?>">
                </div>

                <div class="form-group">
                    <label for="elect_amount" class="col-sm-4 control-label">Elect Amount</label>
                    <div class="col-sm-6">
                        <input type="text" readonly value="<?php echo isset($invoice) ? number_format($invoice->elect_usage * $invoice->elect_price).' Reils' : ''; ?>" class="form-control" id="elect_amount">
                    </div>
                    <input type="hidden" name="elect_amount" id="amount_elect" value="<?php echo isset($invoice) ? ($invoice->elect_usage * $invoice->elect_price ): ''; ?>" >
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Forward amount</label>
                    <div class="col-sm-6">
                        <input class="form-control" id="u_amount" readonly  value="<?php echo isset($invoice)? number_format($invoice->forward_amount).' Reils':'' ?>"  type="text"><span class="help-block error-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Method</label>
                    <div class="col-sm-6">
                        <select  name="payment_method" class="form-control selectboxit visible">
                            <option value="1">Cash</option>
                            <option value="2">Check</option>
                            <option value="3">Card</option>
                        </select> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Paid amount</label>
                    <div class="col-sm-6">
                        <input class="form-control" id="paid_amount" name="paid_amount" placeholder="Enter Paid Amount"  type="text">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-4 control-label">Status</label>
                    <div class="col-sm-6">
                        <select name="is_paid" class="form-control selectboxit visible">
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                        </select> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4  control-label" for="timestamp">Paid Date</label>
                    <div class="col-sm-6">
                        <input type="input" name="date" autocomplete="off" class="form-control datepicker">
                    </div>
                </div>

                <input type="hidden" name="unpaid_amount" value="<?php echo isset($invoice)? $invoice->unpaid_amount:'' ?>">
                <input type="hidden" name="forward_amount" value="<?php echo isset($invoice)? $invoice->forward_amount:'' ?>">
                <input type="hidden" name="rate" value="<?php echo isset($rate)? $rate->rate:'' ?>">
                <input name="invoice_id" value="<?php echo isset($invoice) ? $invoice->id : ''; ?>" type="hidden">
                <input name="room_id" value="<?php echo isset($invoice) ? $invoice->room_id: ''; ?>" type="hidden">
                <input name="description" value="<?php echo isset($invoice) ? $invoice->description: ''; ?>" type="hidden">
                <input type="hidden" id="next_paid_date" name="next_paid_date" value="<?php echo isset($invoice) ? $invoice->next_paid_date: '';?>" />
                    
                <div class="form-group">
                    <div class="col-sm-5">
                        <button type="submit" id="submit" class="btn btn-info">Take Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
