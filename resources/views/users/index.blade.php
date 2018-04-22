{{-- \resources\views\users\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Users')

@section('content')

<div class="col-lg-10 col-lg-offset-1 row">
    <div class="col-lg-8">
        <h3><i class="fa fa-users fa-1x"></i> User Administration</h3>
    </div>
    <div class="col-lg-4">
        <a href="{{ route('roles.index') }}" class="btn btn-info">Roles</a>
        <a href="{{ route('permissions.index') }}" class="btn btn-primary">Permissions</a>
        <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
    </div>

    <hr>
    <div class="">
        <table id="thegrid" class="table table-bordered table-striped table-condensed">

            <thead>
            <tr>
                <th>Name</th>
                <th>Station</th>
                <th>Email</th>
                <th>Date/Time Added</th>
                <th>User Roles</th>
                <th>Operations</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($users as $user)
            <tr>

                <td>{{ $user->name }}</td>
                <td>{{ $user->stations["office_name"] }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>
                {{-- Retrieve array of roles associated to a user and convert to string --}}
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-xs pull-left"
                       style="margin-right: 3px;">Edit</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}

                </td>
            </tr>
            @endforeach
            </tbody>

        </table>
    </div>


</div>
@endsection
@section('scripts')
<script type="text/javascript">
    var theGrid = null;
    $(document).ready(function () {
        theGrid = $('#thegrid').DataTable({
            "processing": false,
            "serverSide": false,
            "ordering": true,
            "responsive": false
        });
    });

</script>
@endsection