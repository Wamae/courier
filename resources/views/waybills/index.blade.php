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
                            <!-- ========================================================================== -->
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="keywords">Keywords:</label>
                                <div class="col-lg-6">
                                    <input type="text" id="keywords" class="form-control input-sm" name="keywords" value="">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <!--                                //TODO: Create a waybill status table-->
                                <label class="col-lg-4 control-label" for="status">Waybill Status:</label>
                                <div class="controls col-lg-6">
                                    <select name="status_search" id="status_search" class="form-control">
                                        <option value="0">Cancelled</option>
                                        <option value="1" selected="selected">Active</option>
                                        <option value="2">Dispatched/Loaded</option>
                                        <option value="3">Delivered</option>
                                    </select>	</div>
                            </div>
                            <br>
                            <br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="package_type">Package Type:</label>
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
                                    <select name="origin_search" id="origin" data-live-search="true" class="form-control selectpicker">
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
                                <label class="col-lg-4 control-label" for="search_destination">Destination:</label>
                                <div class="controls col-lg-6">
                                    <select name="search_destination" id="search_destination" data-live-search="true" class="form-control">
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
                                <label class="col-lg-4 control-label" for="keywords">&nbsp;</label>
                                <div class="controls col-lg-6">
                                    <span class="btn btn-info btn-block search-btn" id="keywords" name="keywords"><i class="icon-search"></i> SEARCH</span>
                                </div>
                            </div>
                            <!-- ========================================================================== -->
                        </td>
                    </tr>
                </tbody></table>

        </div>
        <br>
        <div class="">
            <table class="table table-striped" id="thegrid">
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
                        <th>Weight</th>
                        <th>Status</th>
                        <th style="width:50px"></th>
                        <th style="width:50px"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <a href="{{url('waybills/create')}}" class="btn btn-primary" role="button">Add waybill</a>
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
            "ajax": "{{url('waybills/grid')}}",
            "columnDefs": [
            {
            "render": function (data, type, row) {
            return '<a href="{{ url(' / waybills') }}/' + row[0] + '">' + data + '</a>';
            },
                    "targets": 1
            },
            {
            "render": function (data, type, row) {
            return '<a href="{{ url(' / waybills') }}/' + row[0] + '/edit" class="btn btn-default">Update</a>';
            },
                    "targets": 10                    },
            {
            "render": function (data, type, row) {
            //return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger">Delete</a>';
            return '';
            },
                    "targets": 10 + 1
            },
            ]
    });
    });
    function doDelete(id) {
    if (confirm('You really want to delete this record?')) {
    $.ajax({ url: '{{ url(' / waybills') }}/' + id, type: 'DELETE'}).success(function() {
    theGrid.ajax.reload();
    });
    }
    return false;
    }
</script>
@endsection