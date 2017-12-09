@extends('layouts.app')

@section('content')


<h2 class="page-header">Manifest</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        Add/Modify  Manifest    </div>

    <div class="panel-body">

        <form action="{{ url('/manifests'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
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
                <label for="origin" class="col-sm-3 control-label">Origin</label>
                <div class="col-sm-2">
                    <input type="hidden" name="origin" class="form-control" id="origin" value="{{Auth::user()->station}}" readonly/>
                    <input name="origin_name" class="form-control" id="origin_name" value="{{Auth::user()->stations->office_name}}" readonly/>
                </div>
            </div>
            <div class="form-group">
                <label for="destination" class="col-sm-3 control-label">Destination</label>
                <div class="col-sm-2">
                    <select name="destination" class="form-control">
                        <option value="">Select a station</option>
                        @foreach($stations as $station)
                        <option {{(isset($model))?($model['destination'] == $station->id)?'selected':'':''}} value="{{$station->id}}">{{$station->office_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="registration no" class="col-sm-3 control-label">Registration No</label>
                <div class="col-sm-6">
                    <input type="text" name="registration no" id="registration no" class="form-control" value="{{$model['registration_no'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="driver" class="col-sm-3 control-label">Driver</label>
                <div class="col-sm-6">
                    <input type="text" name="driver" id="driver" class="form-control" value="{{$model['driver'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="conductor" class="col-sm-3 control-label">Conductor</label>
                <div class="col-sm-6">
                    <input type="text" name="conductor" id="conductor" class="form-control" value="{{$model['conductor'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="status" class="col-sm-3 control-label">Status</label>
                <div class="col-sm-2">
                    <select name="status" class="form-control">
                        @foreach($manifest_status as $status)
                        <option {{(isset($model))?($model['status'] == $status->id)?'selected':'':''}} value="{{$status->id}}">{{$status->status}}</option>
                        @endforeach                        
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Save
                    </button> 
                    <a class="btn btn-default" href="{{ url('/manifests') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>
            </div>
        </form>

    </div>
</div>






@endsection