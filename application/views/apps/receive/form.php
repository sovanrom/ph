<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
    .delete-wrape {
        position: relative;
    }
    .delete {
        display: block;
        text-decoration: none;
        position: absolute;
        font-weight: bold;
        padding: 0px 3px;
        border: 1px solid;
        top: -6px;
        left: -27px;
        font-family: Verdana;
        font-size: 12px;
    }
</style>
<div class="row">
    <div class="col-sm-4">
        <select id="purchase_id" class="form-control">
            <option value="">Select Purchase</option>
            <?php foreach ($purchases as $purchase) :?>
                <option value="<?php echo $purchase->id ?>" <?php echo isset($receives)? ($receives[0]->purchase_id==$purchase->id)? 'selected':'':''; ?>>
                    <?php echo $purchase->id; ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered" id="purchase_receive">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
               <tbody id="tbody">
                    <?php 
                        $i=1;
                        if(isset($receives)) 
                            foreach ($receives as $receive) :
                     ?>
                    <tr>
                        <td id="no"><?php echo $i; ?></td>
                        <td>
                            <input type="text" readonly class="form-control" value="<?php echo isset($receive)? $receive->item: ''; ?>" >
                            <input type="hidden" name="id[]" value="<?php echo isset($receive)? $receive->id: ''; ?>" >
                            <input type="hidden" name="item_id[]" value="<?php echo isset($receive)? $receive->item_id : '';?>" ></td>
                        <td>
                            <input type="number" class="form-control" value="<?php echo isset($receive)? $receive->quantity : ''; ?>" name="quantity[]"></td>
                        <td>
                            <input type="number" class="form-control" value="<?php echo isset($receive)? $receive->amount : ''; ?>" name="amount[]">
                        </td>
                        <!-- <td>
                            <select name="vendor[]" class="form-control" >
                                <option value="">-</option>
                                <?php foreach ($vendors as $vendor): ?>
                                    <option value="<?php echo $vendor->id ?>" <?php echo isset($receive)? ($receive->vendor_id == $vendor->id)? 'selected':'':''; ?>>
                                        <?php echo $vendor->company_name; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </td> -->
                    </tr>
                    <?php $i++ ?>
                    <?php endforeach ?>
                </tbody>
            </thead>
        </table>
    </div>
</div>
<!-- <div style="display: none;">
    <select name="vendor[]" class="form-control vendor" >
        <option value="">-</option>
        <?php foreach ($vendors as $vendor): ?>
            <option value="<?php echo $vendor->id ?>" <?php echo isset($receive)? ($receive->vendor_id == $vendor->id)? 'selected':'':''; ?>>
                <?php echo $vendor->company_name; ?>
            </option>
        <?php endforeach ?>
    </select>
</div> -->
<!-- <input type="hidden" id="item_id[]" value="'+val.item_id+'" name="item_id[]">