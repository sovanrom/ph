$(function () {
	$(document).ready(function() {
    var $table = $('#purchase');
    var $modal = $('#my_modal');

    $('li.stationarys').addClass('opened active').find('ul').addClass('visible').find('li.purchases').addClass('active');


    $table.DataTable({
        LengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        autoWidth: false,
        responsive: false,
        processing: true,
        serverSide: true,
        info:     false,
        bLengthChange: false,
        ordering: false,
        fnInitComplete: function(){
           $('.dataTables_filter').append($('#add').clone());
         },
        ajax: {
            url: base_url + 'admin/purchase/all',
            type: 'POST'
        },
        columns: [
            {data: 'id',visible:false},
            {data: 'actions',  width: '1%', orderable: false, searchable: false},
            {data: 'post_date'},
            {data: 'user'},
            {data: 'comment'},
            {data: 'status'}
        ],
        order: [[ 0, "desc" ]]
    });


    $table.closest('.dataTables_wrapper').find('select').select2({
        minimumResultsForSearch: -1
    });

    function subTotal() {
        var subtotal = 0;
         $("#purchase_detail > tbody > tr").each(function () {
            var $total = $(this).find('.total').val();
            (isNaN($total)==true)? $total = 0 : $total = $total ;
            subtotal += parseFloat($total);
        });
        $("#purchase_detail > tbody > tr").find('#subtotal').val(subtotal.toFixed(2)+ ' $');
        $("#purchase_detail > tbody > tr").find('#grand').val((subtotal - $("#purchase_detail > tbody > tr").find('#vat').val()).toFixed(2)+ ' $');

    }

    $modal.on('show.bs.modal', function() {

        $(this).on('change', '.tax_code', function(event) {
            event.preventDefault();
                subTotal();
        });

        // var fullDate = new Date();
        // var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) :(fullDate.getMonth()+1);
        // var currentDate = fullDate.getDate() + "-" +  twoDigitMonth   + "-" + fullDate.getFullYear();
        // $(this).find('#post_date').val(currentDate);


        $(this).on('change', '.item_id', function(event) {
            event.preventDefault();
            var $this = $(this);
            $.ajax({
                url: base_url+'admin/purchase/is_item/'+$(this).val(),
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    $this.closest('tr').find('.item_des').val(response.description);
                    if(response.item_type == '2' ){
                        $this.closest('tr').find('.qty').prop('disabled',true);
                        $this.closest('tr').find('.vendor').prop('disabled',true);
                        $this.closest('tr').find('.dis').prop('disabled',true);
                        $this.closest('tr').find('.uom_code').prop('disabled',true);
                        $this.closest('tr').find('.budget_code').prop('disabled',true);
                    }
                    if(response.item_type == '1'){
                        $this.closest('tr').find('.qty').prop('disabled', false);
                        $this.closest('tr').find('.vendor').prop('disabled',false);
                        $this.closest('tr').find('.dis').prop('disabled',false);
                        $this.closest('tr').find('.uom_code').prop('disabled',false);
                        $this.closest('tr').find('.budget_code').prop('disabled',false);
                    }
                }
            })
        });

        //caculate total to total textbox
        $(this).on('input', '.price', function(event) {
            event.preventDefault();
            /* Act on the event */
            $(this).closest('tr').find('.total').val($(this).val());
        });

        $(this).on('focusout', '.dis', function(event) {
            event.preventDefault();
            /* Act on the event */
            var totalbeforediscount = $(this).closest('tr').find('.qty').val()*$(this).closest('tr').find('.price').val();
            $(this).closest('tr').find('.total').val((totalbeforediscount - (totalbeforediscount*$(this).val()/100)).toFixed(2));
        });
        //
        
        $(this).find('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });

        $('#show_file').width(64).height(64);

        $(this).on('change', '#file', function(event) {
            event.preventDefault();
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#show_file')
                    .attr('src', e.target.result)
                    .width(64)
                    .height(64)
                    .show();
            };
            reader.readAsDataURL(event.target.files[0]);
        });

        // $('input#user-autocomplete').on('input', function(event) {
        //     event.preventDefault();
        //     alert('hi');
        // });
       
        if ($('input#user-autocomplete').length > 0) {
            $('input#user-autocomplete').typeahead({
              displayText: function(item) {
                   return item.name
              },
              afterSelect: function(item) {
                    this.$element[0].value = item.name;
                    $("input#field-autocomplete").val(item.id);
              },    
              source: function (query, process) {
                $.ajax({
                        url: "<?php echo base_url() ?>admin/purchase/autocomplete",
                        data: {query:query},
                        dataType: "json",
                        type: "POST",
                        success: function (data) {
                            process(data)
                        }
                    })
              }   
            });
        }

        $(this).find('.modal-dialog').addClass('modal-lg');

        $(this).find('input.icheck').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });
        
        $(this).find('.datepicker').datetimepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayBtn: true,
            minView: 2,
            container: $(this),
            defaultDate: null
        });

        ($(".delete").length < 2) ? $(".delete").hide() : '';

        $(this).find('#addrow').on('click', function(event) {
            event.preventDefault();
            var cloned = $modal.find('tbody tr:first').clone();
            cloned.find('select').val('').trigger('change');
            cloned.find('input').val('');
            cloned.find('textarea').val('');
            cloned.find('.datepicker').datetimepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayBtn: true,
                minView: 2,
                defaultDate: null
            });
            $(".item-row:last").after(cloned);
            ($(".delete").length > 0) ? $(".delete").show() : '';
        });

        $(this).on('click', '.delete', function(event) {
            event.preventDefault();
            $(this).parents('.item-row').remove();
            ($(".delete").length < 2) ? $(".delete").hide() : '';
        });
    });

    $table.on('click', '.remove', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $('#confirmation').modal('show').on('click', '.btn-ok', function(event) {
            event.preventDefault();
            $('#confirmation').modal('hide');
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    (response.status == '1') ? $table.DataTable().ajax.reload() : '';
                }
            });
        });
    });
    
    $table.on('click', '.edit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            dataType: 'html',
            success: function(html) {
                $modal.find('.modal-title').html('Update');
                $modal.find('.modal-body').html(html);
                $modal.find('#click_submit').data('state', 'update').html('<i class="fa fa-save"></i>&nbsp; Update');
                $modal.modal('show');
            }
        });
    });
    var i;

    $('.main-content').on('click', "a[rel='add']", function(event) {
        event.preventDefault();
        i = 1;
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            dataType: 'html',
            success: function(html) {
                $modal.find('.modal-title').html('Add New');
                $modal.find('.modal-body').html(html);
                $modal.find('#click_submit').data('state', 'create').html('<i class="fa fa-save"></i>&nbsp; Save');
                $modal.modal('show');
            }
        });
    });

    function createUpdate() {
        $.ajax({
            url: $('#form_purchase').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_purchase')[0]),
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == '1'){
                    $modal.modal('hide');
                    $table.DataTable().ajax.reload();
                }
            }
        });
    }

    $modal.on('click', '#click_submit', function(event) {
        event.preventDefault();
        createUpdate();
    });

    });
});