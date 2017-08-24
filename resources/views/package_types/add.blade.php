@extends('crudgenerator::layouts.master')

@section('content')


<h2 class="page-header">Package type</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        Add/Modify Package type    </div>

    <div class="panel-body">
                
        <form action="{{ url('/package_types'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            @if (isset($model))
                <input type="hidden" name="_method" value="PATCH">
            @endif


            <div class="form-group hidden">
                <label for="id" class="col-sm-3 control-label">Id</label>
                <div class="col-sm-6">
                    <input type="hidden" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
                </div>
            </div>
                                                                                                            <div class="form-group">
                <label for="package_type" class="col-sm-3 control-label">Package Type</label>
                <div class="col-sm-6">
                    <input type="text" name="package_type" id="package_type" class="form-control" value="{{$model['package_type'] or ''}}">
                </div>
            </div>
                                                                                                                                    <div class="form-group">
                <label for="description" class="col-sm-3 control-label">Description</label>
                <div class="col-sm-6">
                    <input type="text" name="description" id="description" class="form-control" value="{{$model['description'] or ''}}">
                </div>
            </div>
                                                                        <div class="form-group">
                <label for="status" class="col-sm-3 control-label">Status</label>
                <div class="col-sm-2">
                    <select name="status" class="form-control">
                        <option value="{{$model['status'] or '0'}}">INACTIVE</option>
                        <option value="{{$model['status'] or '1'}}">ACTIVE</option>
                    </select>
                </div>
            </div>
                                                                                                          <!--   <div class="form-group">
                <label for="created_at" class="col-sm-3 control-label">Created At</label>
                <div class="col-sm-3">
                    <input type="date" name="created_at" id="created_at" class="form-control" value="{{$model['created_at'] or ''}}">
                </div>
            </div> 
                                                                                    <div class="form-group">
                <label for="created_by" class="col-sm-3 control-label">Created By</label>
                <div class="col-sm-2">
                    <input type="number" name="created_by" id="created_by" class="form-control" value="{{$model['created_by'] or ''}}">
                </div>
            </div>
                                                                                                            <div class="form-group">
                <label for="updated_at" class="col-sm-3 control-label">Updated At</label>
                <div class="col-sm-3">
                    <input type="date" name="updated_at" id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}">
                </div>
            </div>
                                                                                    <div class="form-group">
                <label for="updated_by" class="col-sm-3 control-label">Updated By</label>
                <div class="col-sm-2">
                    <input type="number" name="updated_by" id="updated_by" class="form-control" value="{{$model['updated_by'] or ''}}">
                </div>
            </div>-->
                                                
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Save
                    </button> 
                    <a class="btn btn-default" href="{{ url('/package_types') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>
            </div>
        </form>

    </div>
</div>






@endsection