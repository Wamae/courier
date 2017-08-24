@extends('crudgenerator::layouts.master')

@section('content')



<h2 class="page-header">Package_type</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Package_type    </div>

    <div class="panel-body">
                

        <form action="{{ url('/package_types') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div class="col-sm-6">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="package_type" class="col-sm-3 control-label">Package Type</label>
            <div class="col-sm-6">
                <input type="text" name="package_type" id="package_type" class="form-control" value="{{$model['package_type'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-6">
                <input type="text" name="description" id="description" class="form-control" value="{{$model['description'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="status" class="col-sm-3 control-label">Status</label>
            <div class="col-sm-6">
                <input type="text" name="status" id="status" class="form-control" value="{{$model['status'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="created_at" class="col-sm-3 control-label">Created At</label>
            <div class="col-sm-6">
                <input type="text" name="created_at" id="created_at" class="form-control" value="{{$model['created_at'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="created_by" class="col-sm-3 control-label">Created By</label>
            <div class="col-sm-6">
                <input type="text" name="created_by" id="created_by" class="form-control" value="{{$model['created_by'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="updated_at" class="col-sm-3 control-label">Updated At</label>
            <div class="col-sm-6">
                <input type="text" name="updated_at" id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="updated_by" class="col-sm-3 control-label">Updated By</label>
            <div class="col-sm-6">
                <input type="text" name="updated_by" id="updated_by" class="form-control" value="{{$model['updated_by'] or ''}}" readonly="readonly">
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <a class="btn btn-default" href="{{ url('/package_types') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection