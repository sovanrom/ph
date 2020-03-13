$(function () {
	
    var $table = $('#checkup');
    var $modal = $('#my_modal');

    $('li.maintenance').addClass('opened active').find('ul').addClass('visible').find('li.Checkings').addClass('active');

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
            url: base_url + 'admin/checkup/all',
            type: 'POST'
        },
        columns: [
            {data: 'id',visible:false},
            {data: 'actions',  width: '1%', orderable: false, searchable: false},
            {data: 'name'},
            {data: 'comment'},
            {data: 'start_date'},
            {data: 'due_date'},
            {data: 'type'}
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
        $(this).find('.datepicker').datetimepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayBtn: true,
            minView: 2,
            defaultDate: null
        });
        $('#type_id').on('change', function(event) {
            event.preventDefault();
            // console.log($(this).val());
            // console.log($(this).text());
            if ($(this).val() == '11') {
                $('#extend_day').show();
            }else{ 
                $('#extend_day').hide();
            }
        });
         $(this).find('select').select2({
            dropdownParent: $(this)
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

    function createUpdate() {
        $.ajax({
            url: $('#form_checkup').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_checkup')[0]),
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