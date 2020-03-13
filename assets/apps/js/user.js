$(function () {
    
    var $table = $('#user');
    var $modal = $('#my_modal');

    $('li.security').addClass('opened active').find('ul').addClass('visible').find('li.users').addClass('active');

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
            url: base_url + 'admin/user/all',
            type: 'POST'
        },
        columns: [
            {data: 'id',visible:false},
            {data: 'actions',  width: '1%', orderable: false, searchable: false},
            {data: 'emp_no'},
            {data: 'full_name'},
            {data: 'phone'},
            {data: 'email'},
            {data: 'username'},
            {data: 'group_id'}
        ],
        order: [[ 0, "desc" ]]
    });
    

    $table.closest('.dataTables_wrapper').find('select').select2({
        minimumResultsForSearch: -1
    });

     $modal.on('show.bs.modal', function() {
        $(this).find('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });
         $(this).find('select').select2({
            dropdownParent: $(this)
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

    function createUpdate() {
        $.ajax({
            url: $('#form_user').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_user')[0]),
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

     $modal.on('focusout','#confirmpass', function(event) {
            event.preventDefault();
            /* Act on the event */
        if($('#confirmpass').val()!=$('#pass').val()){
            $('#confirmpass').val('');
            $('#wrongpass').show();
            $('#click_submit').attr("disabled", true)
        }else{
            $('#wrongpass').hide();
            $('#click_submit').attr("disabled", false)
        }
    });
    
});