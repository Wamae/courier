{{-- \resources\views\users\edit.blade.php --}}

@extends('layouts.app')

@section('title', '| Edit User')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>

    <h3><i class='fa fa-user-plus'></i> Edit {{$user->name}}</h3>
    <hr>

    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PATCH')) }}{{-- Form model
    binding to automatically populate our fields with user data --}}

    @include('errors.errors')

    <div class="row">
            <div class="form-group">
                {{ Form::label('station', 'Station') }}<br>
                {{Form::select('station', $stations,null, array('class' => 'form-control', 'required'))}}
            </div>

            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('email', 'Email') }}
                {{ Form::email('email', null, array('class' => 'form-control')) }}
            </div>

            <h5><b>Give Role</b></h5>

            <div class='form-group'>
                @foreach ($roles as $role)
                {{ Form::checkbox('roles[]', $role->id, $user->roles ) }}
                {{ Form::label($role->name, ucfirst($role->name)) }}<br>

                @endforeach
            </div>

            <!--<div class="form-group">
                {{ Form::label('password', 'Password') }}<br>
                {{ Form::password('password', array('class' => 'form-control')) }}

            </div>

            <div class="form-group">
                {{ Form::label('password', 'Confirm Password') }}<br>
                {{ Form::password('password_confirmation', array('class' => 'form-control')) }}

            </div>-->

            {{ Form::submit('Update', array('class' => 'btn btn-primary pull-right')) }}
    </div>
    {{ Form::close() }}

</div>

@endsection