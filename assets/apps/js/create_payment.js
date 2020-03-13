$(function () {
	
   $('li.accountings').addClass('opened active').find('ul').addClass('visible').find('li.create_payments').addClass('active');

    function createUpdate() {
        $.ajax({
            url: $('#form_create_payment').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_create_payment')[0]),
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == '1'){
                   window.location.replace(base_url+'admin/payment_transaction');
                }
            }
        });
    }
    $(this).find('input[name="room_id"]').select2({
            minimumInputLength: 2,
            ajax: {
                url: base_url + 'admin/room/select2',
                type: 'POST',
                dataType: 'json',
                quietMillis: 250,
                data: function (term) {
                    return {
                        search: term
                    };
                },
                results: function (data, page) {
                    return {
                        results: data.items
                    };
                },
                cache: false
            }
        });
     $(this).find('input[name="building_id"]').select2({
             minimumInputLength: 2,
             ajax: {
                 url: base_url + 'admin/building/select2',
                 type: 'POST',
                 dataType: 'json',
                 quietMillis: 250,
                 data: function (term) {
                     return {
                         search: term
                     };
                 },
                 results: function (data, page) {
                     return {
                         results: data.items
                     };
                 },
                 cache: false
             }
         });
    $(this).find('select').select2({
        dropdownParent: $(this)
    });
    $(this).find('.datepicker').datetimepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayBtn: true,
        minView: 2,
        defaultDate: null
    });

    $('#form_create_payment').on('click', '#click_submit', function(event) {
        event.preventDefault();
        createUpdate();
    });

    // $('#form_create_payment').on('change','#building_id', function(event) {
    //     event.preventDefault();
    //     /* Act on the event */
    //     $.ajax({
    //         url: base_url+'admin/create_payment/get_room',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: {building_id: $(this).val()},
    //         success:function (response) {
    //             $('#room_id').html('');
    //             $('#room_id').append(new Option('Select Room First',''));
    //             $.each(response, function(index, val){
    //                 $('#room_id').append(new Option(val.name, val.id));
    //             });
    //         }
    //     })
    // });

    $('#form_create_payment').on('change', '#room_id', function(event) {
        event.preventDefault();
        $.ajax({
            url: base_url+'admin/create_payment/room_detail',
            type: 'POST',
            dataType: 'json',
            data: {room_id: $(this).val()},
            success:function (response) {
                var water='';
                var elect='';
                if(response !=null) {
                  if (response.usage_id==null) {
                    $('#water_old').val(response.r_old_water_usage);
                    $('#elect_old').val(response.r_old_elect_usage);
                  }else{
                    water=response.water_usage * $('#unpaid').data('water-price');
                    elect=response.elect_usage * $('#unpaid').data('elect-price') ;
                    $('#water_old').val(response.old_water_usage);
                    $('#water_new').val(response.new_water_usage);
                    $('#water_usage').val(response.water_usage);
                    $('#elect_old').val(response.old_elect_usage);
                    $('#elect_new').val(response.new_elect_usage);
                    $('#elect_usage').val(response.elect_usage);
                  }
                    $('#staying_id').val(response.staying_id);
                    $('#next_paid_date').val(response.next_paid_date);
                    $('#start_date').val(response.next_paid_date);
                    $('#end_date').val(response.date);
                    $('#forward_amount_display').val(response.unpaid_amount+' Riels');
                    $('#forward_amount').val(response.unpaid_amount);
                    $('#amount').val(response.price + ' USD');
                    $('#amount_paid').val(response.price + ' USD');
                    $('#amount_water').val (water+ ' Riels');
                    $('#amount_elect').val(elect + ' Riels');
                    $('#usage_id').val(response.usage_id);
                    // $('#unpaid_amount').val((parseInt(response.price)*$('#unpaid').data('rate')) + (parseInt(water) + parseInt(elect) + parseInt(response.unpaid_amount)));
                }
                else{
                   $('#staying_id').val('');
                   $('#water_old').val('');
                   $('#water_new').val('');
                   $('#water_usage').val('');
                   $('#elect_old').val('');
                   $('#elect_new').val('');
                   $('#elect_usage').val('');
                   $('#amount').val('');
                   $('#amount_paid').val('');
                   $('#amount_water').val('');
                   $('#amount_elect').val('');
                }            
            }
        })
    });

    $('#is_paid').on('change', function(event) {
      event.preventDefault();
      if ($(this).val()=='Paid') {
        $('.paid').show();
      }
      else{
        $('.paid').hide(); 
      }
    });
    
    $('#form_create_payment').on('input', '#water_new', function(event) {
        event.preventDefault();
        $('#water_usage').val( $('#water_new').val()- $('#water_old').val());
        $('#water_amount').val($('#water_usage').val() * $('#unpaid').data('water-price') + ' Riels');
        $('#amount_water').val($('#water_usage').val() * $('#unpaid').data('water-price') + ' Riels');
    });
    $('#form_create_payment').on('input', '#elect_new', function(event) {
        event.preventDefault();
        $('#elect_usage').val( $('#elect_new').val()- $('#elect_old').val());
        $('#elect_amount').val($('#elect_usage').val() * $('#unpaid').data('elect-price') + ' Riels');
        $('#amount_elect').val($('#elect_usage').val() * $('#unpaid').data('elect-price') + ' Riels');
    });
    $('#invoices').on('click', function(event) {
        event.preventDefault();
       $.ajax({
           url: base_url+'admin/create_payment/get_data',
           type: 'GET',
           dataType: 'json',
           success: function (response) {
               var data=[];
               $.each(response, function(index, val) {
                     var data1={
                      'usage_id' : val.usage_id,
                      'building_id' : val.building_id,
                      'room_id' : val.room_id,
                      'staying_id' : val.staying_id,
                      'room_amount': val.price,
                      'water_old' : val.old_water_usage,
                      'water_new' : val.new_water_usage,
                      'water_usage' : val.water_usage,
                      'elect_old' : val.old_elect_usage,
                      'elect_new' : val.new_elect_usage,
                      'elect_usage' : val.elect_usage,
                      'next_paid_date' : val.next_paid_date,
                      'start_billing_date': $('#paid').find('#start_date').val(),
                      'end_billing_date': $('#paid').find('#end_date').val(),
                      'unpaid_amount' : val.unpaid_amount
                     };
                     data.push(data1);
                });
               $.ajax({
                   url: base_url+'admin/create_payment/create_invoices',
                   type: 'POST',
                   dataType: ' json',
                   data: {data: data},
                   success: function(response) {
                      if(response.status == '1'){
                         window.location.replace(base_url+'admin/payment_transaction');
                      }
                    }
                
               })
           }
       })
       
    });
});