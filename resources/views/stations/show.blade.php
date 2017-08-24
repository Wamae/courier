@extends('crudgenerator::layouts.master')

@section('content')



<h2 class="page-header">Station</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Station    </div>

    <div class="panel-body">
                

        <form action="{{ url('/stations') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div class="col-sm-6">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="office_name" class="col-sm-3 control-label">Office Name</label>
            <div class="col-sm-6">
                <input type="text" name="office_name" id="office_name" class="form-control" value="{{$model['office_name'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="office_code" class="col-sm-3 control-label">Office Code</label>
            <div class="col-sm-6">
                <input type="text" name="office_code" id="office_code" class="form-control" value="{{$model['office_code'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="telephone_number" class="col-sm-3 control-label">Telephone Number</label>
            <div class="col-sm-6">
                <input type="text" name="telephone_number" id="telephone_number" class="form-control" value="{{$model['telephone_number'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="currency" class="col-sm-3 control-label">Currency</label>
            <div class="col-sm-6">
                <input type="text" name="currency" id="currency" class="form-control" value="{{$model['currency'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="main_office" class="col-sm-3 control-label">Main Office</label>
            <div class="col-sm-6">
                <input type="text" name="main_office" id="main_office" class="form-control" value="{{$model['main_office'] or ''}}" readonly="readonly">
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
                <a class="btn btn-default" href="{{ url('/stations') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection