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
    .modal-dialog {
        width: 80%;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label">Requestor</label>
                <div class="col-sm-8 search">
                    <select name="user_id" class="form-control">
                        <?php foreach ($users as $user) :?>
                            <option <?php echo (isset($purchase)) ? ($purchase->user_id == $user->id) ? 'selected' : '' : ''; ?> value="<?php echo $user->id; ?>">
                                <?php echo $user->full_name; ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="name">Requestor Name</label>
                <div class="col-sm-8">
                    <input type="text" readonly  class="form-control" autocomplete="off">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-4 control-label" for="name">Post Date</label>
                <div class="col-sm-8">
                    <input type="text" name="post_date" id="post_date"  class="form-control datepicker" value="<?php echo (isset($purchase)) ? $purchase->post_date : ''; ?>" autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="name">Valid Until</label>
                <div class="col-sm-8">
                    <input type="text" name="valid_until"  class="form-control datepicker" value="<?php echo (isset($purchase)) ? $purchase->valid_until : ''; ?>" autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="name">Document Date</label>
                <div class="col-sm-8">
                    <input type="text" name="doc_date" value="<?php echo (isset($purchase)) ? $purchase->document_date : ''; ?>" class="form-control datepicker" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label" for="name">Required Date</label>
                <div class="col-sm-8">
                    <input type="text" name="required_date"  class="form-control datepicker" value="<?php echo (isset($purchase)) ? $purchase->required_date : ''; ?>" autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="name">Non Budget</label>
                <div class="col-sm-8">
                    <input type="checkbox" name="non_budget" autocomplete="off" <?php echo isset($purchase)? ($purchase->non_budget == 1)? 'checked':'':''; ?>>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="name">Status</label>
                <div class="col-sm-8">
                    <select name="status" class="form-control">
                        <option value="open" <?php echo isset($purchase)? ($purchase->status == 'open')? 'selected':'':''; ?>>Open</option>
                        <option value="done" <?php echo isset($purchase)? ($purchase->status == 'done')? 'selected':'':''; ?>>Done</option>
                        <option value="processing" <?php echo isset($purchase)? ($purchase->status == 'processing')? 'selected':'':''; ?>>Processing</option>
                        <option value="cancel" <?php echo isset($purchase)? ($purchase->status == 'cancel')? 'selected':'':''; ?>>Cancel</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="comment">Comment</label>
                <div class="col-sm-8">
                    <textarea name="comment" class="form-control" rows="3"><?php echo (isset($purchase)) ? $purchase->comment : ''; ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#item" data-toggle="tab">
                    <span class="hidden-xs">Items</span>
                </a>
            </li>
            <li>
                <a href="#document" data-toggle="tab">
                    <span class="hidden-xs">Document</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="item">
                <table class="table table-bordered" id="purchase_detail">
                    <thead>
                        <tr>
                            <th>Item / service</th>
                           <!--  <th>Description</th> -->
                            <th>Free Text</th>
                            <th>Vendor</th>
                            <th>Required Date</th>
                            <th>Request QTY</th>
                            <th>Info.Price</th>
                            <th>Disc %</th>
                            <th>Tax Code</th>
                            <th>UOM Code</th>
                            <th>Budget Code</th>
                            <th>Total</th>
                        </tr>
                        <tbody>
                            <?php if (isset($details)): ?>
                                <?php foreach ($details as $detail): ?>
                                    <tr class="item-row">
                                        <td class="item-name">
                                            <div class="delete-wrape">
                                                <a class="delete btn btn-danger" href="javascript:;" title="Remove row">X</a>
                                                <input type="hidden" value="<?php echo $detail->id; ?>" name="id[]">
                                                <select class="form-control item_id" name="item_id[]" >
                                                    <?php foreach ($items as $item) :?>
                                                        <option <?php echo ($item->id == $detail->item_id) ? 'selected' : ''; ?> value="<?php echo $item->id ?>">
                                                            <?php echo $item->latin; ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </td>
                                         <td >
                                        <textarea name="free_text[]"  class="form-control free_text"  rows="1" style="width: 100%;"><?php echo $detail->free_text; ?></textarea>
                                    </td>
                                    <td class="col-md-1">
                                        <select name="vendor_id[]" class="form-control vendor" <?php echo ($detail->vendor_id == '')? 'disabled': ''; ?>>
                                            <option value="">-</option>
                                                <?php foreach ($vendors as $vendor) :?>
                                                    <option value="<?php echo $vendor->id ?>" <?php echo ($vendor->id == $detail->vendor_id) ? 'selected' : ''; ?>>
                                                        <?php echo $vendor->company_name; ?>
                                                    </option>
                                                <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td class="col-md-1">
                                        <input type="text" name="due_date[]" value="<?php echo $detail->due_date; ?>"  class="form-control datepicker due_date">
                                    </td>
                                    <td >
                                        <input type="number" name="qty[]"  min="1" class="qty form-control"  <?php echo ($detail->vendor_id == '')? 'disabled': ''; ?>
                                        value="<?php echo $detail->quantity; ?>" style="width: 100%;">
                                    </td>
                                    <td class="col-md-1">
                                        <!-- <input type="text" name="price[]"  class="form-control price" style="width: 100%;"> -->
                                        <select  name="price[]"  class="form-control price" style="width: 100%;">
                                            <option value="">-</option>
                                                <?php foreach ($prices as $price) :?>
                                                    <option value="<?php echo $price->price ?>" <?php echo ($price->price == $detail->price) ? 'selected' : ''; ?>>
                                                        <?php echo $price->price; ?>
                                                    </option>
                                                <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td >
                                        <input type="text" name="disc[]" class="form-control dis" <?php echo ($detail->vendor_id == '')? 'disabled': ''; ?>
                                         value="<?php echo $detail->disc; ?>"  style="width: 100%;">
                                    </td>
                                    <td class="col-md-1">
                                        <!-- <input type="text" name="tax_code[]" class="form-control tax_code"  style="width: 100%;"> -->
                                         <select  name="tax_code[]" class="form-control tax_code">
                                            <option value="">-</option>
                                                <?php foreach ($vendors as $vendor) :?>
                                                    <option value="<?php echo $vendor->id ?>" <?php echo ($vendor->id == $detail->tax_code) ? 'selected' : ''; ?>>
                                                        <?php echo $vendor->company_name; ?>
                                                    </option>
                                                <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td >
                                        <!-- <input type="text" name="uom_code[]"  class="form-control uom_code"  style="width: 100%;"> -->
                                        <select  name="uom_code[]"  class="form-control uom_code"<?php echo ($detail->vendor_id == '')? 'disabled': ''; ?> >
                                            <option value="">-</option>
                                                <?php foreach ($uoms as $uom) :?>
                                                    <option value="<?php echo $uom->id ?>" <?php echo ($uom->id == $detail->uom_code) ? 'selected' : ''; ?>>
                                                        <?php echo $uom->description; ?>
                                                    </option>
                                                <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td >
                                        <input type="text" name="budget_code[]" class="form-control budget_code" <?php echo ($detail->vendor_id == '')? 'disabled': '';?>
                                         value="<?php echo $detail->budget_code; ?>"  style="width: 100%;">
                                    </td>
                                    <td >
                                        <input type="text"  class="form-control total" name="total[]" value="<?php echo $detail->total; ?>" readonly style="width: 100%;">
                                    </td>
                                    </tr>
                                    <input type="hidden" name="created_at" value="<?php echo  $detail->created_at; ?>">
                                    <input type="hidden" name="created_by" value="<?php echo  $detail->created_by; ?>">
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr class="item-row">
                                    <td class="item-name col-md-1">
                                        <div class="delete-wrape">
                                            <a class="delete btn btn-danger" href="javascript:;" title="Remove row">X</a>
                                            <select class="form-control item_id" name="item_id[]" style="width: 100%;">
                                                <option value="">-</option>
                                                <?php foreach ($items as $item) :?>
                                                    <option value="<?php echo $item->id ?>">
                                                        <?php echo $item->latin; ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </td>
                                   <!--  <td >
                                        <input type="text" name="item_des[]"  class="form-control item_des"  style="width: 100%;">
                                    </td> -->
                                    <td >
                                        <textarea name="free_text[]"  class="form-control free_text"  rows="1" style="width: 100%;"></textarea>
                                    </td>
                                    <td class="col-md-1">
                                        <select name="vendor_id[]" class="form-control vendor">
                                            <option value="">-</option>
                                                <?php foreach ($vendors as $vendor) :?>
                                                    <option value="<?php echo $vendor->id ?>">
                                                        <?php echo $vendor->company_name; ?>
                                                    </option>
                                                <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td class="col-md-1">
                                        <input type="text" name="due_date[]"  class="form-control datepicker due_date">
                                    </td>
                                    <td >
                                        <input type="number" name="qty[]"  min="1" class="qty form-control"  style="width: 100%;">
                                    </td>
                                    <td class="col-md-1">
                                        <!-- <div class="row">
                                            <div class="col-sm-9">
                                                <input type="text" name="price[]"  class="form-control price" style="width: 100%;">
                                            </div>
                                            <div class="col-sm-3">
                                                <button id="more"><i class="entypo-ellipsis"></i></button>
                                            </div>
                                        </div> -->
                                        
                                        <select  name="price[]"  class="form-control price" style="width: 100%;">
                                            <option value="">-</option>
                                                <?php foreach ($prices as $price) :?>
                                                    <option value="<?php echo $price->price ?>">
                                                        <?php echo $price->price; ?>
                                                    </option>
                                                <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td >
                                        <input type="text" name="disc[]" class="form-control dis"  style="width: 100%;">
                                    </td>
                                    <td class="col-md-1">
                                        <!-- <input type="text" name="tax_code[]" class="form-control tax_code"  style="width: 100%;"> -->
                                         <select  name="tax_code[]" class="form-control tax_code">
                                            <option value="">-</option>
                                                <?php foreach ($vendors as $vendor) :?>
                                                    <option value="<?php echo $vendor->id ?>">
                                                        <?php echo $vendor->company_name; ?>
                                                    </option>
                                                <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td >
                                        <!-- <input type="text" name="uom_code[]"  class="form-control uom_code"  style="width: 100%;"> -->
                                        <select  name="uom_code[]"  class="form-control uom_code" >
                                            <option value="">-</option>
                                                <?php foreach ($uoms as $uom) :?>
                                                    <option value="<?php echo $uom->id ?>">
                                                        <?php echo $uom->description; ?>
                                                    </option>
                                                <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td >
                                        <input type="text" name="budget_code[]" class="form-control budget_code"  style="width: 100%;">
                                    </td>
                                    <td >
                                        <input type="text"  class="form-control total" name="total[]" readonly style="width: 100%;">
                                    </td>
                                </tr>
                            <?php endif ?>

                            <tr id="hiderow">
                              <td colspan="12">
                                  <a id="addrow" href="javascript:;" title="Add more item" class="btn btn-info"> Add more item </a>
                                  <div class="col-sm-3 pull-right">
                                      <div class="form-group">
                                          <label class="col-sm-7 control-label">Sub Total:</label>
                                          <div class="col-sm-5">
                                              <input type="text"  class="form-control" id="subtotal" name="subtotal"
                                              value="<?php echo (isset($purchase)) ? $purchase->subtotal : ''; ?>">
                                         </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-sm-7 control-label">VAT:</label>
                                          <div class="col-sm-5">
                                              <input type="text"  class="form-control" id="vat" name="vat"
                                              value="<?php echo (isset($purchase)) ? $purchase->vat : '0'; ?>">
                                         </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-sm-7 control-label">Grand:</label>
                                          <div class="col-sm-5">
                                              <input type="text"  class="form-control" id="grand" name="grand"
                                              value="<?php echo (isset($purchase)) ? $purchase->grand : ''; ?>">
                                         </div>
                                      </div>
                                  </div>
                              </td>
                            </tr>
                        </tbody>
                    </thead>
                </table>
            </div>
            <div class="tab-pane" id="document">
                
                        <div class="form-group">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                            <?php if (isset($purchase) && !empty($purchase->file)): ?>
                                <img id="show_file" src="<?php echo base_url(); ?>uploads/purchases/<?php echo $purchase->file; ?>"/>
                            <?php else: ?>
                                <img id="show_file" style="display: none;" />
                            <?php endif ?>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                            <div class="input-group">
                                <input type="file" name='file' autocomplete="off" id="file" class="form-control">
                                <input type="hidden" name='file_name' value="<?php echo (isset($purchase)) ? $purchase->file : ''; ?>">
                            </div>
                            <span class="help-block error-message"></span>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>

