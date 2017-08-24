@extends('crudgenerator::layouts.master')

@section('content')



<h2 class="page-header">Client</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Client    </div>

    <div class="panel-body">
                

        <form action="{{ url('/clients') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div class="col-sm-6">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="client_name" class="col-sm-3 control-label">Client Name</label>
            <div class="col-sm-6">
                <input type="text" name="client_name" id="client_name" class="form-control" value="{{$model['client_name'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="client_telephone" class="col-sm-3 control-label">Client Telephone</label>
            <div class="col-sm-6">
                <input type="text" name="client_telephone" id="client_telephone" class="form-control" value="{{$model['client_telephone'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="billing_address" class="col-sm-3 control-label">Billing Address</label>
            <div class="col-sm-6">
                <input type="text" name="billing_address" id="billing_address" class="form-control" value="{{$model['billing_address'] or ''}}" readonly="readonly">
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
            <div class="col-sm-offset-3 col-sm-6">
                <a class="btn btn-default" href="{{ url('/clients') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection