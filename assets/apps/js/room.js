$(function () {
	
    var $table = $('#room');
    var $modal = $('#my_modal');

     $('li.buildings').addClass('opened active').find('ul').addClass('visible').find('li.rooms').addClass('active');

    var building_id;
    $table.DataTable({
        LengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        autoWidth: false,
        responsive: false,
        processing: true,
        serverSide: true,
        info:     false,
        paging:   false,
        info:     false,
        bLengthChange: false,
        ordering: false,
        fnInitComplete: function(){
           $('.dataTables_filter').append($('#add').clone());
         },
        ajax: {
            url: base_url + 'admin/room/all',
            type: 'POST',
            data: function(param){
                param.building_id = building_id;
            }
        },
        columns: [
            {data: 'id',visible:false},
            {data: 'actions',  width: '1%', orderable: false, searchable: false},
            {data: 'name'},
            {data: 'building_name'},
            {data: 'floor_id'},
            {data: 'price'},
            {data: 'begin_water'},
            {data: 'begin_elect'}
        ],
        order: [[ 0, "desc" ]]
    });

    $table.closest('.dataTables_wrapper').find('select').select2({
        minimumResultsForSearch: -1
    });

     $modal.on('show.bs.modal', function() {
        $(this).on('change','#building_id', function(event) {
            event.preventDefault();
            $.ajax({
                url: base_url+'admin/room/countRoom/'+$(this).val(),
                type: 'POST',
                dataType: 'json',
                success:function (response) {
                    if (response <= 0) {
                        alert('The building you selected cannot create room anymore!!!');
                         $modal.modal('hide');
                        
                    }
                    var clone1 = $('#floor').clone();
                    var clone2 = $('#price').clone();
                    $('#bundlecreate tbody').empty();
                    var j=1;
                    for (var i = 0; i < response; i++) {
                     $('#bundlecreate tbody').append('<tr><td>'+j+'</td><td>'+
                                    '<input type="text" name="name[]" class="form-control">'+
                                    '</td><td></td><td></td>'+
                                    '<td><input type="number" name="begin_water[]" class="form-control"></td>'+
                                    '<td><input type="number" name="begin_elect[]" class="form-control"></td></tr>'
                        );
                        j++;
                    }
                    $('#tbody tr').find('td:eq(3)').html(clone1);
                    $('#tbody tr').find('td:eq(2)').html(clone2);
                }
            })
        });

        $(this).find('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue'
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

         $(this).find('input[name="floor_id"]').select2({
             minimumInputLength: 2,
             ajax: {
                 url: base_url + 'admin/floor/select2',
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
         $(this).find('input[name="price"]').select2({
             minimumInputLength: 1,
             ajax: {
                 url: base_url + 'admin/price/select2',
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
         if ($(this).find('#building_id').data('id')!==0) {
         $(this).find('input[name="building_id"]').select2("data", {id: $(this).find('#building_id').data('id'), text: $(this).find('#building_id').data('text')});
         $(this).find('input[name="floor_id"]').select2("data", {id: $(this).find('#floor_id').data('id'), text: $(this).find('#floor_id').data('text')});
         $(this).find('input[name="price"]').select2("data", {id: $(this).find('#price').data('id'), text: $(this).find('#price').data('text')});
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

    $(document).on('click', '.building-tab', function(event) {
        event.preventDefault();
        building_id=$(this).data('building-id');
        $table.DataTable().ajax.reload();
    });

    $(window).load(function() {
        building_id=$('.building-tab').data('building-id');
        $table.DataTable().ajax.reload();
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
            url: $('#form_room').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_room')[0]),
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == '1'){
                    $modal.modal('hide');
                    $table.DataTable().ajax.reload();
                    // $('.building-tab').find('a').attr('href', response.building_id).trigger('click');
                }
            }
        });
    }

    $modal.on('click', '#click_submit', function(event) {
        event.preventDefault();
        createUpdate();
    });
    
});