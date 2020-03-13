$(function () {
	$(document).ready(function() {
    var $table = $('#receive');
    var $modal = $('#my_modal');

    $('li.stationarys').addClass('opened active').find('ul').addClass('visible').find('li.receives').addClass('active');

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
            url: base_url + 'admin/receive/all',
            type: 'POST'
        },
        columns: [
            {data: 'id',visible:false},
            {data: 'actions',  width: '1%', orderable: false, searchable: false},
            {data: 'item'},
            {data: 'quantity'},
            {data: 'amount'}
        ],
        order: [[ 0, "desc" ]]
    });
    

    $table.closest('.dataTables_wrapper').find('select').select2({
        minimumResultsForSearch: -1
    });

    $modal.on('show.bs.modal', function() {
        $('#purchase_id').on('change', function(event) {
            event.preventDefault();
           $.ajax({
                   url: base_url+'admin/receive/getData',
                   type: 'POST',
                   dataType: 'json',
                   data: {purchase_id: $(this).val()},
                   success:function (response) {
                       var i=1;
                       $('#purchase_receive #tbody').empty();
                       $.each(response,function(index, val) {
                          $('#purchase_receive tbody').append('<tr><td>'+i+'</td><td><input type="text" value="'+val.item+'"  readonly class="form-control">'+
                            '<input type="hidden" name="item_id[]" value="'+val.item_id+'"><input type="hidden" name="p_id[]" value="'+val.id+'"></td>'+
                            '<td><input type="number" class="form-control" name="quantity[]"></td>'+
                            '<td><input type="number" class="form-control" name="amount[]"></td></tr>');
                          // $('#purchase_receive tbody').append('<td>'+cloned+'</td>');
                           i++;
                       });
                   }
               })
        });

        $(this).find('.datepicker').datetimepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayBtn: true,
            minView: 2,
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
                $modal.find('.modal-title').html('Receive');
                $modal.find('.modal-body').html(html);
                $modal.find('#click_submit').data('state', 'create').html('<i class="fa fa-save"></i>&nbsp; Save');
                $modal.modal('show');
            }
        });
    });

    function createUpdate() {
        $.ajax({
            url: $('#form_receive').attr('action'),
            type: 'POST',
            dataType: 'json',
            data: new FormData($('#form_receive')[0]),
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