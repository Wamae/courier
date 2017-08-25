@extends('crudgenerator::layouts.master')

@section('content')


<h2 class="page-header">Payment mode</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        Add/Modify Payment mode    </div>

    <div class="panel-body">
                
        <form action="{{ url('/payment_modes'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
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
                <label for="payment_mode" class="col-sm-3 control-label">Payment Mode</label>
                <div class="col-sm-6">
                    <input type="text" name="payment_mode" id="payment_mode" class="form-control" value="{{$model['payment_mode'] or ''}}">
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
                    <a class="btn btn-default" href="{{ url('/payment_modes') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>
            </div>
        </form>

    </div>
</div>






@endsection