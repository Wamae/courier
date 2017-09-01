@extends('layouts.app')

@section('content')


<div class="panel panel-default">
    <div class="panel-heading">
        <center><h4 class="info-hdr">LOADING MANIFEST REPORT</h4></center>
    </div>

    <div class="panel-body">

        <div class="row">
            <div class="col-lg-12">
                <div class="capsule">

                    <br>
                    <br>
                    <table class="table info-print" width="100%">
                        <tbody><tr>
                                <td class="info-tda" width="20%"><b>Manifest Ref:</b></td>
                                <td class="info-tdb" width="30%">{{$manifest->manifest_no}}</td>
                                <td class="info-tda" width="20%"><b>From:</b></td>
                                <td class="info-tdb" width="30%">{{$manifest->origins->office_name}}</td>
                            </tr>
                            <tr>
                                <td class="info-tda"><b>Reg. Number:</b></td>
                                <td class="info-tdb">{{$manifest->registration_no}}</td>
                                <td class="info-tda"><b>To:</td>
                                <td class="info-tdb">{{$manifest->destinations->office_name}}</td>
                            </tr>
                            <tr>
                                <td class="info-tda"><b>Date:</b></td>
                                <td class="info-tdb">{{$manifest->created_at}}</td>
                                <td class="info-tda"><b>Driver:</b></td>
                                <td class="info-tdb">{{$manifest->driver}}</td>
                            </tr>
                            <tr>
                                <td class="info-tda"><b>Items Loaded:</b></td>
                                <td class="info-tdb">{{$manifest->waybill_manifest}}</td>
                                <td class="info-tda"><b>Conductor:</b></td>
                                <td class="info-tdb">{{$manifest->conductor}}</td>
                            </tr>
                        </tbody></table>
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
                        <th><input type="checkbox" id="check-all"></th>
                        <th>Waybill</th>
                        <th>Date</th>
                        <th>Consignor</th>
                        <th>Consignee</th>                                        
                        <th>Package</th>
                        <th>Quantity</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Weight</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="bottom-buttons-one" class="clearfix non-print" style="padding: 2px 0;">
<div class="btn-group pull-left waybil-l-btn-b  ">
	<a class="btn btn-small btn-default print-manifes-btn" href="https://tahmeed-courier.api.co.ke/sheet-pdfsheet-40967.pdf"><i class="icon-print"></i> PRINTABLE MANIFEST</a>
			<a class="btn btn-default load-waybils-btn" id="load-waybills" href="javascript:;"><i class="icon-arrow-up"></i> LOAD WAYBILLS</a>
		<a class="btn btn-default remove-waybil-btn" id="remove-waybills" href="javascript:;"><i class="icon-arrow-down"></i> REMOVE WAYBILLS</a>
		<a class="btn btn-default dispatch-manifest-btn" href="javascript:;"><i class="icon-truck"></i> DISPATCH MANIFEST</a>
		</div>
<div class="btn-group pull-right">
</div>
</div>

<div id="bottom-buttons-two" class="clearfix non-print hidden" style="padding: 2px 0;"><div class="btn-group pull-left hidden-el waybil-l-btn-a" style="display: block;">
<a id="back" class="btn btn-warning waybil-l-back-btn" href="javascript:;"><i class="icon-arrow-left"></i> BACK</a>
<a id="load-selected-waybills" class="btn btn-success waybil-l-load-btn" href="javascript:;"><i class="icon-arrow-up"></i> LOAD SELECTED WAYBILS</a></div></div>



@endsection
@section('scripts')
<script type="text/javascript">
    var theGrid = null;
    $(document).ready(function(){
    theGrid = $('#thegrid').DataTable({
    "processing": true,
            "dom": "t",
            "serverSide": true,
            "ordering": true,
            "responsive": true,
            "ajax": "{{url('waybill_manifests/grid')}}",
            "sEmptyTable": "Loading data from server",
            "columnDefs": [
            { "searchable": false,"orderable":false, "targets": 0 },
            { "name": "a.package_type", "targets": 5 },
            { "name": "a.origin", "targets": 7 },
            { "name": "a.destination", "targets": 8 },
            { "name": "a.status", "targets": 9 },
            {
            "render": function (data, type, row) {
                return '<input type="checkbox" class="check-item" name="waybills[]" value="'+row[0]+'"/>';
            },
                    "targets": 0
            },
            {
            "render": function (data, type, row) {
            return '<a href="{{url('/waybills')}}/' + row[0] + '">' + data + '</a>';
            },
                    "targets": 1
            }
            ]
    });
    
    $('#check-all').change(function(){
        $('.check-item').prop('checked', this.checked);
    });
    
    $("#back").click(function(){
        theGrid.ajax.reload();
        $("#bottom-buttons-two").addClass("hidden");
        $("#bottom-buttons-one").removeClass("hidden");
        
        
    });
    
    $("#load-waybills").click(function(){
        
    $.ajax({
        "url":"{{url('/waybill_manifests/filters/')}}/{{$manifest->id}}"
    }).done(function (data) {
        $("#bottom-content").html(data);
        
        $("#bottom-buttons-one").addClass("hidden");
        $("#bottom-buttons-two").removeClass("hidden");
        
    });

    });
    
        
    $("#remove-waybills").click(function(){
        var listCheck = [];
        $(".check-item:checked").each(function() {
            
            listCheck.push($(this).val());
        });
        console.log(listCheck);
        
        if(listCheck.length > 0){
            $.ajax(
                {url: "{{url('/waybill_manifests/remove_batch/')}}",
                data:{"waybill_ids":listCheck},
                type:"POST",
                success:function(data){
                    if(data === "1"){                        
                        theGrid.ajax.reload();
                        alert("Waybill(s) have been removed from manifest");
                    }
            }});
        }else{
            alert("Select waybills first");
        }
    });
    
    });    
    
</script>
@endsection