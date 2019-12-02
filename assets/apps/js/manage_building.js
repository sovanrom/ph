$(function () {
	
    var $table = $('#manage_building');
    var $modal = $('#my_modal');

    $table.DataTable({
        LengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        autoWidth: false,
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + 'manage_building/all',
            type: 'POST'
        },
        columns: [
            {data: 'id'},
            {data: 'building_name'},
            {data: 'rooms'},
            {data: 'contact_person'},
            {data: 'phone'},
            {data: 'email'},
            {data: 'description'},
            {data: 'address'},
            {data: 'address1'},
            {data: 'address2'},
            {data: 'address3'},
            {data: 'actions'}
        ],
        order: [[ 0, "desc" ]]
    });

    $table.closest('.dataTables_wrapper').find('select').select2({
        minimumResultsForSearch: -1
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
            url: $('#form_manage_building').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_manage_building')[0]),
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