@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        {{(isset($model)?"Update ".$title:"Create ".$title)}}
    </div>

    <div class="panel-body">

        <form action="{{ url('/clients'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            @if (isset($model))
            <input type="hidden" name="_method" value="PATCH">
            @endif


            <div class="form-group hidden">
                <label for="id" class="col-sm-3 control-label">Id</label>
                <div class="col-sm-6">
                    <input type="text" name="id" required id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label for="client_name" class="col-sm-3 control-label">Client Name</label>
                <div class="col-sm-6">
                    <input type="text" name="client_name" required id="client_name" class="form-control" value="{{$model['client_name'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="client_telephone" class="col-sm-3 control-label">Client Telephone</label>
                <div class="col-sm-6">
                    <input type="text" name="client_telephone" required id="client_telephone" class="form-control" value="{{$model['client_telephone'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="billing_address" class="col-sm-3 control-label">Billing Address</label>
                <div class="col-sm-6">
                    <input type="text" name="billing_address" required id="billing_address" class="form-control" value="{{$model['billing_address'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="status" class="col-sm-3 control-label">Status</label>
                <div class="col-sm-2">
                    <select name="status" class="form-control">
                        <option {{(isset($model))?($model['status'] == ACTIVE)?'selected':'':''}} value="{{ACTIVE}}">ACTIVE</option>
                        <option {{(isset($model))?($model['status'] == INACTIVE)?'selected':'':''}} value="{{INACTIVE}}">INACTIVE</option>                        
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <a class="btn btn-warning cancel-btn receiver-info" href="{{ url('/clients') }}"><i class=""></i>BACK</a>
                    <button type="submit" class="btn btn-primary add-waybil-btn receiver-info">
                        <i class="fa fa-plus"></i>{{(isset($model)?"UPDATE ".$title:"CREATE ".$title)}}
                    </button> 
                </div>
            </div>
        </form>

    </div>
</div>






@endsection