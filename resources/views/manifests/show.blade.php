@extends('crudgenerator::layouts.master')

@section('content')



<h2 class="page-header">Loading_manifest</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Loading_manifest    </div>

    <div class="panel-body">
                

        <form action="{{ url('/manifests') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div class="col-sm-6">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="origin" class="col-sm-3 control-label">Origin</label>
            <div class="col-sm-6">
                <input type="text" name="origin" id="origin" class="form-control" value="{{$model['origin'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="destination" class="col-sm-3 control-label">Destination</label>
            <div class="col-sm-6">
                <input type="text" name="destination" id="destination" class="form-control" value="{{$model['destination'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="registration no" class="col-sm-3 control-label">Registration No</label>
            <div class="col-sm-6">
                <input type="text" name="registration no" id="registration no" class="form-control" value="{{$model['registration no'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="driver" class="col-sm-3 control-label">Driver</label>
            <div class="col-sm-6">
                <input type="text" name="driver" id="driver" class="form-control" value="{{$model['driver'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="conductor" class="col-sm-3 control-label">Conductor</label>
            <div class="col-sm-6">
                <input type="text" name="conductor" id="conductor" class="form-control" value="{{$model['conductor'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="created_by" class="col-sm-3 control-label">Created By</label>
            <div class="col-sm-6">
                <input type="text" name="created_by" id="created_by" class="form-control" value="{{$model['created_by'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="created_at" class="col-sm-3 control-label">Created At</label>
            <div class="col-sm-6">
                <input type="text" name="created_at" id="created_at" class="form-control" value="{{$model['created_at'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="updated_by" class="col-sm-3 control-label">Updated By</label>
            <div class="col-sm-6">
                <input type="text" name="updated_by" id="updated_by" class="form-control" value="{{$model['updated_by'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="updated_at" class="col-sm-3 control-label">Updated At</label>
            <div class="col-sm-6">
                <input type="text" name="updated_at" id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="status" class="col-sm-3 control-label">Status</label>
            <div class="col-sm-6">
                <input type="text" name="status" id="status" class="form-control" value="{{$model['status'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="loaded" class="col-sm-3 control-label">Loaded</label>
            <div class="col-sm-6">
                <input type="text" name="loaded" id="loaded" class="form-control" value="{{$model['loaded'] or ''}}" readonly="readonly">
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <a class="btn btn-default" href="{{ url('/manifests') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection