@extends('layouts.app')

@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        <center><h4 class="info-hdr">{{config('app.name', 'Laravel')}} INVOICE</h4></center>
    </div>

    <div class="panel-body">

        <div class="row">
            <div class="col-lg-12">
                <div class="capsule">
                    <div class="row">
                        <div class="col-lg-2">INVOICE REF #:</div><div class="col-lg-2">
                            <?php 
                            if(strlen($invoice->id) == 1){
                                echo "C-INV-00".$invoice->id;
                            }else if(strlen($invoice->id) == 2){
                                echo "C-INV-00".$invoice->id;
                            }else{
                                echo "C-INV-".$invoice->id;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">INVOICE DATE:</div><div class="col-lg-2">{{strtoupper($invoice->created_at->format('D d/m/Y'))}}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">DUE DATE:</div><div class="col-lg-2">{{strtoupper(Carbon\Carbon::parse($invoice->due_date)->format('D d/m/Y'))}}</div>
                    </div>
                    <br>
                    <br>
                    <div class="row" style="border:solid 1px grey; margin: 1px;">
                        <div class="col-lg-6"><b>INVOICED TO</b><br>{{$invoice->client->client_name}}
                            <br>{{strtoupper($invoice->client->billing_address)}}</div>
                        <div class="col-lg-6"><b>PAY TO</b><br>TAHMEED<br>NAIROBI, KENYA</div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading" align="center">
        LOADED WAYBILLS    
    </div>

    <div class="panel-body">
        <div class="" id="bottom-content">
            <table class="table table-striped" id="thegrid">
                <thead>
                    <tr>
                        <th></th>
                        <th>WAYBILL</th>
                        <th>DATE</th>
                        <th>PACKAGE TYPE</th>
                        <th>CONSIGNEE</th>   
                        <th>AMOUNT ({{$invoice->currency->currency}})</th>
                        <th>V.A.T ({{$invoice->currency->currency}})</th>
                        <th>TOTAL ({{$invoice->currency->currency}})</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading" align="center">
        TRANSACTIONS    
    </div>

    <div class="panel-body">
        <div class="" id="bottom-content">
            <table class="table table-striped" id="transactions-grid">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>TRANSACTION</th>
                        <th>REFERENCE</th>
                        <th>SERVED BY</th>   
                        <th>AMOUNT ({{$invoice->currency->currency}})</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        @can('add transaction')
        <a id="modal-transaction" href="#" class="btn btn-primary">ADD TRANSACTION</a>
        @endcan
    </div>
</div>
<div class="modal fade" id="transaction-modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="">ADD TRANSACTION</h4>
            </div>
            <form action="{{ url('transactions/') }}" method="POST" class="form-horizontal" id="add-transaction">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="usrname" class="control-label col-md-4">Transaction Date:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" disabled value="{{date('D d/m/Y')}}">  
                        </div>
                    </div>
                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}"/>
                    <div class="form-group row">
                        <label for="transaction_type" class="control-label col-md-4">Transaction Type*:</label>
                        <div class="col-sm-8">
                            <select name="transaction_type_id" id="transaction-type-id" class="form-control">
                                @foreach($transactionTypes as $transactionType)
                                <option value="{{$transactionType->id}}">{{$transactionType->transaction_type}}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="transaction_ref" class="control-label col-md-4">Transaction REF*:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="ref" id="transaction-ref" placeholder="e.g. Deposit slip number,Cheque number e.t.c." required/>      
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount" class="control-label col-lg-4">Amount*:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" disabled value="{{$invoice->currency->currency}}"/> 
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="amount" id="amount" placeholder="e.g. 1200.00" required/>   
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <button type="submit" id="" class="btn btn-default btn-info">ADD TRANSACTION</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
@section('scripts')
<script type="text/javascript">
    var theGrid = null;
    var transactionsGrid = null;
    $(document).ready(function () {
        theGrid = $('#thegrid').DataTable({
            "processing": true,
            "bFilter": false,
            "serverSide": true,
            "ordering": true,
            //"responsive": true,
            "ajax": "{{url('invoices/get_waybills')}}/{{$invoice->id}}",
            "sEmptyTable": "No data available",
            "columns": [
                {"data": "id", "name": "id", "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        return "<input type='checkbox' class='check-item' name='waybills[]' value='" + row['id'] + "'/>";
                    },
                    "targets": 0
                },
                {"data": "waybill", "name": "a.waybill", "targets": 1},
                {"data": "created_at", "name": "created_at", "targets": 2},
                {"data": "package_type", "name": "package_type", "targets": 3},
                {"data": "consignee", "name": "consignee", "targets": 4},
                {"data": "amount", "name": "amount", "targets": 4},
                {"data": "vat", "name": "vat", "targets": 5},
                {"data": "total", "name": "total", "targets": 5}
            ]
        });

        transactionsGrid = $('#transactions-grid').DataTable({
            "processing": true,
            "dom": "t",
            "serverSide": true,
            "ordering": true,
            "responsive": true,
            "ajax": "{{url('invoices/get_transactions')}}/{{$invoice->id}}",
            "columns": [
                {"data": "created_at", "name": "transactions.created_at", "targets": 0},
                {"data": "transaction_type", "name": "transactions.transaction_type", "targets": 1},
                {"data": "ref", "name": "ref", "targets": 2},
                {"data": "created_by", "name": "transactions.created_by", "targets": 3},
                {"data": "amount", "name": "amount", "targets": 4}
            ],
            "sEmptyTable": "No data available"
        });

        $("#modal-transaction").click(function () {
            $("#transaction-modal").modal('show');
        });

        $("#add-transaction").submit(function (event) {
            event.preventDefault();

            transactionTypeId = $("#transaction-type-id").val();
            transactionREF = $("#transaction-ref").val().trim();
            amount = $("#amount").val().trim();

            if (amount.length == 0 || amount.length == 0) {
                alert("Fill in all required fields!");
                return false;
            }

            $.ajax({
                url: "{{url('transactions')}}",
                type: "POST",
                data: {transaction_type_id: transactionTypeId, ref: transactionREF, amount: amount, invoice_id: "{{$invoice->id}}"},
                success: function (response) {
                    if (response == "1") {
                        transactionsGrid.ajax.reload();
                        alert("Transaction has been added!");
                    }
                }
            });
        });

    });
</script>
@endsection