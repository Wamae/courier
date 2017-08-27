@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        {{(isset($model)?"Update ".$title:"Create ".$title)}}
    </div>

    <div class="panel-body">

        <form action="{{ url('/waybill_statuses'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
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
                <label for="waybill_status" class="col-sm-3 control-label">Waybill Status</label>
                <div class="col-sm-6">
                    <input type="text" name="waybill_status" required id="waybill_status" class="form-control" value="{{$model['waybill_status'] or ''}}">
                </div>
            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <a class="btn btn-warning cancel-btn receiver-info" href="{{ url('/waybill_statuses') }}"><i class=""></i>BACK</a>
                    <button type="submit" class="btn btn-primary add-waybil-btn receiver-info">
                        <i class="fa fa-plus"></i>{{(isset($model)?"UPDATE ".$title:"CREATE ".$title)}}
                    </button> 
                </div>
            </div>
        </form>

    </div>
</div>






@endsection