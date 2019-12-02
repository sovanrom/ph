$table.on('click', '.remove', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $('#confirm-delete').modal('show').on('click', '.btn-ok', function(event) {
        event.preventDefault();
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                (response.status == '1') ? $('#confirm-delete').modal('hide') : '';
                (response.status == '1') ? $table.DataTable().ajax.reload() : '';
            }
        });
    });
});