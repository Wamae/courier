@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading" align="center">
        <b>ACCOUNT INVOICE MANAGEMENT</b>
    </div>

    <div class="panel-body">
        <div class="">
            <table class="table table-condensed table-striped info-print" id="thegrid">
                <thead>
                    <tr class="holder_header">  
                        <th></th>
                        <th></th>
                        <th>INVOICE REF</th>
                        <th>DATE</th>
                        <th>CLIENT NAME</th>
                        <th>ITEMS</th>
                        <th colspan="3">AMOUNT TO BE PAID</th>
                        <th colspan="3">PAYMENT STATUS</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>AMOUNT</th>
                        <th>V.A.T</th>
                        <th>TOTAL</th>
                        <th class="paid">PAID</th>
                        <th class="balance">BALANCE</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <a href="{{url('invoices/create')}}" class="btn btn-small btn-primary" role="button">
            <i class="icon-plus-sign"></i> 
            Add {{$title}}
        </a>
        
        <a id="cancel-invoices" href="#" class="btn btn-small btn-primary" role="button">
            <i class="icon-plus-sign"></i> 
            Cancel {{$title}}
        </a>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    var theGrid = null;
    var invoicePrefixOne = "C-INV-";
    $(document).ready(function () {
        theGrid = $('#thegrid').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "responsive": true,
            "ajax": "{{url('invoices/grid')}}",
            "columnDefs": [
                {"searchable": false, "orderable": false, "targets": 0},
                {"searchable": false, "orderable": false, "targets": 1},
                {"name": "client_name", "targets": 4},
                {"name": "paid", "targets": 9},
                {"name": "balance", "targets": 10},
                {
                    "render": function (data, type, row) {
                        return '';
                    },
                    "targets": 0
                },
                {
                    "render": function (data, type, row) {
                        return '<input type="checkbox" class="check-item" name="invoices[]" value="' + row[2] + '"/>';
                    },
                    "targets": 1
                },
                {
                    "render": function (data, type, row) {
                        var id = row[2].toString();
                        //alert(id);
                        if (id.length == 1) {
                            return invoicePrefixOne + '00' + id;
                        } else if (id.length == 2) {
                            return invoicePrefixOne + '0' + id;
                        } else {
                            return invoicePrefixOne + id;
                        }
                    },
                    "targets": 2
                },
                 {
                    "render": function (data, type, row) {
                        return '<a href="{{url("invoices")}}/'+row[2]+'" class="btn btn-info">' + row[5] + ' ITEMS</a>';
                    },
                    "targets": 5
                },
                {
                    "render": function (data, type, row) {
                        if (row[10] == 0) {
                            return '<button class="btn btn-info"><span class="glyphicon glyphicon-print"></span> PAID</button>';
                        } else if (row[10] > 0 && row[9] == 0) {
                            return '<button class="btn btn-danger"><span class="glyphicon glyphicon-print"></span> UNPAID</button>';
                        } else if (row[10] > 0 && row[9] > 0) {
                            return '<button class="btn btn-warning"><span class="glyphicon glyphicon-print"></span> PARTIAL</button>';
                        }
                    },
                    "targets": 11
                },
                        /*{
                         "render": function (data, type, row) {
                         return '<a href="{{ url('payment_modes') }}/' + row[0] + '/edit" class="btn btn-default">Update</a>';
                         },
                         "targets": 7                    },
                         {
                         "render": function (data, type, row) {
                         //return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger">Delete</a>';
                         return '';
                         },
                         "targets": 7 + 1
                         },*/
            ]
        });
        
        $("#cancel-invoices").click(function(){
            invoiceIds = [];
             $(".check-item:checked").each(function () {

                invoiceIds.push($(this).val());
            });
            console.log(invoiceIds);
            
            if (invoiceIds.length > 0) {
                $.ajax(
                        {url: "{{url('invoices/cancel_invoices/')}}",
                            data: {"invoice_ids": invoiceIds},
                            type: "POST",
                            success: function (data) {
                                if (data === "1") {
                                    theGrid.ajax.reload();
                                    alert("Invoice has been cancelled");
                                }
                            }});
            } else {
                alert("Select waybills first");
            }
            
        });
        
    });
</script>
@endsection