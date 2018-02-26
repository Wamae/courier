@extends('layouts.app')

@section('content')
<style>
    #thegrid {
        border-collapse: collapse;
        width: 100%;
    }

    #thegrid > thead > tr >th, #thegrid > tbody >tr >td{
        border: 1px solid black;
    }
</style>
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
                                <label class="col-lg-4 control-label" for="orientation">PDF Orientation:</label>
                                <div class="controls col-lg-6">
                                    <select name="orientation" id="pdf-orientation" class="form-control">
                                        <option value="{{LANDSCAPE}}" selected="selected">Landscape</option>
                                        <option value="{{PORTRAIT}}">Portrait</option>
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
                                    <button id="download-pdf" class="btn btn-info">DOWNLOAD PDF</button>
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
            <div id="grid-content">
                <table class="" id="thegrid">
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
<script>
    //TODO: Refactor variables
    PRINT_STATION_REPORT_URL = "{{url('print_station_report')}}";
    TABLE_GET_REPORT_DATA_URL = "{{ url('station_reports/get_report_data/extra/') }}";
</script>
<script type="text/javascript">
    var theGrid = null;
    $(document).ready(function () {

        var stationId = 0, userId = 0, orientation = 0, currencyId = 0,
                startDate = moment(new Date()).format('YYYY-MM-DD'),
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
            startDate = moment($('#start-date-search').data("date"), 'DD/MM/YYYY').format("YYYY-MM-DD");
            getData(stationId, userId, orientation, currencyId, startDate, endDate);
        });


        $("#end-date-search").on("dp.change", function (e) {
            $('#start-date-search').data("DateTimePicker").maxDate(e.date);

            startDate = moment($('#start-date-search').data("date"), 'DD/MM/YYYY').format("YYYY-MM-DD");
            endDate = moment($('#end-date-search').data("date"), 'DD/MM/YYYY').format("YYYY-MM-DD");

            console.log(startDate + "|" + endDate);
            getData(stationId, userId, orientation, currencyId, startDate, endDate);
        });

        $("#user-search").change(function () {
            var userId = $(this).val();
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
            $.ajax({
                url: TABLE_GET_REPORT_DATA_URL,
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
                total = data[i].cod_amount + data[i].cash_amount + data[i].acc_amount + data[i].cod_vat + data[i].cash_vat + data[i].acc_vat;
                content += `<tr>
    <td>${data[i].office_name}</td>
        <td align='right'>${data[i].cod_amount.toLocaleString("en")}</td>
            <td align='right'>${data[i].cod_vat.toLocaleString("en")}</td>
                <td align='right'>${(data[i].cod_amount + data[i].cod_vat).toLocaleString("en")}</td>
                    <td align='right'>${data[i].acc_amount.toLocaleString("en")}</td>
                        <td align='right'>${data[i].acc_vat.toLocaleString("en")}</td>
                            <td align='right'>${(data[i].acc_amount + data[i].acc_vat).toLocaleString("en")}</td>
                            <td align='right'>${data[i].cash_amount.toLocaleString("en")}</td>
                                <td align='right'>${data[i].cash_vat.toLocaleString("en")}</td>   
                                    <td align='right'>${(data[i].cash_amount + data[i].cash_vat).toLocaleString("en")}</td>
                                        <td align='right'>${total.toLocaleString("en")}</td>
</tr>`;
            }
            return content;
        }

        $("#download-pdf").click(function () {

            let stationId = $("#station-search").val();

            let userId = $("#user-search").val();

            let currencyId = $("#currency-search").val();

            let pdfOrientationId = $("#pdf-orientation").val();

            let startDate = $("#start-date-search").val().trim();
            let endDate = $("#end-date-search").val().trim();

            if(startDate === ""){
                startDate = moment(new Date()).format("YYYY-MM-DD");
            }

            if(endDate === ""){
                endDate = moment(new Date()).format("YYYY-MM-DD");
            }

            let params = `?station_id=${stationId}&userId=${userId}&currency_id=${currencyId}&pdf_orientation_id=${pdfOrientationId}&start_date=${startDate}&end_date=${endDate}`;

            window.open(PRINT_STATION_REPORT_URL + params, '_blank').focus();
        });

    });

</script>
@endsection