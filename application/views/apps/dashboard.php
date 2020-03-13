<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row" id="dashboard">
    <div class="col-md-12 search" style="display: none;">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="modal-title"><strong>Profiles</strong></h4>
                <table class="table table-bordered responsive profile">
                    <tr>
                        <td width="100px">Staying Name</td>
                        <td id="name"></td>
                    </tr>
                     <tr>
                        <td width="100px">Date In</td>
                        <td id="date_in"></td>
                    </tr>
                     <tr>
                        <td width="100px">Phone</td>
                        <td id="phone"></td>
                    </tr> <tr>
                        <td width="100px">People</td>
                        <td id="people"></td>
                    </tr><tr>
                        <td width="100px">Last Paid </td>
                        <td id="last_paid"></td>
                    </tr><tr>
                        <td width="100px">Next Paid </td>
                        <td id="next_paid"></td>
                    </tr><tr>
                        <td width="100px">Type</td>
                        <td id="type"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <a id="link"  class='edit' title='edit'><i class='entypo-pencil'></i></a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-3">
                         <h4><strong>Room:</strong></h4>
                    </div>
                   <div class="col-sm-3">
                       <h4 id="room"></h4>
                   </div>
                </div><hr>
                <div class="col-sm-3"><strong>Price :</strong></div>
                <div class="col-sm-3" id="price"></div>
                <br><br>
                <h4>Water</h4><hr>
                <div class="col-sm-3"><strong>Old :</strong></div>
                <div class="col-sm-3" id="water_old"></div>
                <div class="col-sm-3"><strong>New :</strong></div>
                <div class="col-sm-3" id="water_new"></div>
                <br><br>
                <h4>Elect</h4><hr>
                <div class="col-sm-3"><strong>Old :</strong></div>
                <div class="col-sm-3" id="elect_old"></div>
                <div class="col-sm-3"><strong>New :</strong></div>
                <div class="col-sm-3" id="elect_new"></div>
                <br>
            </div>
        </div>
        <h4 class="modal-title"><strong>History</strong></h4>
        <table class="table table-bordered datatable"  id="search">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Action</th>
                    <th>Price</th>
                    <th>Water Usage</th>
                    <th>Elect Usage</th>
                    <th>Last debt</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Paid Date</th> 
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div id="calender">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="panel panel-primary " data-collapsed="0">
                        <div class="panel-body" style="padding:0px;">
                            <div class="calendar-env">
                                <div class="calendar-body" style="width: 100%;">
                                    <div id="notice_calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    	<div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="tile-stats tile-white">
                        <div class="icon"><i class="fa fa-group"></i></div>
                        <div class="num" data-start="0" data-end="0" data-postfix="" data-duration="1500" data-delay="0">123</div>
                        <h3>Available Room</h3>
                        <p>Total available rooms</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="tile-stats tile-white">
                        <div class="icon"><i class="entypo-users"></i></div>
                        <div class="num" data-start="0" data-end="0" data-postfix="" data-duration="800" data-delay="0">50</div>
                        <h3>Uppaid Room</h3>
                        <p>Total uppaid rooms</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="tile-stats tile-white">
                        <div class="icon"><i class="entypo-chart-bar"></i></div>
                        <div class="num" data-start="0" data-end="0" data-postfix="" data-duration="500" data-delay="0">0</div>
                        <h3>To Be Leave</h3>
                        <p>Total to be leaves</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var $modal = $('#my_modal');
        var $table = $('#search');
        var room_id='';

        $table.DataTable({
            LengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            autoWidth: false,
            responsive: false,
            processing: true,
            serverSide: true,
            info:     false,
            bLengthChange: false,
            ajax: {
                url: base_url + 'admin/dashboard/all',
                type: 'POST',
                data: function(param){
                    param.room_id = (room_id)? room_id : '';
                }
            },
            columns: [
                {data: 'id',visible:false},
                {data: 'actions' ,width:'1%',
                    fnCreatedCell: function (nTd, sData, oData, iRow, iCol){
                        (oData.is_paid === 'Unpaid')? $(nTd).html(oData.actions) : $(nTd).html('<div class="paid">'+oData.actions+'</div>'); 
                    },
                },
                {data: 'room_amount'},
                {data: 'water_amount'},
                {data: 'elect_amount'},
                {data: 'forward_amount'},
                {data: 'total'},
                {data: 'is_paid',
                    fnCreatedCell: function (nTd, sData, oData, iRow, iCol){
                            if(oData.status ==='1'){
                                if (oData.is_paid=="Unpaid") {
                                    $(nTd).html('<button class="btn btn-danger">'+oData.is_paid+'</button>');
                                }
                               else{
                                    $(nTd).html('<button class="btn btn-success">'+ oData.is_paid+'</button>');
                                }
                            }else{
                                $(nTd).html('<button class="btn btn-danger">Void</button>');
                            }
                    }
                 },
                {data: 'paid_date'}
            ],
            order: [[ 0, "desc" ]]
        });
    
        if ($('input#add-autocomplete').length > 0) {
            $('input#add-autocomplete').typeahead({
              displayText: function(item) {
                   return item.name
              },
              afterSelect: function(item) {
                    this.$element[0].value = item.name;
                    $("input#field-autocomplete").val(item.id);
                    
                    room_id=item.id;

                   $.ajax({
                             url: base_url+'admin/dashboard/search',
                             type: 'POST',
                             dataType: 'json',
                             data: {'room_id': item.id},
                             success: function (response) {
                                if (response) {
                                     $('.search').show();
                                     $('#calender').hide(); 
                                     $table.DataTable().ajax.reload();  
                                     $('.search').find('#name').text(response.staying_name);
                                     $('.search').find('#room').text(response.name);
                                     $('.search').find('#date_in').text(response.date_in);
                                     $('.search').find('#phone').text(response.phone);
                                     $('.search').find('#people').text(response.number_person);
                                     $('.search').find('#last_paid').text(response.paid_date);
                                     $('.search').find('#next_paid').text(response.next_paid_date);
                                     $('.search').find('#type').text(response.type);
                                     $('.search').find('#price').text(response.price+' USD');
                                     $('.search').find('#link').attr('href', base_url+'admin/staying/edit/'+response.id);
                                     if(response.old_water_usage == null){
                                        $('.search').find('#water_old').text(response.water_usage);
                                        $('.search').find('#elect_old').text(response.elect_usage);
                                     }
                                     else{
                                         $('.search').find('#water_old').text(response.old_water_usage);
                                         $('.search').find('#water_new').text(response.new_water_usage);
                                         $('.search').find('#elect_new').text(response.new_elect_usage);
                                         $('.search').find('#elect_old').text(response.old_elect_usage);
                                    }   
                                }
                            }
                         })
              },
              source: function (query, process) {
                $.ajax({
                        url: "<?php echo base_url() ?>admin/dashboard/autocomplete",
                        data: {query:query},
                        dataType: "json",
                        type: "POST",
                        success: function (data) {
                            process(data)
                        }
                    })
              }   
            });
        }
       
    });
</script>
