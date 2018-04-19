@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        {{(isset($model)?"UPDATE WAYBILL":"CREATE WAYBILL")}}    </div>

    <div class="panel-body">

        <form id="form-add-waybill" action="{{ url('/waybills'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">
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
                                <div class="col-lg-8 non-acc" id="consignor-div">
                                    <input type="text" name="consignor" required id="consignor" class="form-control" value="{{$model['consignor'] or ''}}">
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="consignor_name">CONSIGNOR TEL:<sup>*</sup></label>

                                <div class="col-lg-8 non-acc" id="consignor-tel-div">
                                    <input placeholder="+(254) 712-345-678" type="text" name="consignor_tel" required id="consignor-tel" class="form-control phone" value="">
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
                                    <input placeholder="+(254) 712-345-678" type="text" name="consignee_tel" required id="consignee-tel" class="form-control phone" value="{{$model['consignee_tel'] or ''}}">
                                </div>
                            </div>

                            <div class="control-group form-group">
                                <!--<label class="col-lg-4 control-label" for="origin">ORIGIN:<sup>*</sup></label>-->
                                <div class="col-lg-8">
                                    <!--<select name="origin" class="form-control">
                                        @foreach($stations as $station)
                                        <option {{(isset($model))?($model['origin'] == $station->id)?'selected':'':''}} value="{{$station->id}}">{{$station->office_name}}</option>   
                                        @endforeach
                                    </select>-->
                                    <input type="hidden" name="origin" required id="origin" class="form-control" value="{{isset($model['origin'])?$model['origin']:Auth::user()->station}}">
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
                                <label class="col-lg-4 control-label" for="consignor_name">CONSIGNOR EMAIL:</label>
                                <div class="col-lg-8">
                                    <input type="text" id="consignor_email" name="consignor_email" placeholder="e.g. name@gmail.com" class="form-control" value="{{$model['consignor_email'] or ''}}">
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
                                    <select name="payment_mode" required id="payment-mode"  data-live-search="true" class="form-control selectpicker">
                                        @foreach($payment_modes as $payment_mode)
                                        <option {{(isset($model))?($model['payment_mode'] == $payment_mode->id)?'selected':'':''}} value="{{$payment_mode->id}}">{{$payment_mode->payment_mode}}</option>   
                                        @endforeach
                                    </select>   </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label" for="per_item">AMOUNT PER ITEM:<sup>*</sup></label>
                                <div class="col-lg-4">
                                    <select name="currency_id" id="currency-id" class="form-control selectpicker">
                                        @foreach($currencies as $currency)
                                        @if($currency->id == KSH)
                                        <option value="{{$currency->id}}" selected="selected">{{$currency->currency}}</option>
                                        @else
                                        <option value="{{$currency->id}}">{{$currency->currency}}</option>
                                        @endif
                                        @endforeach
                                    </select>   </div>
                                <div class="col-lg-4">
                                    <input type="number" min="100" required id="amount_per_item" name="amount_per_item" class="form-control" value="{{$model['amount_per_item'] or ''}}">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="vat"> INCLUDED V.A.T (16.0%):</label>
                                <input id="vat-per" value="16" hidden="true" type="number"/>

                                <div class="col-lg-4">
                                    <select name="currency_vat" id="currency-vat" class="form-control selectpicker" disabled>
                                        @foreach($currencies as $currency)
                                        @if($currency->id == KSH)
                                        <option value="{{$currency->id}}" selected="selected">{{$currency->currency}}</option>
                                        @else
                                        <option value="{{$currency->id}}">{{$currency->currency}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <input type="text" id="vat" name="vat" readonly="readonly" class="form-control" value="">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <label class="col-lg-4 control-label" for="amount"> AMOUNT:</label>

                                <div class="col-lg-4">
                                    <select name="currency_amount" id="currency-amount" class="form-control selectpicker" disabled>
                                        @foreach($currencies as $currency)
                                        @if($currency->id == KSH)
                                        <option value="{{$currency->id}}" selected="selected">{{$currency->currency}}</option>
                                        @else
                                        <option value="{{$currency->id}}">{{$currency->currency}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

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
                    <button id="create-waybill" type="submit" class="btn btn-primary add-waybil-btn receiver-info">
                        <i class="fa fa-plus"></i> {{(isset($model)?"UPDATE WAYBILL":"CREATE WAYBILL")}}
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
        $('.phone').mask("+999999999999");
        
        $("#form-add-waybill").submit(function(event){
            event.preventDefault();
            
            amount = $("#amount_per_item").val();
            consignor = $("#consignor").val();

            swal({
                title: 'PLEASE CONFIRM THAT YOU HAVE RECEIVED KSH'+amount+' FROM '+consignor,
                text: "ARE YOU SURE THAT YOU WANT TO CONTINUE?!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00FF7F',
                cancelButtonColor: '#D33',
                confirmButtonText: 'Recieved'
              }).then((result) => {
                if (result.value) {
                     $(this).unbind('submit').submit();
                }
              });
        });
        $("#amount_per_item").keyup(function () {
            vatPer = $("#vat-per").val();

            amountPerItem = $(this).val();
            vatAmount = (vatPer / 100) * amountPerItem;
            $("#vat").val(vatAmount);
            finalAmount = Math.ceil(amountPerItem - vatAmount);

            $("#amount").val(finalAmount);
        });

        $("#payment-mode").change(function () {
            paymentMode = $(this).val();
            //if(paymentMode == 4){
			consignorName = $("#consignor").val();
			if(consignorName.length < 3){
				consignorName = "";
			}
            changeConsignorDetails(paymentMode,consignorName);
			
			if(paymentMode == "{{FREE_OF_CHARGE}}" ){
				$("#amount_per_item").attr("min", "0");
				$("#amount_per_item").val("0");
				$("#vat").val("0");
				$("#amount").val("0");
				$("#amount_per_item").attr("readonly", true);
				
			}else{
				$("#amount_per_item").attr("min", "100");
				$("#amount_per_item").val("0");
				$("#vat").val("0");
				$("#amount").val("0");
				$("#amount_per_item").attr("readonly", false);
			}
            //}
        });

        function changeConsignorDetails(paymentMode,consignorName) {
            if (paymentMode == "{{ACCOUNT_PAYMENT}}") {
                $.ajax({
                    url: "{{url('clients/getClients/all')}}",
                    dataType: "JSON",
                    success: function (clients) {
                        clientOptions = `<select id='consignor' name='client_id' 
                onchange='consignorUpdate(this.options[this.selectedIndex].getAttribute("phone"))' class='form-control'>`;
                        for (i = 0; i < clients.length; i++) {
                            clientOptions += `<option phone='${clients[i].client_telephone}' value='${clients[i].id}'>${clients[i].client_name}</option>`;
                        }
                        $("#consignor-div").html(clientOptions);
                        
                        $("#consignor-tel").val(clients[0].client_telephone);
                        $("#consignor-tel").attr("readonly", true);

                    }
                });

            } else {
            
                /*htmlString = '<input type="text" name="consignor_tel" required id="consignor_tel"  placeholder="+(254) 712-345-678" class="form-control" value="{{$model["consignor_tel"] or ""}}">';
                $("#consignor-tel-div").html(htmlString);*/
				$("#consignor-tel").attr("readonly", false);
                
                $("#consignor-div").html('<input type="text" name="consignor" required id="consignor" class="form-control" value="'+consignorName+'">');
            }
        }
    });

    function consignorUpdate(phone) {
        console.log(phone);
        $("#consignor-tel").val(phone);
    }

    $("#currency-id").change(function(){
        let currencyId = $(this).val();
        $("#currency-vat").val(currencyId);
        $("#currency-amount").val(currencyId);
    });
</script>
@endsection

@endsection

