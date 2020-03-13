<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="my_modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Title</h4>
            </div>
            <div class="modal-body">body</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" id="click_submit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmation" data-backdrop="static">
    <div class="modal-dialog" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">Rental room</div>
            <div class="modal-body">Are you sure to delete this record?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>