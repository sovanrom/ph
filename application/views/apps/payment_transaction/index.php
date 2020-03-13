<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="display: none;">
<div id="add" class="row pull-right" style="margin-left: 20px; margin-right: 5px;">
    <a href="payment_transaction/view_invoice/" id="print" class="view btn btn-info" rel="view" title="view"><i class="entypo-credit-card"></i>Print</a>
    <a href="payment_transaction/edit/" id="edit" class="edit btn btn-info" rel="edit"  title="edit"><i class="entypo-pencil"></i>Edit</a>
    <a href="payment_transaction/create/"  id="pay" class="take_payment btn btn-info" rel="create" title="take payment"><i class="entypo-bookmarks"></i>Pay</a>
</div>
</div>
<br>
<div id="tab_div" class="box-header">
    <ul class="nav nav-tabs nav-tabs-left" id="myTab">
        <li  class="active"> 
            <a href="unpaid" data-toggle="tab"><font color="black">Invoices</font>
            </a>
        </li> 
        <li>
            <a href="paid" data-toggle="tab">
                <font color="black">Payment History</font> 
            </a>
        </li>
    </ul>
            
</div> 

<table class="table table-bordered datatable" id="table"> 
    <thead>
        <tr> 
            <th>#</th>    
            <th>Action</th>    
            <th>Room No</th>    
            <th>Whom Staying</th>    
            <th>Room Price</th>    
            <th>Water</th>    
            <th>Electricity</th>    
            <th>Paid</th>    
            <th>Invoice Date</th>    
        </tr>
    </thead>          
</table>           
       
        