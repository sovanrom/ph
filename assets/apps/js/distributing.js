$(function () {
    
    $('select').select2({
            dropdownParent: $(this)
    });

    $('li.stationarys').addClass('opened active').find('ul').addClass('visible').find('li.distributings').addClass('active');


    $('#purchase').on('change', function(event){
        event.preventDefault();
        $.ajax({
            url:  base_url + 'admin/distributing/all',
            type: 'POST',
            dataType: 'json',
            data: {purchase_id: $(this).val()},
            success:function (response) {
                    if (response[0].p_id !== null) {
                        $('#form_distributing').attr('action', base_url+'admin/distributing/edit');
                    }else{
                        $('#form_distributing').attr('action', base_url+'admin/distributing/create');
                    }
                    $('#distributing tbody').text('');
                    var i = 1;
                    var $cm = '';
                    var clone = $('#department').clone();
                    $.each(response, function(index, val){
                        if (val.confirm == 1) {
                            $cm='checked';
                        }
                        $('#distributing tbody').append('<tr><td>'+i+'</td><td>'+
                                    '<input type="hidden" class="form-control"  value="'+val.id+'" name="id" id="id">'+
                                    '<input type="hidden" class="form-control"  value="'+val.p_id+'" name="p_id" id="p_id">'+
                                    '<input type="hidden" class="form-control"value="'+val.item_id+'" name="item_id" id="item_id">'+
                                    '<input type="text" style="background-color:transparent;border: none;font-size: 1em;" readonly  class="form-control" value="'+val.item+'">'+
                                '</td><td> <input type="text"style="background-color:transparent;border: none;font-size: 1em;" readonly class="form-control" id="quantity" value="'+val.quantity+'" name="quantity" >'+
                                '</td><td></td>'+
                                '<td><input type="checkbox" name="confirm" id="confirm" '+$cm+'></td></tr>'
                        );
                        i++;
                        $cm='';
                    });
                    $('#tbody tr').find('td:eq(3)').html(clone);
            }
        })
    });

     $('#click_submit').on('click', function(event) {
        event.preventDefault();
        var distributings = new Array();
        $.each($('#distributing tbody').find('tr'), function(index, val) {
            var distributing = {
                'id' : $(this).find('#id').val(),
                'p_id' : $(this).find('#p_id').val(),
                'item_id' : $(this).find('#item_id').val(),
                'quantity' : $(this).find('#quantity').val(),
                'department' : $(this).find('#department').val(),
                'confirm' : ($(this).find('#confirm').prop('checked')==true)? 1:0
            };
            distributings.push(distributing);
        });
        createUpdate(distributings);
    });

    function createUpdate(data) {
        $.ajax({
            url: $('#form_distributing').attr('action'),
            type: 'POST',
            dataType: 'json',
            data:{data: data},
            success: function(response) {
                if(response.status == '1'){
                    window.location.replace(base_url+'admin/distributing');
                }
            }
        });
    }

});