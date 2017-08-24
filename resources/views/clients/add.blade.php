@extends('crudgenerator::layouts.master')

@section('content')


<h2 class="page-header">Client</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        Add/Modify Client    </div>

    <div class="panel-body">
                
        <form action="{{ url('/clients'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            @if (isset($model))
                <input type="hidden" name="_method" value="PATCH">
            @endif


            <div class="form-group hidden">
                <label for="id" class="col-sm-3 control-label">Id</label>
                <div class="col-sm-6">
                    <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
                </div>
            </div>
                                                                                                            <div class="form-group">
                <label for="client_name" class="col-sm-3 control-label">Client Name</label>
                <div class="col-sm-6">
                    <input type="text" name="client_name" id="client_name" class="form-control" value="{{$model['client_name'] or ''}}">
                </div>
            </div>
                                                                                                <div class="form-group">
                <label for="client_telephone" class="col-sm-3 control-label">Client Telephone</label>
                <div class="col-sm-6">
                    <input type="text" name="client_telephone" id="client_telephone" class="form-control" value="{{$model['client_telephone'] or ''}}">
                </div>
            </div>
                                                                                                <div class="form-group">
                <label for="billing_address" class="col-sm-3 control-label">Billing Address</label>
                <div class="col-sm-6">
                    <input type="text" name="billing_address" id="billing_address" class="form-control" value="{{$model['billing_address'] or ''}}">
                </div>
            </div>

            <div class="form-group">
                <label for="status" class="col-sm-3 control-label">Status</label>
                <div class="col-sm-2">
                    <select name="status" class="form-control">
                        <option value="{{$model['status'] or '1'}}">ACTIVE</option>
                        <option value="{{$model['status'] or '0'}}">INACTIVE</option>                        
                    </select>
                </div>
            </div>
                                    
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Save
                    </button> 
                    <a class="btn btn-default" href="{{ url('/clients') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>
            </div>
        </form>

    </div>
</div>






@endsection