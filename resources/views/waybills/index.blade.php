@extends('layouts.app')

@section('content')


<h2 class="page-header">{{ ucfirst('waybills') }}</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        List of {{ ucfirst('waybills') }}
    </div>

    <div class="panel-body">
        <div class="">
            <table class="table table-striped" id="thegrid">
              <thead>
                <tr>
                                        <th>Id</th>
                                        <th>Waybill</th>
                                        <th>Date</th>
                                        <th>Consignor</th>
                                        <th>Consignee</th>                                        
                                        <th>Package</th>
                                        <th>Quantity</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Weight</th>
                                        <th>Status</th>
                                        <th style="width:50px"></th>
                    <th style="width:50px"></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
        <a href="{{url('waybills/create')}}" class="btn btn-primary" role="button">Add waybill</a>
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
                "ajax": "{{url('waybills/grid')}}",
                "columnDefs": [
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/waybills') }}/'+row[0]+'">'+data+'</a>';
                        },
                        "targets": 1
                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/waybills') }}/'+row[0]+'/edit" class="btn btn-default">Update</a>';
                        },
                        "targets": 10                    },
                    {
                        "render": function ( data, type, row ) {
                            //return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger">Delete</a>';
                            return '';
                        },
                        "targets": 10+1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/waybills') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection