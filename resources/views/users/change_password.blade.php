@extends('layouts.app')

@section('content')
<div class="col-sm-3"></div>
<div class="col-sm-6" align="center">
    <div class="panel panel-default">
        <div class="panel-heading">
            UPDATE PASSWORD
        </div>

        <div class="panel-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ url('/change_password') }}" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="current_password" class="col-sm-3 control-label">Current Password</label>
                    <div class="col-sm-6">
                        <input type="password" name="current_password" required id="current_password" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_password" class="col-sm-3 control-label">New Password</label>
                    <div class="col-sm-6">
                        <input type="password" name="password" required id="password" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation " class="col-sm-3 control-label">Confirm Password</label>
                    <div class="col-sm-6">
                        <input type="password" name="password_confirmation" required id="password-confirmation " class="form-control" value="">
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-primary">CHANGE PASSWORD
                    </button> 
                </div>
            </form>

        </div>
    </div>

</div>




@endsection