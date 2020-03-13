<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="form-group" >
    <label for="water_price" class="col-sm-3 control-label">Water Price</label>
    <div class="col-sm-9">
        <input type="text" readonly name="water_price" id="water_price" value="<?php echo(isset($payment_transaction))? $payment_transaction->water_price:''; ?>" class="form-control" ><span class="help-block error-message"></span>
    </div>
</div>
<div class="form-group">
    <label for="elect_price" class="col-sm-3 control-label">Electricity Price</label>
    <div class="col-sm-9">
        <input type="text" readonly name="elect_price" id="elect_price" value="<?php echo(isset($payment_transaction))? $payment_transaction->elect_price:''; ?>" class="form-control" ><span class="help-block error-message"></span>
    </div>
</div>

<div class="form-group">
    <label for="date_in"  class="col-sm-3 control-label">Water</label>
    <div class="col-sm-9">
            <div class="col-sm-3 form-group ">
                <input type="text" name="water_old" readonly placeholder="Old" value="<?php echo(isset($payment_transaction))? $payment_transaction->water_old:''; ?>" class="form-control" id="water_old">
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-3 form-group ">
                <input type="text" placeholder="New" name="water_new" value="<?php echo(isset($payment_transaction))? $payment_transaction->water_new:''; ?>" class="form-control" id="water_new">
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-3 form-group ">
                <input type="text" name="water_usage" readonly placeholder="Usage" value="<?php echo(isset($payment_transaction))? $payment_transaction->water_usage:''; ?>" class="form-control" id="water_usage">
            </div>
            <div class="col-sm-1"></div>
            <div class=" col-sm-3 form-group">
                <input type="text" name="water_amount" id="water_amount"  readonly placeholder="Total"  value="<?php echo(isset($payment_transaction))? $payment_transaction->water_amount:''; ?>" class="form-control">
            </div>
       </div>
</div>

<div class="form-group">
        <label for="date_in"  class="col-sm-3 control-label">Electricity</label>
    <div class="col-sm-9">
            <div class="form-group col-sm-3">
                <input type="text" name="elect_old" readonly placeholder="Old"  value="<?php echo(isset($payment_transaction))? $payment_transaction->elect_old:''; ?>" class="form-control" id="elect_old">
            </div>
            <div class="col-sm-1"></div>
            <div class="form-group col-sm-3">
                <input type="text" name="elect_new" placeholder="New" value="<?php echo(isset($payment_transaction))? $payment_transaction->elect_new:''; ?>" class="form-control" id="elect_new">
            </div>
            <div class="col-sm-1"></div>
            <div class="form-group col-sm-3">
                <input type="text" name="elect_usage" readonly placeholder="Usage" value="<?php echo(isset($payment_transaction))? $payment_transaction->elect_usage:''; ?>" class="form-control" id="elect_usage">
            </div>
            <div class="col-sm-1"></div>
            <div class="form-group col-sm-3">
                <input type="text" name="elect_amount" id="elect_amount" readonly placeholder="Total" value="<?php echo(isset($payment_transaction))? $payment_transaction->elect_amount:''; ?>" class="form-control" >
            </div>  
    </div>
</div>

<div class="form-group">
    <label for="description" class="col-sm-3 control-label">Description</label>
    <div class="col-sm-9">
        <input type="text" name="description" class="form-control" value="<?php echo(isset($payment_transaction))? $payment_transaction->description:''; ?>" id="description"><span class="help-block error-message"></span>
    </div>
</div>

<div class="form-group">
        <label for="date_in"  class="col-sm-3 control-label">Date</label>
    <div class="col-sm-9">
        <input type="text" name="date" value="<?php echo(isset($payment_transaction))? $payment_transaction->invoice_date:''; ?>" class="form-control datepicker" id="date">
        <p>Note: this date using for date recording water and electricity usage and issue invoice to whom's staying.</p>
        <span class="help-block error-message"></span>
    </div>
</div>
<input name="invoice_id" id="invoice_id" data-elect-price="<?php echo $settings->elect_price ?>" data-water-price="<?php echo $settings->water_price ?>" value="<?php echo isset($payment_transaction) ? $payment_transaction->id : ''; ?>" type="hidden">
<div class="form-group">
    <div class="col-sm-5 pull-right">
       <button type="submit" id="submit" class="btn btn-info">Edit Invoice</button>
       <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
    </div>
</div>