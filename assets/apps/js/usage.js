$(function () {
	
    var $table = $('#usage');
    var $modal = $('#my_modal');


    $('li.buildings').addClass('opened active').find('ul').addClass('visible').find('li.usages').addClass('active');
    
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
            url: base_url + 'admin/usage/all',
            type: 'POST'
        },
        columns: [
            {data: 'id',visible:false},
            // {data: 'building_id'},
            {data: 'actions',  width: '1%', orderable: false, searchable: false},
            {data: 'room_id'},
            {data: 'date'},
            {data: 'new_water_usage'},
            {data: 'old_water_usage'},
            {data: 'water_usage'},
            {data: 'new_elect_usage'},
            {data: 'old_elect_usage'},
            {data: 'elect_usage'}
        ],
        order: [[ 0, "desc" ]]
    });
    
    
    $table.closest('.dataTables_wrapper').find('select').select2({
        minimumResultsForSearch: -1
    });

    $modal.on('show.bs.modal', function() {

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

        if ($(this).find('#room_id').data('id')!==0) {
            $(this).find('input[name="room_id"]').select2("data", {id: $(this).find('#room_id').data('id'), text: $(this).find('#room_id').data('text')});
        }
        
        $(this).find('input.icheck').iCheck({
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
    

    $('.main-content').on('click', "a[rel='add']", function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            dataType: 'html',
            success: function(html) {
                $modal.find('.modal-title').html('Add New');
                $modal.find('.modal-body').html(html);
                $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Save');
                $modal.modal('show');
            }
        });
    });

     $('.main-content').on('click', "a[rel='addbundle']", function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            dataType: 'html',
            success: function(html) {
                $modal.find('.modal-title').html('Add New');
                $modal.find('.modal-body').html(html);
                $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Save');
                $modal.modal('show');
            }
        });
    });

    function createUpdate() {
        $.ajax({
            url: $('#form_usage').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_usage')[0]),
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
    
    $modal.on('change', '.room_id', function(event) {
        event.preventDefault();
        var water = $(this).closest("tr").find('.old-water-usage');
        var elect = $(this).closest("tr").find('.old-elect-usage');
        /* Act on the event */
        $.ajax({
            url: base_url + 'admin/usage/get_old_usage',
            type: 'POST',
            dataType: 'json',
            data: {room_id:$(this).val()},
            success:function (response) {
                water.val(response.new_water_usage);
                elect.val(response.new_elect_usage);
            }
        })
    });

    $modal.on('change', '#room_id', function(event) {
        event.preventDefault();
        $.ajax({
            url: base_url + 'admin/usage/get_old_usage',
            type: 'POST',
            dataType: 'json',
            data: {room_id:$(this).val()},
            success:function (response) {
                $('#old_water_usage').val(response.new_water_usage);
                $('#old_elect_usage').val(response.new_elect_usage);
            }
        })
    });

    $modal.on('click', '#click_submit', function(event) {
        event.preventDefault();
        createUpdate();
    });

    var i=1;
    $modal.on('input','.new-water-usage', function(event) {
        event.preventDefault();
       $(this).closest('tr').find('.water-usage').val($(this).closest('tr').find('.new-water-usage').val()-$(this).closest('tr').find('.old-water-usage').val());
    });
     $modal.on('input','.new-elect-usage', function(event) {
        event.preventDefault();
        $(this).closest('tr').find('.elect-usage').val($(this).closest('tr').find('.new-elect-usage').val()-$(this).closest('tr').find('.old-elect-usage').val());
    });
     $modal.on('click', '#addrow', function(event) {
         event.preventDefault();
         i++;
        $('#id').text(i);
        $('#bundleadd tbody tr:last').after('<tr id='+i+' class="item">'+$('#1').html()+'</tr>');
        $('#id').text(1);
     });
    
});