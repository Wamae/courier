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
                                        <th>Payment Mode</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Updated By</th>
                                        <th>Updated At</th>
                                        <th style="width:50px"></th>
                    <th style="width:50px"></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
        
        <a href="{{url('payment_modes/create')}}" class="btn btn-small btn-default add-new-form" role="button"><i class="icon-plus-sign"></i> Add {{$title}}</a>
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
                "ajax": "{{url('payment_modes/grid')}}",
                "columnDefs": [
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/payment_modes') }}/'+row[0]+'">'+data+'</a>';
                        },
                        "targets": 1
                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/payment_modes') }}/'+row[0]+'/edit" class="btn btn-default">Update</a>';
                        },
                        "targets": 7                    },
                    {
                        "render": function ( data, type, row ) {
                            //return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger">Delete</a>';
                            return '';
                        },
                        "targets": 7+1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/payment_modes') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection