@extends('layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        OFFLOAD ITEMS FROM MANIFEST
    </div>

    <div class="panel-body">
        <div class="non-print search-panel ">
            <table width="100%">
                <tbody>
                    <tr>
                        <td width="50%">
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="manifest_no">LOADING MANIFEST:</label>
                                <div class="col-lg-6">
                                    <input type="hidden" id="hidden-id" class="form-control input-sm" name="keywords" value="">
                                    <input type="text" id="manifest-no" class="form-control input-sm" name="keywords" value="">
                                </div>
                            </div>
                            </br>
                            </br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="created_at">MANIFEST DATE:</label>
                                <div class="col-lg-6">
                                    <input type="text" id="created_at" class="form-control input-sm" name="keywords" value="{{date('D d/m/Y')}}" disabled>
                                </div>
                            </div>
                            </br>
                            </br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="origin">ORIGIN STATION:</label>
                                <div class="col-lg-6">
                                    <input type="text" id="origin" class="form-control input-sm" name="keywords" value="{{(Auth::user()->stations->office_name)}}" disabled>
                                </div>
                            </div>
                            </br>
                            </br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="destination">DESTINATION:</label>
                                <div class="col-lg-6">
                                    <input type="text" id="destination" class="form-control input-sm" name="keywords" value="" disabled>
                                </div>
                            </div>
                        </td>    
                        <td>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="loaded_items">LOADED ITEMS:</label>
                                <div class="col-lg-6">
                                    <input type="text" id="loaded-items" class="form-control input-sm" name="keywords" value="" disabled>
                                </div>
                            </div>
                            </br>
                            </br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="registration_no">REGISTRATION NO:</label>
                                <div class="col-lg-6">
                                    <input type="text" id="registration-no" class="form-control input-sm" name="keywords" value="" disabled>
                                </div>
                            </div>
                            </br>
                            </br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="driver">DRIVER:</label>
                                <div class="col-lg-6">
                                    <input type="text"id="driver" class="form-control input-sm" name="keywords" value="" disabled>
                                </div>
                            </div>
                            </br>
                            </br>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="conductor">CONDUCTOR:</label>
                                <div class="col-lg-6">
                                    <input type="text" id="conductor" class="form-control input-sm" name="keywords" value="" disabled>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="btn-group pull-right">
            <a href="{{url('waybills')}}" class="btn btn-warning cancel-btn-items">BACK</a>
            <a id="offload" class="btn btn-primary cancel-btn-items">OFFLOAD ITEMS</a>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('#manifest-no').autocomplete({
        source: "{{url('manifests/manifest_no/autocomplete')}}",
        minlenght: 1,
        autoFocus: true,
        select: function (e, data) {
            manifest = data.item;
            $("#hidden-id").val(manifest.id);
            $("#destination").val(manifest.destination);
            $("#registration-no").val(manifest.registration_no);
            $("#driver").val(manifest.driver);
            $("#conductor").val(manifest.conductor);
            $("#loaded-items").val(manifest.items);
        }
    });
    
    $('#offload').click(function(){
         id = $("#hidden-id").val();
         
         if(id == ""){
             alert("Select manifest first");
             return false;
         }
         
        $("#offload").prop("disabled","true");
         
         $.ajax({type:'POST', url: '{{ url('manifests/manifest/offload') }}',data: {id:id} }).success(function(response) {
             if(response == "1"){
                $("#offload").prop("disabled","false");
                alert("Manifest has been offloaded and SMS sent!");  
                window.location.reload();
             }else{
                $("#offload").prop("disabled","false");
                alert("Manifest offloading failed!");
                window.location.reload();
             }
    });
    });
</script>                            
@endsection