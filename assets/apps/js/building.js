$(function () {

    var $table = $('#building');
    var $modal = $('#my_modal');

    $('li.buildings').addClass('opened active').find('ul').addClass('visible').find('li.manage_buildings').addClass('active');

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
            url: base_url + 'admin/building/all',
            type: 'POST'
        },
        columns: [
            {data: 'id', visible: false},
            {data: 'actions', width:'1%'},
            {data: 'building_name'},
            {data: 'pref'},
            {data: 'name'},
            {data: 'rooms'},
            {data: 'contact_person'},
            {data: 'phone'},
            {data: 'email'},
            {data: 'description'},
            {data: 'address'},
            // {data: 'address1'},
            // {data: 'address2'},
            // {data: 'address3'}
           
        ],
        order: [[ 0, "desc" ]]
    });


    $table.closest('.dataTables_wrapper').find('select').select2({
        minimumResultsForSearch: -1
    });

     $modal.on('show.bs.modal', function() {

        // $(this).on('change','#building_id', function(event) {
        //     event.preventDefault();
        //     $.ajax({
        //         url: base_url+'admin/room/countRoom/'+$(this).val(),
        //         type: 'POST',
        //         dataType: 'json',
        //         success:function (response) {
        //             if (response <= 0) {
        //                 alert('The building you selected cannot create room anymore!!!');
        //                  $modal.modal('hide');
                        
        //             }
        //             var clone1 = $('#floor').clone();
        //             var clone2 = $('#price').clone();
        //             $('#bundlecreate tbody').empty();
        //             var j=1;
        //             for (var i = 0; i < response; i++) {
        //              $('#bundlecreate tbody').append('<tr><td>'+j+'</td><td>'+
        //                             '<input type="text" name="name[]" class="form-control">'+
        //                             '</td><td></td><td></td>'+
        //                             '<td><input type="number" name="begin_water[]" class="form-control"></td>'+
        //                             '<td><input type="number" name="begin_elect[]" class="form-control"></td></tr>'
        //                 );
        //                 j++;
        //             }
        //             $('#tbody tr').find('td:eq(3)').html(clone1);
        //             $('#tbody tr').find('td:eq(2)').html(clone2);
        //         }
        //     })
        // });

        $(this).find('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });
         $(this).find('input[name="type_id"]').select2({
            minimumInputLength: 2,
            ajax: {
                url: base_url + 'admin/type/select2',
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
        if ($(this).find('#type_id').data('id')!==0) {
            $(this).find('input[name="type_id"]').select2("data", {id: $(this).find('#type_id').data('id'), text: $(this).find('#type_id').data('text')});
        }
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
            url: $('#form_building').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_building')[0]),
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == '1'){
                    $modal.modal('hide'); 
                    $table.DataTable().ajax.reload();
                    // $.ajax({
                    //         url: base_url +'admin/room/bundlecreate',
                    //         type: 'GET',
                    //         dataType: 'html',
                    //         success: function(html) {
                    //             $modal.find('.modal-title').html('Bundlecreate');
                    //             $modal.find('.modal-body').html(html);
                    //             $modal.find('#click_submit').html('<i class="fa fa-save"></i>&nbsp; Save');
                    //             $modal.modal('show');
                    //         }
                    // });
                }
            }
        });
    }

    $modal.on('click', '#click_submit', function(event) {
        event.preventDefault();
        createUpdate();
    });
    
});