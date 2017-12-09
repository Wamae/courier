@extends('layouts.tracking')

@section('content')



<div class="panel panel-default">
    <div class="panel-heading">
        Waybill Tracking   </div>
    <div class="panel-body">                     
        <div class="form-group row">
            <label for="origin" class="col-sm-3 control-label">WAYBILL NO: </label>
            <div class="col-sm-3 input-group">
                <input type="text" class="form-control" id="waybill-no" placeholder="e.g. WAY-123-456-BILL">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" id="search-waybill">
                        <i class="fa fa-search"></i>Go
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="waybill-modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="">WAYBILL STATUS</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="usrname" class="control-label col-md-4">STATUS:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="status" value="" disabled>  
                    </div>
                </div>
                <div class="form-group row">
                    <label for="transaction_type" class="control-label col-md-4">WAYBILL REF:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="" id="waybill-no-2" disabled>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(function () {
        $("#search-waybill").click(function () {
            var waybillNo = $("#waybill-no").val().trim();
            if (waybillNo.length === 0) {
                alert("Enter a waybill number!");
            } else {
                $.ajax({
                    url: '{{ url("waybills/tracking/trackWaybill") }}/' + waybillNo,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (response) {
                        if (response != 'null') {
                            $("#waybill-no-2").val(response.waybill_no);
                            $("#status").val(response.waybill_status);
                            $("#waybill-modal").modal('show');
                        }
                    }
                });
            }
        });
    });
</script>
@endsection

@endsection


