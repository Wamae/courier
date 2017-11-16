@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        {{(isset($model)?"Update ".$title:"Create ".$title)}}
    </div>

    <div class="panel-body">

        <form action="{{ url('invoices'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            @if (isset($model))
            <input type="hidden" name="_method" value="PATCH"/>
            @endif


            <div class="form-group hidden">
                <label for="id" class="col-sm-3 control-label">Id</label>
                <div class="col-sm-6">
                    <input type="text" name="id" required id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label for="invoice_date" class="col-sm-3 control-label">Invoice Date</label>
                <div class="col-sm-6">
                    <input type="text" name="invoice_date" required id="invoice-date" class="form-control" value="{{$model['created_by'] or date('d F Y')}}" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label for="client_id" class="col-sm-3 control-label">Client Name</label>
                <div class="col-sm-6">
                    <select name="client_id" class="form-control">
                        @foreach($clients as $client)
                        <option {{(isset($model))?($model['client_id'] == $client->id)?'selected':'':''}} value="{{$client->id}}">{{$client->client_name}}</option>   
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="currency_id" class="col-sm-3 control-label">Currency</label>
                <div class="col-sm-6">
                    <select name="currency_id" class="form-control">
                        @foreach($currencies as $currency)
                        <option {{(isset($model))?($model['currency_id'] == $currency->id)?'selected':'':''}} value="{{$currency->id}}">{{$currency->currency}}</option>   
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="due_date" class="col-sm-3 control-label">Due Date</label>
                <div class="col-sm-6">
                    <div class='input-group date' id='due-date'>
                        <input type='text' name="due_date" class="form-control" value="{{$model['due_date'] or ''}}" onkeydown="return false"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar">
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <a class="btn btn-warning cancel-btn receiver-info" href="{{ url('invoices') }}"><i class=""></i>BACK</a>
                    <button type="submit" class="btn btn-primary add-waybil-btn receiver-info">
                        <i class="fa fa-plus"></i>{{(isset($model)?"UPDATE ".$title:"CREATE ".$title)}}
                    </button> 
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript">
    var theGrid = null;
    $(document).ready(function () {

        $('#due-date').datetimepicker({
            format: 'DD MMMM YYYY'
        });

    });

</script>

@endsection