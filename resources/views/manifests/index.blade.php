@extends('layouts.app')

@section('content')


<h2 class="page-header">{{ ucfirst('manifests') }}</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        List of {{ ucfirst('manifests') }}
    </div>

    <div class="panel-body">
        <div class="">
            <table class="table table-striped" id="thegrid">
              <thead>
                <tr>
                                        <th>Id</th>
                                        <th>Loading Manifest</th>
                                        <th>Date</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Created By</th>                                        
                                        <th>Loaded</th>
                                        <th>Status</th>
                                        <th style="width:50px"></th>
                    <th style="width:50px"></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
        @can('create manifest')
        <a href="{{url('manifests/create')}}" class="btn btn-primary" role="button">Create loading manifest</a>
        @endcan
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
                "ajax": "{{url('manifests/grid')}}",
                "columnDefs": [
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/manifests') }}/'+row[0]+'">'+data+'</a>';
                        },
                        "targets": 1
                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a class="btn btn-info btn-xs" href="{{ url('/waybill_manifests') }}/'+row[0]+'">'+data+' items</a>';
                            //return '';
                        },
                        "targets": 6
                    },
                    {
                        "render": function ( data, type, row ) {
                            @can('create waybill')
                                return '<a href="{{ url('/manifests') }}/'+row[0]+'/edit" class="btn btn-default">Update</a>';
                            @else
                                return '';
                            @endcan
                        },
                        "targets": 8                   },
                    {
                        "render": function ( data, type, row ) {
                            //return '<a href="#" onclick="return doDelete('+row[0]+')" class="btn btn-danger">Delete</a>';
                            return '';
                        },
                        "targets": 8+1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: '{{ url('/manifests') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection