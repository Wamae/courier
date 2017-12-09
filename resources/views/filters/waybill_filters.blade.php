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
                                    <input type="hidden" id="manifest_id" class="form-control input-sm" name="keywords" value="{{$manifest_id}}">
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

<script type="text/javascript">
    var theGrid = null;
    $(document).ready(function(){
    theGrid = $('#thegrid').DataTable({
    "processing": true,
            "dom": "t",
            "serverSide": true,
            "ordering": true,
            "responsive": true,
            "ajax": "{{url('waybill_manifests/filter_grid/')}}/{{$manifest_id}}",
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
            }
            ]
    });
    
    $('#check-all').change(function(){
        $('.check-item').prop('checked', this.checked);
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
              
    $("#load-selected-waybills").click(function(){
        var listCheck = [];
        $(".check-item:checked").each(function() {
            
            listCheck.push($(this).val());
        });
        console.log(listCheck);
        //return false;       
        
        manifest_id = $("#manifest_id").val();
        if(listCheck.length > 0){
            $.ajax(
                {url: "{{url('/waybill_manifests/add_batch/')}}",
                data:{"waybill_ids":listCheck,"manifest_id":manifest_id},
                type:"POST",
                success:function(data){
                    if(data === "1"){                        
                        theGrid.ajax.reload();
                        alert("Waybill(s) have been added to manifest");
                    }
            }});
        }else{
            alert("Select waybills first");
        }
    });
    
    });
    function doDelete(id) {
    if (confirm('You really want to delete this record?')) {
    $.ajax({ url: '{{ url('/waybills') }}/' + id, type: 'DELETE'}).success(function() {
    theGrid.ajax.reload();
    });
    }
    return false;
    }
</script>