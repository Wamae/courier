@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        List of {{ ucfirst('waybills') }}
    </div>

    <div class="panel-body">
        <div class="non-print search-panel ">

            <table width="100%">
                <tbody><tr>
                        <td width="50%">
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="keywords">Keywords:</label>
                                <div class="col-lg-6">
                                    <input type="text" id="keywords" class="form-control input-sm" name="keywords" value="">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="status_search">Waybill Status:</label>
                                <div class="controls col-lg-6">
                                    <select name="status_search" id="status_search" class="form-control">
                                        <option value="0" selected="selected">ALL TYPES</option>
                                        @foreach($waybill_statuses as $waybill_status)
                                        <option {{(isset($model))?($model['waybill_status'] == $waybill_status->id)?'selected':'':''}} value="{{$waybill_status->id}}">{{$waybill_status->waybill_status}}</option>   
                                        @endforeach
                                    </select>	</div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="package_type_search">Package Type:</label>
                                <div class="controls col-lg-6">
                                    <select name="package_type_search" id="package_type_search" class="form-control">
                                        <option value="0" selected="selected">ALL TYPES</option>
                                        @foreach($package_types as $package_type)
                                        <option {{(isset($model))?($model['package_type'] == $package_type->id)?'selected':'':''}} value="{{$package_type->id}}">{{$package_type->package_type}}</option>   
                                        @endforeach
                                    </select>		
                                </div>
                            </div>

                            <!-- ========================================================================== -->
                        </td>
                        <td width="50%">
                            <!-- ========================================================================== -->
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="origin">Origin Station:</label>
                                <div class="controls col-lg-6">
                                    <select name="origin_search" id="origin_search" data-live-search="true" class="form-control selectpicker">
                                        <option value="0" selected="selected">ALL STATIONS</option>
                                        @foreach($stations as $station)
                                        <option {{(isset($model))?($model['destination'] == $station->id)?'selected':'':''}} value="{{$station->id}}">{{$station->office_name}}</option>   
                                        @endforeach
                                    </select>		
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="destination_search">Destination:</label>
                                <div class="controls col-lg-6">
                                    <select name="destination_search" id="destination_search" data-live-search="true" class="form-control">
                                        <option value="0" selected="selected">ALL STATIONS</option>
                                        @foreach($stations as $station)
                                        <option {{(isset($model))?($model['destination'] == $station->id)?'selected':'':''}} value="{{$station->id}}">{{$station->office_name}}</option>   
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <br>
                            <!-- ========================================================================== -->
                        </td>
                    </tr>
                </tbody></table>

        </div>
        <br>
        <div class="">
            <table class="table table-striped table-responsive table-condensed" id="thegrid">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Waybill</th>
                        <th>Date</th>
                        <th>Consignor</th>
                        <th>Consignee</th>                                        
                        <th>Package</th>
                        <th>Quantity</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th class="none">Weight</th>
                        <th>Status</th>
                        <th style="width:50px"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        @can('create waybill')
        <a href="{{url('waybills/create')}}" class="btn btn-primary" role="button">CREATE WAYBILL</a>
        @endcan
        <a href="{{url('manifests/offload/manifest')}}" class="btn btn-info" role="button">OFFLOAD MANIFEST</a>
    </div>
</div>




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
            "language": {
            "sLoadingRecords": "LOADING"
            },
            "processing" : true,
            "ajax": "{{url('waybills/grid')}}",
            "sEmptyTable": "Loading data from server",
            "columnDefs": [
            { "name": "a.package_type", "targets": 5 },
            { "name": "a.origin", "targets": 7 },
            { "name": "a.destination", "targets": 8 },
            { "name": "a.status", "targets": 9 },
            {
            "render": function (data, type, row) {
            return '<a href="{{ url('waybills') }}/' + row[0] + '">' + data + '</a>';
            },
                    "targets": 1
            },
            {
            "render": function (data, type, row) {
              
            @can('create waybill')
            if(row[10] === "ACTIVE"){  
                return '<a href="{{ url('waybills') }}/' + row[0] + '/edit" class="btn btn-default">Update</a>';
            }else{
                return '<a href="{{ url('waybills') }}/print_waybill/pdf?id=' + row[0] + '" class="btn btn-status btn-xs btn-success"><span class="glyphicon glyphicon-print"></span> Print</a>';
            }
            @else
                return '';
            @endcan
            },
                    "targets": 11
            },
            ]
    });
    $("#keywords").keyup(function(){
    var keywords = $(this).val().trim();
    if (keywords == "") {
    theGrid.search("").draw();
    } else {
    console.log("Keywords: ", keywords);
    theGrid.search(keywords).draw();
    }
    });
    $("#package_type_search").change(function(){
    var packageType = $(this).val();
    if (packageType == "0") {
    theGrid.columns(5).search(packageType).draw();
    } else {

    console.log("Packgage type: ", packageType);
    theGrid.columns(5).search(packageType, false, true, true).draw();
    }
    });
    $("#origin_search").change(function(){
    var origin = $(this).val();
    if (origin == "0") {
    theGrid.columns(7).search(origin).draw();
    } else {
    console.log("Origin: ", origin);
    theGrid.columns(7).search(origin, false, true, true).draw();
    }
    });
    $("#destination_search").change(function(){
    var destination = $(this).val();
    if (destination == "0") {
    theGrid.columns(8).search(destination).draw();
    } else {
    console.log("Destination: ", destination);
    theGrid.columns(8).search(destination, false, true, true).draw();
    }
    });
    $("#status_search").change(function(){
    var status = $(this).val();
    if (status == "0") {
    theGrid.columns(9).search(status).draw();
    } else {
    console.log("status: ", status);
    theGrid.columns(9).search(status, false, true, true).draw();
    }
    });
    });
    function doDelete(id) {
    if (confirm('You really want to delete this record?')) {
    $.ajax({ url: '{{ url('waybills') }}/' + id, type: 'DELETE'}).success(function() {
    theGrid.ajax.reload();
    });
    }
    return false;
    }
</script>
@endsection