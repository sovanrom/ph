$(function () {
	
    var $table = $('#staying');
    var $modal = $('#my_modal');

    $('li.buildings').addClass('opened active').find('ul').addClass('visible').find('li.stayings').addClass('active');

    var room_id;
    $table.DataTable({
        LengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        autoWidth: false,
        responsive: false,
        processing: true,
        serverSide: true,
        info:     false,
        bLengthChange: false,
        ordering: false,
        ajax: {
            url: base_url + 'admin/staying/all',
            type: 'POST',
            data: function(param){
                param.room_id = room_id;
            }
        },
        columns: [
            {data: 'usages_id',visible:false},
            {data: 'actions', width:'1%'},
            {data: 'staying_name'},
            // {data: 'gender_id'},
            {data: 'date_in'},
            {data: 'paid_date'},
            {data: 'next_paid_date'},
            {data: 'phone'},
            {data: 'type_id'},
            {data: 'price'}
            // {data: 'room_id'},
            // {data: 'booking'}
        ],
        order: [[ 0, "desc" ]]
    });

    $table.closest('.dataTables_wrapper').find('select').select2({
        minimumResultsForSearch: -1
    });

    $modal.on('show.bs.modal', function() {
        $(this).find('input.icheck').iCheck({
            checkboxClass: 'icheckbox_square-blue'
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
        $(this).find('input[name="room_id"]').select2({
            minimumInputLength: 2,
            ajax: {
                url: base_url + 'admin/room/stayingRoom',
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
         $(this).find('input[name="type_id"]').select2({
            minimumInputLength: 2,
            ajax: {
                url: base_url + 'admin/type/stayingType',
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

        if ($(this).find('#room_id').data('id')!==0) {
            $(this).find('input[name="type_id"]').select2("data", {id: $(this).find('#type_id').data('id'), text: $(this).find('#type_id').data('text')});
            $(this).find('input[name="room_id"]').select2("data", {id: $(this).find('#room_id').data('id'), text: $(this).find('#room_id').data('text')});
        }

        $('.checkup').on('click', function(event) {
            event.preventDefault();
            /* Act on the event */
            alert('hi');
        });
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
                $modal.find('.modal-dialog').css('width','60%');
                $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Update');
                $modal.modal('show');
            }
        });
    });

    $('.profile').on('click', '.edit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            dataType: 'html',
            success: function(html) {
                $modal.find('.modal-title').html('Update');
                $modal.find('.modal-body').html(html);
                $modal.find('.modal-dialog').css('width','60%');
                $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Update');
                $modal.modal('show');
            }
        });
    });

    $('.main-content').on('click', "a[rel='add']", function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            dataType: 'html',
            success: function(html) {
                $modal.find('.modal-title').html('Add New');
                $modal.find('.modal-body').html(html);
                $modal.find('.modal-dialog').css('width','60%');
                $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Save');
                $modal.modal('show');
            }
        });
    });

    function createUpdate() {
        $.ajax({
            url: $('#form_staying').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_staying')[0]),
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == '1'){
                    $modal.modal('hide');
                    $('#room.active').find('.room-tab').attr('id', "$('#form_staying').find('#room_id').val()").trigger('click');
                    $table.DataTable().ajax.reload();
                }
            }
        });
    }

    $modal.on('click', '#click_submit', function(event) {
        event.preventDefault();
        createUpdate();
    });

    $('.building option:eq(1)').prop('selected', true);
    building();
 

    $('.building').on('change', function(event) {
        event.preventDefault();
        /* Act on the event */
        building();
    });


    function building(){
        $.ajax({
            url: base_url+'admin/staying/get_room',
            type: 'POST',
            dataType: 'json',
            data: {'building': $('.building').val()},
            success: function(response){
                $('#room').html('');
                $.each(response, function(index, val) {
                      $('#room').append('<li><a class="room-tab" data-room-id= '+val.id+' data-toggle="tab"> <i class="entypo-dot"></i>'+val.name+'</a></li>');
                });
                $('.room-tab').first().trigger('click');
            }
        });
    }

    function room(room_id){
        $.ajax({
            url: base_url + 'admin/staying/get_staying',
            type: 'POST',
            dataType: 'json',
            data: {staying: room_id},

             success: function(response){
                     if (response.length==0) {
                         $('#add').show();
                         $('.profile').find('#name').html('');
                         $('.profile').find('#date_in').html('');
                         $('.profile').find('#phone').html('');
                         $('.profile').find('#people').html('');
                         $('.profile').find('#link').attr('');
                         $('.profile').find('#type').html('');
                         $('.profile').find('#next_paid').html('');
                         $('.usage').find('#room_price').html('');
                         $('.usage').find('#water_price').html('');
                         $('.usage').find('#elect_price').html('');
                         $('.usage').find('#paid_date').html('');
                         $('.usage').find('#next_paid').html('');
                     }
                     else{
                        $('#add').hide();
                        $('.profile').find('#name').html(response[0].staying_name);
                        $('.profile').find('#date_in').html(response[0].date_in);
                        $('.profile').find('#phone').html(response[0].phone);
                        $('.profile').find('#people').html(response[0].number_person);
                        $('.profile').find('#type').html('<strong>'+response[0].type_id+'</strong>');
                        $('.profile').find('#next_paid').html(response[0].next_paid_date);
                        $('.usage').find('#room_price').html(response[0].price);
                        $('.usage').find('#water_price').html(response[0].water_usage * $('.room').data('water-price')+' Riels');
                        $('.usage').find('#elect_price').html(response[0].elect_usage * $('.room').data('elect-price')+' Riels');
                        $('.usage').find('#paid_date').html(response[0].paid_date);
                        $('.usage').find('#next_paid').html(response[0].next_paid_date);
                        $('.profile').find('#link').attr('href', base_url+'admin/staying/edit/'+response[0].id);
                     }
             }
        })
    }

   $(document).on('click', '.room-tab', function(event) {
       event.preventDefault();
       /* Act on the event */
       room_id=$(this).data('room-id');
       $table.DataTable().ajax.reload();
       room(room_id);
   });
});