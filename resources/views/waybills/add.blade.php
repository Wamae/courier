@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        {{(isset($model)?"UPDATE WAYBILL":"CREATE WAYBILL")}}    </div>

    <div class="panel-body">

        <form action="{{ url('/waybills'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            @if (isset($model))
            <input type="hidden" name="_method" value="PATCH">
            @endif


            <div class="modal-header">
                <div class="form_heading">WAYBIL INFORMATION DETAILS</div>
            </div>
            <div class="modal-body">
                <!-- MODAL BODY -->
                <table width="100%">
                    <tr>
                        <td valign="top" width="50%">
                            <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->

                            <div class="form-group hidden">
                                <label for="id" class="col-sm-3 control-label">Id</label>
                                <div class="col-sm-6">
                                    <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <!--   ---->
                                <label class="col-lg-4 control-label" for="consignor_name">CONSIGNOR:<sup>*</sup></label>

                                <!--   ---->
                                <!-- <label class="col-lg-4 control-label" for="consignor_name">CONSIGNOR:<sup>*</sup></label> ---->
                                <div class="col-lg-8 non-acc">
                                    <input type="text" name="consignor" required id="consignor" class="form-control" value="{{$model['consignor'] or ''}}">
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="consignor_name">CONSIGNOR TEL:<sup>*</sup></label>

                                <div class="col-lg-8 non-acc">
                                    <input type="text" name="consignor_tel" required id="consignor_tel" class="form-control" value="{{$model['consignor_tel'] or ''}}">
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="consignor_name">CONSIGNEE:<sup>*</sup></label>
                                <div class="col-lg-8">
                                    <input type="text" name="consignee" required id="consignee" class="form-control" value="{{$model['consignee'] or ''}}">
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="consignor_name">CONSIGNEE TEL:<sup>*</sup></label>
                                <div class="col-lg-8">
                                    <input type="text" name="consignee_tel" required id="consignee_tel" class="form-control" value="{{$model['consignee_tel'] or ''}}">
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="origin">ORIGIN:<sup>*</sup></label>
                                <div class="col-lg-8">
                                    <select name="origin" class="form-control">
                                        @foreach($stations as $station)
                                        <option {{(isset($model))?($model['origin'] == $station->id)?'selected':'':''}} value="{{$station->id}}">{{$station->office_name}}</option>   
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="$stations">DESTINATION:<sup>*</sup></label>
                                <div class="col-lg-8">
                                    <select name="destination" class="form-control">
                                        @foreach($stations as $station)
                                        <option {{(isset($model))?($model['destination'] == $station->id)?'selected':'':''}} value="{{$station->id}}">{{$station->office_name}}</option>   
                                        @endforeach
                                    </select></div>
                            </div>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="package_type">PACKAGE TYPE:<sup>*</sup></label>
                                <div class="col-lg-8">
                                    <select name="package_type" required id="package_type" data-live-search="true" class="form-control selectpicker">
                                        @foreach($package_types as $package_type)
                                        <option {{(isset($model))?($model['package_type'] == $package_type->id)?'selected':'':''}} value="{{$package_type->id}}">{{$package_type->package_type}}</option>   
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="quantity">QUANTITY:<sup>*</sup></label>
                                <div class="col-lg-8">
                                    <input type="number" name="quantity" required min="1" required id="quantity" class="form-control" value="{{$model['quantity'] or ''}}"/>
                                </div>
                            </div>
                            <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
                        </td>
                        <td valign="top" width="50%">
                            <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="weight">WEIGHT:</label>
                                <div class="col-lg-3">
                                    <input type="text" id="weight" name="weight" placeholder=" e.g 5 KGS" class="form-control" value="{{$model['weight'] or ''}}">
                                </div>
                                <label class="col-lg-2 control-label" for="cbm">CBM:</label>
                                <div class="col-lg-3">
                                    <input type="text" id="cbm" name="cbm" placeholder=" e.g 2 CBM" class="form-control" value="{{$model['cbm'] or ''}}">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="consignor_name">CONSIGNOR EMAIL:<sup>*</sup></label>
                                <div class="col-lg-8">
                                    <input type="text" id="consignor_email" name="consignor_email" required placeholder="e.g. name@gmail.com" class="form-control" value="{{$model['consignor_email'] or ''}}">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="description">DESCRIPTION:</label>
                                <div class="controls col-lg-8">
                                    <textarea name="description" id="description" class="form-control" placeholder="Write a comment that may be useful in the shipping process">{{$model['description'] or ''}}</textarea>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="payment_mode">PAYMENT MODE:<sup>*</sup></label>
                                <div class="col-lg-8">
                                    <select name="payment_mode" required id="payment_mode"  data-live-search="true" class="form-control selectpicker">
                                        @foreach($payment_modes as $payment_mode)
                                        <option {{(isset($model))?($model['payment_mode'] == $payment_mode->id)?'selected':'':''}} value="{{$payment_mode->id}}">{{$payment_mode->payment_mode}}</option>   
                                        @endforeach
                                    </select>   </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label" for="per_item">AMOUNT PER ITEM:<sup>*</sup></label>
                                <div class="col-lg-4">
                                    <select name="currency_perItem" id="currency_perItem" class="form-control selectpicker">
                                        <option value="ksh" selected="selected">KSH</option>
                                    </select>   </div>
                                <div class="col-lg-4">
                                    <input type="number" min="100" required id="amount_per_item" name="amount_per_item" class="form-control" value="{{$model['amount_per_item'] or ''}}">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="vat"> INCLUDED V.A.T (16.0%):</label>
                                <input id="vat-per" value="16" hidden="true" type="number"/>

                                <div class="col-lg-4">
                                    <select name="currency_vat" id="currency_vat" class="form-control selectpicker">
                                        <option value="ksh" selected="selected">KSH</option>
                                    </select>   </div>

                                <div class="col-lg-4">
                                    <input type="text" id="vat" name="vat" readonly="readonly" class="form-control" value="">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="amount"> AMOUNT:</label>

                                <div class="col-lg-4">
                                    <select name="currency" id="currency" class="form-control selectpicker">
                                        <option value="ksh" selected="selected">KSH</option>
                                    </select>   </div>

                                <div class="col-lg-4">
                                    <input type="text" id="amount" name="amount" readonly="readonly" class="form-control" value="{{$model['amount'] or ''}}">
                                </div>

                            </div>
                        </td>
                    </tr>
                </table>

            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <a class="btn btn-warning cancel-btn receiver-info" href="{{ url('/waybills') }}"><i class=""></i>BACK</a>
                    <button type="submit" class="btn btn-primary add-waybil-btn receiver-info">
                        <i class="fa fa-plus"></i>{{(isset($model)?"UPDATE WAYBILL":"CREATE WAYBILL")}}
                    </button> 
                </div>
            </div>

    </div>
</form>             
</div>
</div>

@section('scripts')
<script>
    $(function () {
        $("#amount_per_item").keyup(function () {
            vatPer = $("#vat-per").val();

            amountPerItem = $(this).val();
            vatAmount = (vatPer / 100) * amountPerItem;
            $("#vat").val(vatAmount);
            finalAmount = Math.ceil(amountPerItem - vatAmount);

            $("#amount").val(finalAmount);
        });
    });
</script>
@endsection

@endsection

