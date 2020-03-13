$(function () {
    var tap='unpaid';
    var $table = $('#table');
    var $modal = $('#my_modal');

    $('li.accountings').addClass('opened active').find('ul').addClass('visible').find('li.payment_transactions').addClass('active');
    
    $('#myTab a').on('click', function (e) {
      e.preventDefault()
      tap=$(this).attr('href');
      if (tap == 'paid') {
        $('.dataTables_filter').find('#pay').hide();
        $('.dataTables_filter').find('#edit').hide();
      }
      else{
        $('.dataTables_filter').find('#pay').show();
        $('.dataTables_filter').find('#edit').show();
      }
      $table.DataTable().ajax.reload();
    })

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
            url: base_url + 'admin/payment_transaction/all',
            type: 'POST',
            data: function(param){
                param.tab = tap;
            }
        },
        columns: [
            {data: 'id', 'visible': false},
            {data: 'id', 'className':'text-center', width:'1%',
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol){
                    $(nTd).html('<input type="checkbox" name="select" class="select" value="'+oData.id+'"/>');
                }
            },
            {data: 'room_id'},
            {data: 'staying_name'},
            {data: 'room_amount',
                    render:function (data,type,row) {
                        return data+'  USD';
                    }
            },
            {data: 'water_amount',
                    render:function (data,type,row) {
                        return data+'  Riels';
                    }
            },
            {data: 'elect_amount',
                    render:function (data,type,row) {
                        return data+'  Riels';
                    }
            },
            {data: 'is_paid',
                    render: function ( data, type, row ) {
                        if (data=="Unpaid") {
                            return '<button class="btn btn-danger">'+ data  +'</button>';
                        }
                       else{
                            return '<button class="btn btn-success">'+ data  +'</button>';
                        }
                      }
             },
            {data: 'invoice_date'}
        ],
        order: [[ 0, "desc" ]]
    });

    $table.closest('.dataTables_wrapper').find('select').select2({
        minimumResultsForSearch: -1
    });

     $modal.on('show.bs.modal', function() {

        $(this).find('#btnPrint').on('click', function(event) {
            event.preventDefault();
            Popup($('#invoice_print').html());
        });

        function Popup(data)
        {
            var divToPrint = $(this).find('#invoice_print');

            var newWin=window.open('','Print-Window');

            newWin.document.open();
            newWin.document.write('<html><head><title>Invoice</title><style>@page { size: A5; margin: 0;} h5 {font-size: 12px;} .pull-right { float: right;} </style>');
            newWin.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
            newWin.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
            newWin.document.write('<body onload="window.print()">'+data+'</body></html>');

            newWin.document.close();

            setTimeout(function(){newWin.close();},10);
            return true;
        }

        $(this).find('select').select2({
            dropdownParent: $(this)
        });

        $(this).find('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });
        
        $(this).find('.datepicker').datetimepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayBtn: true,
            minView: 2,
            defaultDate: null,
            container: $(this)
        });

        $('.modal-footer').hide();

    });

    $table.on('click', '.remove', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (confirm("Are you sure?")) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    (response.status == '1') ? $table.DataTable().ajax.reload() : '';
                }
            });
        }
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
                $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Update');
                $modal.modal('show');
            }
        });
    });


    var selectedID = new Array();

    function selected() {
        selectedID = [];
         $table.find('tbody  > tr').each(function(index, tr) {
            var value = $(this).find("input[name='select']:checked").val();
            if (value) {
                selectedID.push(value);
            }
        });
    }

    $('.dataTables_filter').on('click',"a[rel='create']", function(event) {
        event.preventDefault();
        selected();
        if (selectedID.length > 1) {
            alert('Please select only one to pay');
        }else if (selectedID.length < 1) {
            alert('Please select one to pay');
        }
        else{
            $.ajax({
                url: $(this).attr('href')+selectedID[0],
                type: 'GET',
                dataType: 'html',
                success: function(html) {
                    $modal.find('.modal-title').html('Room Payment');
                    $modal.find('.modal-body').html(html);
                    $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Save');
                    $modal.modal('show');

                }
            });
        }

    });

    $('.dataTables_filter').on('click',"a[rel='view']",  function(event) {
        event.preventDefault();
        var invoice="";
        selected();
        var url = $(this).attr('href');
        $.each(selectedID,function(index, val) {
                $.ajax({
                    url: url+val,
                    type: 'GET',
                    dataType: 'html',
                    success: function(html) {
                        invoice = invoice.concat(html);
                        $modal.find('.modal-title').html('Print Invoice');
                        $modal.find('.modal-body').html(
                            '<center><a id="btnPrint"'+
                            'class="btn btn-default btn-icon icon-left hidden-print pull-right">'+
                            'Print Invoice<i class="entypo-print"></i></a></center><div id="invoice_print">'+invoice+'</div>'
                        );
                        $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Save');
                        $modal.modal('show');
                    }
                });
        });
    });

    $('.dataTables_filter').on('click',"a[rel='edit']", function(event) {
        event.preventDefault();
        selected();
        if (selectedID.length > 1) {
            alert('Please select only one to edit');
        }else if (selectedID.length < 1) {
            alert('Please select one to edit');
        }
        else{
            $.ajax({
                url: $(this).attr('href')+selectedID[0],
                type: 'GET',
                dataType: 'html',
                success: function(html) {
                    $modal.find('.modal-title').html('Room Payment');
                    $modal.find('.modal-body').html(html);
                    $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Save');
                    $modal.modal('show');
                }
            });
        }
    });

    function createUpdate() {
        $.ajax({
            url: $('#form_payment_transaction').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_payment_transaction')[0]),
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == '1'){
                    $modal.modal('hide');
                    $table.DataTable().ajax.reload();
                }
                if(response.status == '2'){
                    $table.DataTable().ajax.reload();
                    $("a[rel='view']").trigger('click');
                }
            }
        });
    }

    $modal.on('click', '#submit', function(event) {
        event.preventDefault();
        createUpdate();
    });

    $modal.on('input', '#water_new', function(event) {
        event.preventDefault();
        $('#water_usage').val( $('#water_new').val()- $('#water_old').val());
        $('#water_amount').val($('#water_usage').val() * $('#invoice_id').data('water-price') + ' Riels');
        $('#amount_water').val($('#water_usage').val() * $('#invoice_id').data('water-price'));
    });

    $modal.on('input', '#elect_new', function(event) {
        event.preventDefault();
        $('#elect_usage').val( $('#elect_new').val()- $('#elect_old').val());
        $('#elect_amount').val($('#elect_usage').val() * $('#invoice_id').data('elect-price') + ' Riels');
        $('#amount_elect').val($('#elect_usage').val() * $('#invoice_id').data('elect-price'));
    });

    $(document).ready(function() {
        $table.find('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });
    });


});