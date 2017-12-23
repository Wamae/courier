<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">

        <title>Tahmeed Courier System</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- 
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
        -->

        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.0.0/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker-standalone.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.css')}}">
        <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
        <link rel="stylesheet" href="{{asset('css/jquery.auto-complete.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/font_awesome/fa-svg-with-js.css')}}">

        <meta name="csrf-token" content="{{ csrf_token() }}">



        <!-- Custom styles for this template 
        <link href="css/dashboard.css" rel="stylesheet">
        -->


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


    </head>

    <body>

        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('', 'Tahmeed Courier System') }}
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                            <ul class="nav navbar-nav">                                
                         &nbsp                        ;
                 </ul>

<!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                             <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        @else

   <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Reports <span class="caret"></span>
                 </a>

                 <ul class="dropdown-menu dropdown-menu-large" role="menu">
                     <li>
                         <a href="{{url('station_reports')}}"><span class="glyphicon glyphicon-stats"></span> My Station Reports</a>
                     </li>
                     <li>
                         <a href="{{url('user_reports')}}"><span class="glyphicon glyphicon-user"></span>User Reports</a>
                     </li>
                     <li>
                         <a href="{{url('client_reports')}}"><span class="glyphicon glyphicon-usd"></span> Accounts Reports</a>
                     </li>
                     <li>
                         <a href="{{url('invoices')}}"><span class="glyphicon glyphicon-calendar"></span> Account Invoices</a>
                     </li>
                 </ul>
                 </li>

                 <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                         Menu <span class="caret"></span>
                     </a>

                     <ul class="dropdown-menu" role="menu">
                         @role('admin')
                         <li>
                             <a href="{{url('stations')}}"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Collection Stations</a>
                         </li>
                         <li>
                             <a href="{{url('users')}}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Courier System Users</a>
                         </li>
                         <li>
                             <a href="{{url('package_types')}}"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Package Type Setup</a>
                         </li>
                         <li>
                             <a href="{{url('clients')}}"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span> Registered Clients</a>
                         </li>
                         <li>
                             <a href="{{url('manifests')}}"><i class="icon-truck"></i><span class="glyphicon glyphicon-compressed"></span> Loading Manifest</a>
                         </li>
                         <li>
                             <a href="{{url('main_offices')}}">Main Offices</a>
                         </li>
                         <li>
                             <a href="{{url('payment_modes')}}">Payment Modes</a>
                         </li>
                         <li>
                             <a href="{{url('roles')}}">Roles</a>
                         </li>
                         <li>
                             <a href="{{url('permissions')}}">Permissions</a>
                         </li>

                         @endrole
                         @can('view waybill')
                         <li>
                             <a href="{{url('waybills')}}"><i class="icon-truck"></i><span class="glyphicon glyphicon-th"></span> Waybill Entry</a>
                         </li>
                         @endcan
                     </ul>
                 </li>

                 <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                         {{ Auth::user()->name }} <span class="caret"></span>
                     </a>

                     <ul class="dropdown-menu" role="menu">
                         <li>
                             <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                 <span class="glyphicon glyphicon-log-out"></span> Exit System
                             </a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 {{ csrf_field() }}
                             </form>
                         </li>
                     </ul>
                 </li>
                 @endif
                 </ul>
                 </div>
                 </div>
                 </nav>

                 <div class="container-fluid">
                     <div class="row">
                         <div class="col-lg-12">
                             @yield('content')
                         </div>
                     </div>
                 </div>

                 <!-- Bootstrap core JavaScript
                 ================================================== -->
                 <!-- Placed at the end of the document so the pages load faster -->
                 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

                 <script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
                 <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
                 <script src="https://cdn.datatables.net/responsive/2.0.0/js/dataTables.responsive.min.js"></script>

                 <script src="{{asset('js/moment.js')}}"></script>
                 <script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
                 <script src="{{asset('js/jquery-ui.js')}}"></script>
                 <script src="{{asset('js/range_dates.js')}}"></script>
                 <script src="https://unpkg.com/sweetalert2@7.0.9/dist/sweetalert2.all.js"></script>
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
                 <script src="{{asset('js/jquery.auto-complete.min.js')}}"></script>
                 <script src="{{asset('js/font_awesome/fontawesome-all.min.js')}}"></script>

                 <script>
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                 </script>    

                 @yield('scripts')
                 <footer>
                 @if (Auth::guest())
                 @else
                 <div class="container-fluid bg-info clearfix navbar-fixed-bottom" style="position: relative; bottom: 0px; z-index: 100">
                     <ul class="nav navbar-nav">
                         <li><a href="http://imediaafrica.com" target="_blank"><i class="icon-asterisk"></i> COPYRIGHT {{date("Y")}} </a></li>
                         <li><a><i class="fa fa-certificate"></i> VERSION 1.0</a></li>
                         <li><a><i class="fa fa-briefcase"></i> </a></li><!--//TODO:Licensed to-->
                         <li><a><i class="fa fa-user"></i> USER ONLINE: {{Auth::user()->name}}</a></li>
                         <li><a><i class="fa fa-map-marker"></i> STATION: {{Auth::user()->stations->office_name}}</a></li>
                     </ul>
                 </div>
                 @endif
                 </footer>
                 
                 </body>
                 </html>
