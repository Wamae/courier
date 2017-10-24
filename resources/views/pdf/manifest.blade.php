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
            th,tr, td{
                border: 0.5px solid black;
            }
        </style>
    </head>
    <body>
        <div align="center">{{config('app.name')}} LOADING MANIFEST REPORT</div>
        <table>
            <tr>
                <td><font size="1">MANIFEST REF:</font></td>
                <td><font size="1"><b>{{$manifest->manifest_no}}</b></font></td>
                <td><font size="1">FROM:</font></td>
                <td><font size="1"><b>{{$manifest->origins->office_name}}</b></font></td>
            </tr>
            <tr>
                <td><font size="1">REG NUMBER:</font></td>
                <td><font size="1"><b>{{$manifest->registration_no}}</b></font></td>
                <td><font size="1">TO:</font></td>
                <td><font size="1"><b>{{$manifest->destinations->office_name}}</b></font></td>
            </tr>
            <tr>
                <td><font size="1">DATE:</font></td>
                <td><font size="1"><b>{{$manifest->created_at->format('D d/m/Y')}}</b></font></td>
                <td><font size="1">DRIVER:</font></td>
                <td><font size="1"><b>{{$manifest->driver}}</b></font></td>
            </tr>
            <tr>
                <td><font size="1">ITEMS LOADED:</font></td>
                <td><font size="1"><b>{{isset($manifest->waybill_manifest)?$manifest->waybill_manifest->count('waybill'):0}}</b></font></td>
                <td><font size="1">CONDUCTOR:</font></td>
                <td><font size="1"><b>{{$manifest->conductor}}</b></font></td>
            </tr>
        </table>
        <br>
        <br>
        <div align="center">LOADED WAYBILLS</div>
        <table>
            
            <thead>
                <tr>
                    <th><font size="1">#</font></th>
                    <th style="width: 150px;"><font size="1">WAYBILL</font></th>
                    <th><font size="1">CONSIGNOR</font></th>
                    <th><font size="1">CONSIGNEE</font></th>
                    <th><font size="1">PACKAGE</font></th>
                    <th><font size="1">SYSTEM USER</font></th>
                    <th><font size="1">QUANTITY</font></th>
                    <th><font size="1">FROM</font></th>
                    <th><font size="1">DEST</font></th>
                </tr>
            </thead>
            @foreach($manifest->waybills as $waybill)
            <tr>
                <td><font size="1">{{$loop->iteration}}</font></td>
                <td><font size="1">{{$waybill->waybill_no}}</font></td>
                <td><font size="1">{{$waybill->consignor}}</font></td>
                <td><font size="1">{{$waybill->consignee}}</font></td>
                <td><font size="1">{{$waybill->package_types->package_type}}</font></td>
                <td><font size="1">{{$waybill->creator->name}}</font></td>
                <td><font size="1">{{$waybill->quantity}}</font></td>
                <td><font size="1">{{$waybill->origins->office_name}}</font></td>
                <td><font size="1">{{$waybill->destinations->office_name}}</font></td>
            </tr>
            @endforeach
        </table>
        <br>
        <br>
        <div><font size="1">Printed By: <b>{{Auth::user()->name}} {{date('H:i:s D d/m/Y')}}</b></font></div>
        <br>
        <div><font size="1">Loading By: ...............................................................SIGN:...........................................</font></div>
        <br>
        <div><font size="1">Offloading By: ...........................................................SIGN:...........................................</font></div>

    </body>
</html>