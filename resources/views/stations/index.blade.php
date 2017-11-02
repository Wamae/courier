@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        List of {{ $title }}
    </div>

    <div class="panel-body">
        <div class="">
            <table class="table table-condensed table-striped info-print" id="thegrid">
                <thead>
                    <tr class="holder_header">  
                        <th>Id</th>
                        <th>Office Name</th>
                        <th>Office Code</th>
                        <th>Telephone Number</th>
                        <th>Currency</th>
                        <th>Main Office</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Updated At</th>
                        <th>Updated By</th>
                        <th style="width:50px"></th>
                        <th style="width:50px"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <a href="{{url('stations/create')}}" class="btn btn-small btn-default add-new-form" role="button"><i class="icon-plus-sign"></i> Add {{$title}}</a>
    </div>
</div>




@endsection



@section('scripts')
<script type="text/javascript">
    var theGrid = null;
    $(document).ready(function(){
    theGrid = $('#thegrid').DataTable({
    "processing": true,
            "serverSide": true,
            "ordering": true,
            "responsive": true,
            "ajax": "{{url('stations/grid')}}",
            "columnDefs": [
            {
            "render": function (data, type, row) {
            return '<a href="{{ url('stations') }}/' + row[0] + '">' + data + '</a>';
            },
                    "targets": 1
            },
            {
            "render": function (data, type, row) {
            return '<a href="{{ url('stations') }}/' + row[0] + '/edit" class="btn btn-default">Update</a>';
            },
                    "targets": 11                    },
            {
            "render": function (data, type, row) {
            //return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger">Delete</a>';
            return '';
            },
                    "targets": 11 + 1
            },
            {
            "render": function (data, type, row) {
            if (row[6] === {{ACTIVE}}){
                return 'ACTIVE';
            } else if (row[6] === {{INACTIVE}}){
                return 'INACTIVE';
            }
            },
                    "targets": 6
            },
            ]
    });
    });
    function doDelete(id) {
    if (confirm('You really want to delete this record?')) {
    $.ajax({ url: '{{ url('stations') }}/' + id, type: 'DELETE'}).success(function() {
    theGrid.ajax.reload();
    });
    }
    return false;
    }
</script>
@endsection