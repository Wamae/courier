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
                "columns": [
                    { "data": "id","name": "a.id"},
                    { "data": "loading_manifest","name": "a.manifest_no","targets": 1,"render": function ( data, type, row ) {
                            return "<a href='{{ url('manifests') }}/'"+row[0]+"'>"+data+"</a>";
                        }
                    },
                    { "data": "created_at","name": "a.created_at"},
                    { "data": "origin","name": "cs.office_name"},
                    { "data": "destination","name": "cs2.office_name"},
                    { "data": "created_by","name": "u.name"},
                    { "data": "loaded","render": function ( data, type, row ) {
                            return `<a class="btn btn-info btn-xs" href="{{ url('waybill_manifests') }}/${row['id']}"> ${data} items</a>`;
                        },
                        "targets": 6, "searchable": false},
                    { "data": "status","targets": 7,"name": "ms.status"},
                    { "data": "X",
                        "targets": 8 ,"render": function ( data, type, row ) {
                                    return `<a href="{{ url('manifests') }}/print_manifest/pdf?id=${row['id']} " class="btn btn-status btn-xs btn-success"><span class="glyphicon glyphicon-print"></span> Print</a>`;
                        }, "searchable": false
                    },
                    { "data": "Y", "searchable": false}
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax({ url: "{{ url('manifests') }}/" + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection