<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Document</title>
        <style>
            table{
                width: 100%;
                border-collapse: collapse;
            }
            tr, td{
                border: 0.5px solid black;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td colspan="2"><font size="1">WAYBILL NUMBER:</font><br>{{$waybill->waybill_no}}</td>
                <td colspan="2"><font size="1">TRACKING PASSWORD:</font></td>
                <td colspan="2"><font size="1">SHIPPING STATUS:</font><br>{{$waybill->waybill_status->waybill_status}}</td>
            </tr>
            <tr>
                <td colspan="2"><font size="1">CONSIGNOR:</font><br>{{$waybill->consignor}}</td>
                <td colspan="2"><font size="1">CONSIGNOR TELEPHONE:</font><br>{{$waybill->consignor_tel}}</td>
                <td colspan="2"><font size="1">ORIGIN TOWN:</font><br>{{$waybill->origins->office_name}}</td>
            </tr>
            <tr>
                <td colspan="2"><font size="1">CONSIGNEE:</font><br>{{$waybill->consignee}}</td>
                <td colspan="2"><font size="1">CONSIGNOR TELEPHONE:</font><br>{{$waybill->consignee_tel}}</td>
                <td colspan="2"><font size="1">DESTINATION TOWN:</font><br>{{$waybill->destinations->office_name}}</td>
            </tr>
            <tr>
                <td><font size="1">ISSUED ON:</font><br>{{$waybill->created_at}}</td>
                <td><font size="1">PACKAGE TYPE:</font><br>{{$waybill->package_types->package_type}}</td>
                <td><font size="1">WEIGHT:</font><br>{{$waybill->weight}}</td>
                <td><font size="1">QUANTITY:</font><br>{{$waybill->quantity}}</td>
                <td colspan="2" rowspan="2"><font size="1">Tax PIN:</font>      XXX
                    <br><font size="1">AMOUNT:</font>      {{$waybill->amount}}
                    <br><font size="1">VAT:</font>      {{$waybill->vat}}
                    <br><font size="1">TOTAL:</font>      {{($waybill->vat/100 * $waybill->amount)+$waybill->amount}}
                </td>
    </tr>
    <tr>
        <td colspan="2"><font size="1">DESCRIPTION:</font><br>{{$waybill->description}}</td>
        <td><font size="1">CBM:</font><br>{{$waybill->cbm}}</td>
        <td><font size="1"></td>
    </tr>
    <tr>
        <td colspan="2"><font size="1">SERVED BY:</font><br>{{Auth::user()->name}}</td>
        <td><font size="1">OFFICE:</font><br>{{$waybill->creator->stations->office_name}}</td>
        <td colspan="3"><font size="1">TRACKING:</font><br>http://tahmeedcoach.co.ke/</td>
    </tr>
</table>

</body>
</html>