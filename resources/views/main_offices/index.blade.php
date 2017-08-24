@extends('crudgenerator::layouts.master')

@section('content')


<h2 class="page-header">{{ ucfirst('main offices') }}</h2>

<div class="panel panel-default">
    <div class="panel-heading">
        List of {{ ucfirst('main offices') }}
    </div>

    <div class="panel-body">
        <div class="">
            <table class="table table-striped" id="thegrid">
              <thead>
                <tr>
                                        <th>Id</th>
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
        <a href="{{url('main_offices/create')}}" class="btn btn-primary" role="button">Add main office</a>
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
                "ajax": "{{url('main_offices/grid')}}",
                "columnDefs": [
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/main_offices') }}/'+row[0]+'">'+data+'</a>';
                        },
                        "targets": 1
                    },
                    {
                        "render": function ( data, type, row ) {
                            return '<a href="{{ url('/main_offices') }}/'+row[0]+'/edit" class="btn btn-default">Update</a>';
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
               $.ajax({ url: '{{ url('/main_offices') }}/' + id, type: 'DELETE'}).success(function() {
                theGrid.ajax.reload();
               });
            }
            return false;
        }
    </script>
@endsection