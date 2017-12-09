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
                                    <select name="status_search" id="user-search" class="form-control">
                                        <option value="0" selected="selected">ALL SYSTEM USERS</option>
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
        SYSTEM USER WAYBILL REPORTS
    </div>

    <div class="panel-body">
        <div class="non-print search-panel ">
            <div>
                <table class="table table-striped table-responsive table-condensed" id="thegrid" style="border: 1px solid black;">
                    <thead>
                        <tr>
                            <th>COLLECTION</th>
                            <th colspan="3">COD IN - KSH</th>
                            <th colspan="3">ACCOUNT - KSH</th>
                            <th colspan="3">CASH - KSH</th>
                            <th>COD + CASH - KSH</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Amount</th>
                            <th>V.A.T</th>
                            <th>Total</th>
                            <th>Amount</th>
                            <th>V.A.T</th>
                            <th>Total</th>
                            <th>Amount</th>
                            <th>V.A.T</th>
                            <th>Total</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody id="d-content">
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

        var stationId = 0, userId = 0, orientation = 0, currencyId = 0,
                startDate = moment(new Date()).subtract(90, "days").format('YYYY-MM-DD'),
                endDate = moment(new Date()).format('YYYY-MM-DD');

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


        $("#end-date-search").on("dp.change", function (e) {
            $('#start-date-search').data("DateTimePicker").maxDate(e.date);

            startDate = moment($('#start-date-search').data("date"), 'DD/MM/YYYY').format("YYYY-MM-DD");
            endDate = moment($('#end-date-search').data("date"), 'DD/MM/YYYY').format("YYYY-MM-DD");

            console.log(startDate + "|" + endDate);
            getData(stationId, userId, orientation, currencyId, startDate, endDate);
        });

        $("#station-search").change(function () {
            var stationId = $(this).val();
            getData(stationId, userId, orientation, currencyId, startDate, endDate);
        });

        $("#currency-search").change(function () {
            var currencyId = $(this).val();
            getData(stationId, userId, orientation, currencyId, startDate, endDate);
        });

        function getData(stationId, userId, orientation, currencyId, startDate, endDate) {
            //TODO: ajax call
            $.ajax({
                url: "{{ url('station_reports/get_report_data/extra/') }}",
                type: "GET",
                dataType: "JSON",
                data: {station_id: stationId, user_id: userId, currency_id: currencyId, start_date: startDate, end_date: endDate},
                success: function (result) {
                    content = makeTableContent(result);
                    $("#d-content").html(content);
                }});
        }

        function makeTableContent(data) {
            content = "";
            for (i = 0; i < data.length; i++) {
                total = data[i].cod_amount+data[i].cash_amount+data[i].acc_amount+data[i].cod_vat+data[i].cash_vat+data[i].acc_vat;
               content += `<tr>
    <td>${data[i].office_name}</td>
        <td>${data[i].cod_amount}</td>
            <td>${data[i].cod_vat}</td>
                <td>${data[i].cod_amount + data[i].cod_vat}</td>
                    <td>${data[i].acc_amount}</td>
                        <td>${data[i].acc_vat}</td>
                            <td>${data[i].acc_amount + data[i].acc_vat}</td>
                            <td>${data[i].cash_amount}</td>
                                <td>${data[i].cash_vat}</td>   
                                    <td>${data[i].cash_amount + data[i].cash_vat}</td>
                                        <td>${total}</td>
</tr>`;
            }
            return content;
        }

    });

</script>
@endsection