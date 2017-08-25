@extends('crudgenerator::layouts.master')

@section('content')



<h2 class="page-header">Waybill</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        View Waybill    </div>

    <div class="panel-body">
                

        <form action="{{ url('/waybills') }}" method="POST" class="form-horizontal">


                
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div class="col-sm-6">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="consignor" class="col-sm-3 control-label">Consignor</label>
            <div class="col-sm-6">
                <input type="text" name="consignor" id="consignor" class="form-control" value="{{$model['consignor'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="consignor_tel" class="col-sm-3 control-label">Consignor Tel</label>
            <div class="col-sm-6">
                <input type="text" name="consignor_tel" id="consignor_tel" class="form-control" value="{{$model['consignor_tel'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="consignee" class="col-sm-3 control-label">Consignee</label>
            <div class="col-sm-6">
                <input type="text" name="consignee" id="consignee" class="form-control" value="{{$model['consignee'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="consignee_tel" class="col-sm-3 control-label">Consignee Tel</label>
            <div class="col-sm-6">
                <input type="text" name="consignee_tel" id="consignee_tel" class="form-control" value="{{$model['consignee_tel'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="origin" class="col-sm-3 control-label">Origin</label>
            <div class="col-sm-6">
                <input type="text" name="origin" id="origin" class="form-control" value="{{$model['origin'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="destination" class="col-sm-3 control-label">Destination</label>
            <div class="col-sm-6">
                <input type="text" name="destination" id="destination" class="form-control" value="{{$model['destination'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="package_type" class="col-sm-3 control-label">Package Type</label>
            <div class="col-sm-6">
                <input type="text" name="package_type" id="package_type" class="form-control" value="{{$model['package_type'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="quantity" class="col-sm-3 control-label">Quantity</label>
            <div class="col-sm-6">
                <input type="text" name="quantity" id="quantity" class="form-control" value="{{$model['quantity'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="weight" class="col-sm-3 control-label">Weight</label>
            <div class="col-sm-6">
                <input type="text" name="weight" id="weight" class="form-control" value="{{$model['weight'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="consignor_email" class="col-sm-3 control-label">Consignor Email</label>
            <div class="col-sm-6">
                <input type="text" name="consignor_email" id="consignor_email" class="form-control" value="{{$model['consignor_email'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="payment_mode" class="col-sm-3 control-label">Payment Mode</label>
            <div class="col-sm-6">
                <input type="text" name="payment_mode" id="payment_mode" class="form-control" value="{{$model['payment_mode'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group">
            <label for="amount_per_item" class="col-sm-3 control-label">Amount Per Item</label>
            <div class="col-sm-6">
                <input type="text" name="amount_per_item" id="amount_per_item" class="form-control" value="{{$model['amount_per_item'] or ''}}" readonly="readonly">
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
            <label for="status" class="col-sm-3 control-label">Status</label>
            <div class="col-sm-6">
                <input type="text" name="status" id="status" class="form-control" value="{{$model['status'] or ''}}" readonly="readonly">
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <a class="btn btn-default" href="{{ url('/waybills') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>


        </form>

    </div>
</div>







@endsection