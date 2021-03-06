@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading" align="center">
        <b>TAHMEED COURIER COURIER SALES REPORTS</b>
    </div>

    <div class="panel-body">
        <div class="non-print search-panel ">

            <table width="100%">
                <tbody><tr>
                        <td width="50%">
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="keywords">Waybill Station:</label>
                                <div class="col-lg-6">
                                    <select name="station_search" id="station-search" class="form-control">
                                        <option value="0" selected="selected">ALL WAYBILL STATIONS</option>
                                        @foreach($stations as $station)
                                        <option value="{{$station->id}}">{{$station->office_name}}
                                        </option>   
                                        @endforeach
                                    </select>	
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="status_search">System User:</label>
                                <div class="controls col-lg-6">
                                    <select name="user_search" id="user-search" class="form-control">
                                        <option value="0" selected="selected">ALL SYSTEM USERS</option>
                                        @foreach($staff as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>   
                                        @endforeach
                                    </select>	
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="payment_mode">Payment Mode:</label>
                                <div class="controls col-lg-6">
                                    <select name="payment_mode" id="payment-mode-search" class="form-control">
                                        <option value="0" selected="selected">ALL PAYMENT MODES</option>
                                        @foreach($payment_modes as $payment_mode)
                                        <option value="{{$payment_mode->id}}">{{$payment_mode->payment_mode}}</option>   
                                        @endforeach
                                    </select>		
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="orientation">PDF Orientation:</label>
                                <div class="controls col-lg-6">
                                    <select name="orientation" id="orientation" class="form-control">
                                        <option value="0" selected="selected">Landscape</option>
                                        <option value="1">Potrait</option>
                                    </select>		
                                </div>
                            </div>
                        </td>
                        <td width="50%">
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="origin">Currency:</label>
                                <div class="controls col-lg-6">
                                    <select name="currency_search" id="currency-search" data-live-search="true" class="form-control selectpicker">
                                        <option value="0" selected="selected">ALL CURRENCIES</option>
                                        @foreach($currencies as $currency)
                                        <option {{(KSH == $station->id)?'selected':''}} value="{{$currency->id}}">{{$currency->currency}}</option>   
                                        @endforeach
                                    </select>		
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="start_date_search">Start Date:</label>
                                <div class="controls col-lg-6">
                                    <div class="form-group">
                                        <div class='input-group date' id='start-date-search'>
                                            <input type='text' class="form-control" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="end_date_search">End Date:</label>
                                <div class="controls col-lg-6">
                                    <div class="form-group">
                                        <div class='input-group date' id='end-date-search'>
                                            <input type='text' class="form-control" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="end_date_search"></label>
                                <div class="controls col-lg-6">
                                    <button class="btn btn-info">DOWNLOAD PDF</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody></table>

        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading" align="center">
        SYSTEM USER WAYBIL REPORTS
    </div>

    <div class="panel-body">
        <div class="non-print search-panel ">
            <div class="">
                <table class="table table-striped table-responsive table-condensed" id="thegrid">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>WAYBIL REF CODE</th>
                            <th>DATE</th>
                            <th>CONSIGNOR</th>
                            <th>PACKAGE TYPE</th>                                        
                            <th>QTY</th>
                            <th>FROM</th>
                            <th>DESTINATION</th>
                            <th>ISSUED BY</th>
                            <th>TOTAL AMOUNT</th>
                            <th>STATUS</th>
                            <th>PAYMENT MODE</th>
                            <th>CURRENCY</th>
                            <th>CREATED AT</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    var theGrid = null;
    $(document).ready(function () {

        $('#start-date-search').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $('#end-date-search').datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false //Important! See issue #1075
        });

        $("#start-date-search").on("dp.change", function (e) {
            $('#end-date-search').data("DateTimePicker").minDate(e.date);
        });

        theGrid = $('#thegrid').DataTable({
            "processing": true,
            "dom": "t",
            "serverSide": true,
            "ordering": true,
            "responsive": true,
            "language": {
                "sLoadingRecords": "LOADING"
            },
            "ajax": "{{ url('user_reports/grid') }}",
            "sEmptyTable": "Loading data from server",
            "columnDefs": [
                {"name": "a.created_at", "targets": 2},
                {"name": "a.origin", "targets": 5},
                {"name": "a.origin", "targets": 7},
                {"name": "a.destination", "targets": 8},
                {"name": "a.status", "targets": 9},
                {"name": "a.payment_mode", "visible": false, "targets": 11},
                {"name": "stations.currency_id", "visible": false, "targets": 12},
                {"name": "a.created_at", "visible": false, "targets": 13},
                {
                    "render": function (data, type, row) {
                        return '<a href="{{ url('user_reports') }}/print_waybill/pdf?id=' + row[0] + '" class="btn btn-status btn-xs btn-success"><span class="glyphicon glyphicon-print"></span> Print</a>';
                    },
                    "targets": 10
                },
            ]
        });

        $("#end-date-search").on("dp.change", function (e) {
            $('#start-date-search').data("DateTimePicker").maxDate(e.date);
            
            startDate = moment($('#start-date-search').data("date"), 'DD/MM/YYYY').format("YYYY-MM-DD");
            endDate = moment($('#end-date-search').data("date"), 'DD/MM/YYYY').format("YYYY-MM-DD");
            
            console.log(startDate+"|"+endDate);
            theGrid.columns(2).search(startDate+"|"+endDate, false, true, true).draw();
            theGrid.draw();
        });

        $("#station-search").change(function () {
            var station = $(this).val();
            if (station == "0") {
                theGrid.columns("").search(station).draw();
            } else {

                console.log("Station: ", station);
                theGrid.columns(5).search(station, false, true, true).draw();
            }
        });
        
        $("#user-search").change(function () {
            var userId = $(this).val();
            if (userId == "0") {
                theGrid.columns("").search(userId).draw();
            } else {

                console.log("user: ", userId);
                theGrid.columns(8).search(userId, false, true, true).draw();
            }
        });

        $("#payment-mode-search").change(function () {
            var paymentMode = $(this).val();
            if (paymentMode == "0") {
                theGrid.columns(11).search(paymentMode).draw();
            } else {

                console.log("Payment mode: ", paymentMode);
                theGrid.columns(11).search(paymentMode, false, true, true).draw();
            }
        });

        $("#currency-search").change(function () {
            var currency = $(this).val();
            if (currency == "0") {
                theGrid.columns(12).search(currency).draw();
            } else {

                console.log("Currency: ", currency);
                theGrid.columns(12).search(currency, false, true, true).draw();
            }
        });

    });

</script>
@endsection