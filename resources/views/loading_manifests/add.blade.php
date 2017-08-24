@extends('crudgenerator::layouts.master')

@section('content')


<h2 class="page-header">Loading_manifest</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        Add/Modify Loading_manifest    </div>

    <div class="panel-body">
                
        <form action="{{ url('/loading_manifests'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            @if (isset($model))
                <input type="hidden" name="_method" value="PATCH">
            @endif


                                    <div class="form-group">
                <label for="id" class="col-sm-3 control-label">Id</label>
                <div class="col-sm-6">
                    <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
                </div>
            </div>
                                                                                                                        <div class="form-group">
                <label for="origin" class="col-sm-3 control-label">Origin</label>
                <div class="col-sm-2">
                    <input type="number" name="origin" id="origin" class="form-control" value="{{$model['origin'] or ''}}">
                </div>
            </div>
                                                                                                <div class="form-group">
                <label for="destination" class="col-sm-3 control-label">Destination</label>
                <div class="col-sm-2">
                    <input type="number" name="destination" id="destination" class="form-control" value="{{$model['destination'] or ''}}">
                </div>
            </div>
                                                                                    <div class="form-group">
                <label for="registration no" class="col-sm-3 control-label">Registration No</label>
                <div class="col-sm-6">
                    <input type="text" name="registration no" id="registration no" class="form-control" value="{{$model['registration no'] or ''}}">
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
                <label for="created_by" class="col-sm-3 control-label">Created By</label>
                <div class="col-sm-2">
                    <input type="number" name="created_by" id="created_by" class="form-control" value="{{$model['created_by'] or ''}}">
                </div>
            </div>
                                                                                                            <div class="form-group">
                <label for="created_at" class="col-sm-3 control-label">Created At</label>
                <div class="col-sm-3">
                    <input type="date" name="created_at" id="created_at" class="form-control" value="{{$model['created_at'] or ''}}">
                </div>
            </div>
                                                                                    <div class="form-group">
                <label for="updated_by" class="col-sm-3 control-label">Updated By</label>
                <div class="col-sm-2">
                    <input type="number" name="updated_by" id="updated_by" class="form-control" value="{{$model['updated_by'] or ''}}">
                </div>
            </div>
                                                                                                            <div class="form-group">
                <label for="updated_at" class="col-sm-3 control-label">Updated At</label>
                <div class="col-sm-3">
                    <input type="date" name="updated_at" id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}">
                </div>
            </div>
                                                                                    <div class="form-group">
                <label for="status" class="col-sm-3 control-label">Status</label>
                <div class="col-sm-2">
                    <input type="number" name="status" id="status" class="form-control" value="{{$model['status'] or ''}}">
                </div>
            </div>
                                                                                                <div class="form-group">
                <label for="loaded" class="col-sm-3 control-label">Loaded</label>
                <div class="col-sm-2">
                    <input type="number" name="loaded" id="loaded" class="form-control" value="{{$model['loaded'] or ''}}">
                </div>
            </div>
                                                
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Save
                    </button> 
                    <a class="btn btn-default" href="{{ url('/loading_manifests') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>
            </div>
        </form>

    </div>
</div>






@endsection