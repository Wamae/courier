@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        {{(isset($model)?"Update ".$title:"Create ".$title)}}
    </div>

    <div class="panel-body">
                
        <form action="{{ url('/waybill_manifests'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
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
                <label for="manifest" class="col-sm-3 control-label">Manifest</label>
                <div class="col-sm-2">
                    <input type="number" name="manifest" required id="manifest" class="form-control" value="{{$model['manifest'] or ''}}">
                </div>
            </div>
                                                                                                <div class="form-group">
                <label for="waybill" class="col-sm-3 control-label">Waybill</label>
                <div class="col-sm-2">
                    <input type="number" name="waybill" required id="waybill" class="form-control" value="{{$model['waybill'] or ''}}">
                </div>
            </div>
                                                                                                <div class="form-group">
                <label for="status" class="col-sm-3 control-label">Status</label>
                <div class="col-sm-2">
                    <input type="number" name="status" required id="status" class="form-control" value="{{$model['status'] or ''}}">
                </div>
            </div>
                                                                                                <div class="form-group">
                <label for="created_by" class="col-sm-3 control-label">Created By</label>
                <div class="col-sm-2">
                    <input type="number" name="created_by" required id="created_by" class="form-control" value="{{$model['created_by'] or ''}}">
                </div>
            </div>
                                                                                                            <div class="form-group">
                <label for="created_at" class="col-sm-3 control-label">Created At</label>
                <div class="col-sm-3">
                    <input type="date" name="created_at" required id="created_at" class="form-control" value="{{$model['created_at'] or ''}}">
                </div>
            </div>
                                                                                    <div class="form-group">
                <label for="updated_by" class="col-sm-3 control-label">Updated By</label>
                <div class="col-sm-2">
                    <input type="number" name="updated_by" required id="updated_by" class="form-control" value="{{$model['updated_by'] or ''}}">
                </div>
            </div>
                                                                                                            <div class="form-group">
                <label for="updated_at" class="col-sm-3 control-label">Updated At</label>
                <div class="col-sm-3">
                    <input type="date" name="updated_at" required id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}">
                </div>
            </div>
                                                
            <div class="modal-footer">
                <div class="btn-group">
                    <a class="btn btn-warning cancel-btn receiver-info" href="{{ url('/waybill_manifests') }}"><i class=""></i>BACK</a>
                    <button type="submit" class="btn btn-primary add-waybil-btn receiver-info">
                        <i class="fa fa-plus"></i>{{(isset($model)?"UPDATE ".$title:"CREATE ".$title)}}
                    </button> 
                </div>
            </div>
        </form>

    </div>
</div>






@endsection