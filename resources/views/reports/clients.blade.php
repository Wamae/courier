@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('css/client_reports.css')}}">
<div class="panel panel-default">
    <div class="panel-heading" align="center">
        <b>{{config('app.name', 'Laravel')}} CLIENT REPORTS</b>
    </div>

    <div class="panel-body">
        <div class="non-print search-panel ">
            <div>
                <table class="table table-striped table-responsive table-condensed" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                       <thead>
                        <tr>
                            <th></th>
                            <th>CLIENT NAME</th>
                            <th colspan="3">TO BE INVOICED</th>
                            <th colspan="3">INVOICED PAYMENTS</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>AMOUNT</th>
                            <th>V.A.T</th>
                            <th>TOTAL</th>
                            <th>AMOUNT</th>
                            <th>V.A.T</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$invoice->client_name}}</td>
                                <td>{{$invoice->currency}} {{number_format($invoice->total_amount,2)}}</td>
                                <td>{{$invoice->currency}} {{number_format($invoice->total_vat,2)}}</td>
                                <td>{{$invoice->currency}} {{number_format(($invoice->total_amount + $invoice->total_vat),2)}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">


</script>
@endsection