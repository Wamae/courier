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
        @can('create invoice')
        <a href="{{url('invoices/create')}}" class="btn btn-small btn-primary" role="button">
            <i class="icon-plus-sign"></i> 
            Add {{$title}}
        </a>
        @endcan
        @can('cancel invoice')
        <a id="cancel-invoices" href="#" class="btn btn-small btn-primary" role="button">
            <i class="icon-plus-sign"></i> 
            Cancel {{$title}}
        </a>
        @endcan
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
            "columns": [
                {"data": "X", "name": "X", "searchable": false, "orderable": false, "render": function (data, type, row) {
                        return " ";
                    }, "targets": 0},
                {"data": "Y", "name": "Y", "searchable": false, "orderable": false, "render": function (data, type, row) {
                        return `<input type='checkbox' class='check-item' name='invoices[]' value='${row['id']}'/>`;
                    },
                    "targets": 1},
                {"data": "id", "name": "a.id", "render": function (data, type, row) {
                        var id = row['id'].toString();
                        if (id.length === 1) {
                            return invoicePrefixOne + "00" + id;
                        } else if (id.length === 2) {
                            return invoicePrefixOne + "0" + id;
                        } else {
                            return invoicePrefixOne + id;
                        }
                    }, "targets": 2},
                {"data": "created_at", "name": "a.created_at", "targets": 3},
                {"data": "client_name", "name": "client_name", "targets": 4},
                {"data": "items", "name": "items", "searchable": false, "render": function (data, type, row) {
                        return `<a href='{{url("invoices")}}/${row['id']}' class='btn btn-info'>${row['items']} ITEMS</a>`;
                    }, "targets": 5},
                {"data": "amount", "name": "amount", "searchable": false, "targets": 6},
                {"data": "vat", "name": "vat", "searchable": false, "targets": 7},
                {"data": "total", "name": "amount", "searchable": false, "targets": 8},
                {"data": "paid", "name": "paid", "searchable": false, "targets": 9},
                {"data": "balance", "name": "balance", "searchable": false, "targets": 10},
                {"data": "stats", "name": "stats", "searchable": false, "render": function (data, type, row) {
                        if (row['balance'] === 0) {
                            return "<button class='btn btn-info'><span class='glyphicon glyphicon-print'></span> PAID</button>";
                        } else if (row['balance'] > 0 && row['paid'] === 0) {
                            return "<button class='btn btn-danger'><span class='glyphicon glyphicon-print'></span> UNPAID</button>";
                        } else if (row['balance'] > 0 && row['paid'] > 0) {
                            return "<button class='btn btn-warning'><span class='glyphicon glyphicon-print'></span> PARTIAL</button>";
                        }
                    }, "targets": 11
                }
            ]
        });

        $("#cancel-invoices").click(function () {
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
                            success: function (response) {
                                if (response === '{{OK}}') {
                                    theGrid.ajax.reload();
                                    alert("Invoice has been cancelled");
                                }
                            }
                        }
                );
            } else {
                alert("Select waybills first");
            }

        });

    });
</script>
@endsection