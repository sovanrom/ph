$(function() {

	var $modal = $('#my_modal');
	var $table = $('#search');

	$('.quick-search').show();
	

	$('#notice_calendar').fullCalendar({

		header: {
			left: 'title',
			right: 'today prev,next'
		},

		editable: false,
		firstDay: 1,
		height: 480,

		events: function (start, end, callback) {
			$.ajax({
				url: base_url + 'admin/dashboard/get_unpaid',
				type: 'POST',
				dataType: 'json',
				data: {
					start: moment(start).format('YYYY-MM-DD HH:mm'),
					end: moment(end).format('YYYY-MM-DD HH:mm')
				},
				success: function(response) {
					callback(response.stayings);
				}
			});
		},

		eventRender: function(event, element, view) {
			(event.allDay) ? event.allDay = true : event.allDay = false;
			element.bind('dblclick', function() {
				$.ajax({
					url: base_url+'admin/payment_transaction/create/'+event.id,
					type: 'GET',
					dataType: 'html',
					success: function(html) {
						$modal.find('.modal-title').html('Room Payment');
						$modal.find('.modal-body').html(html);
						$modal.modal('show');
					}
				});
			});
		}
	});

		function createUpdate() {
		    $.ajax({
		        url: $('#form_payment_transaction').attr('action'),
		        type: 'POST',
		        dataType: 'json',
		        data: new FormData($('#form_payment_transaction')[0]),
		        processData: false,
		        contentType: false,
		        success: function(response) {
		            if(response.status == '2'){
		                // $modal.modal('hide');
		                // window.location.replace(base_url+'admin/payment_transaction');
		                $.ajax({
                 	    		url: base_url +'admin/payment_transaction/view_invoice/'+ response.id,
                 	    		type: 'GET',
                 	    		dataType: 'html',
                 	    		success: function(html) {
                 	    			$modal.find('.modal-title').html('Room Payment');
                 	    			$modal.find('.modal-body').html(html);
                 	    			$modal.modal('show');
                 	    		}
                 	    	});
		            	}
		                 $table.DataTable().ajax.reload();
		                 $('#notice_calendar').fullCalendar('refetchEvents');
		                 // $table.find("a[rel='view']").trigger('click');
		        }
		    });
		}

		function Update() {
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
		                $table.DataTable().ajax.reload();
		            }
		        }
		    });
		}
		
		$modal.on('click', '#submit', function(event) {
		    event.preventDefault();
		    createUpdate();
		});
		
		$table.on('click', "a[rel='create']", function(event) {
			event.preventDefault();
			$.ajax({
				url: $(this).attr('href'),
				type: 'GET',
				dataType: 'html',
				success: function(html) {
					$modal.find('.modal-title').html('Room Payment');
					$modal.find('.modal-body').html(html);
					$modal.modal('show');
				}
			});
		});

	    $table.on('click', "a[rel='view']", function(event) {
	    	event.preventDefault();
	    	$.ajax({
	    		url: $(this).attr('href'),
	    		type: 'GET',
	    		dataType: 'html',
	    		success: function(html) {
	    			$modal.find('.modal-title').html('Room Payment');
	    			$modal.find('.modal-body').html('<center><a id="btnPrint"'+
                            'class="btn btn-default btn-icon icon-left hidden-print pull-right">'+
                            'Print Invoice<i class="entypo-print"></i></a></center><div id="invoice_print">'+html+'</div>');
	    			$modal.modal('show');
	    		}
	    	});
	    });

	    $table.on('click', "a[rel='edit']", function(event) {
	    	event.preventDefault();
	    	$.ajax({
	    		url: $(this).attr('href'),
	    		type: 'GET',
	    		dataType: 'html',
	    		success: function(html) {
	    			$modal.find('.modal-title').html('Room Payment');
	    			$modal.find('.modal-body').html(html);
	    			$modal.modal('show');
	    		}
	    	});
	    });

	     $table.on('click', "a[rel='void']", function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                   if(response.status == '1'){
                        $table.DataTable().ajax.reload();  
                   }
                }
            });
        });

	    $('.search').on('click', '.edit', function(e) {
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
	                $('.modal-footer').show();
	            }
	        });
	    });


        $modal.on('show.bs.modal', function() {
        	
        	$(this).find('#btnPrint').on('click', function(event) {
        	    event.preventDefault();
        	    Popup($('#invoice_print').html());
        	});

        	function Popup(data)
        	{
        	    var divToPrint = $(this).find('#invoice_print');

        	    var newWin=window.open('','Print-Window');

        	    newWin.document.open();
        	    newWin.document.write('<html><head><title>Invoice</title><style>@page { size: A5; margin: 0;} h5 {font-size: 12px;} .pull-right { float: right;} </style>');
        	    newWin.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        	    newWin.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        	    newWin.document.write('<body onload="window.print()">'+data+'</body></html>');

        	    newWin.document.close();

        	    setTimeout(function(){newWin.close();},10);
        	    return true;
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

            $('.modal-footer').hide();

            $(this).on('click', '#click_submit', function(event) {
                event.preventDefault();
                Update();
            });

            $(this).find('input[id="room_id"]').select2({
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

            $modal.on('input','#water_new', function(event) {
            	event.preventDefault();
            	$modal.find('#water_usage').val($modal.find('#water_new').val() - $modal.find('#water_old').val());
            	$modal.find('#water_amount').val($modal.find('#water_usage').val() * $modal.find('#invoice_id').data('water-price') + ' Riels');
            	$modal.find('#amount_water').val($modal.find('#water_usage').val() * $modal.find('#invoice_id').data('water-price'));
            });

            $modal.on('input','#elect_new', function(event) {
            	event.preventDefault();
            	$modal.find('#elect_usage').val($modal.find('#elect_new').val() - $modal.find('#elect_old').val());
            	$modal.find('#elect_amount').val($modal.find('#elect_usage').val() * $modal.find('#invoice_id').data('elect-price') + ' Riels');
            	$modal.find('#amount_elect').val($modal.find('#elect_usage').val() * $modal.find('#invoice_id').data('elect-price'));
            });
        });

	    $table.on('click', '.paid', function(event) {
	    	event.preventDefault();
	    	$('.take_payment').hide();
	    	$('.void').hide();
	    	$('.edit').hide();
	    	$('.divider').hide();
	    });

});