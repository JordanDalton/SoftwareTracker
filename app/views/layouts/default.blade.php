<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoftwareTracker</title>

    <!-- Bootstrap -->
    <link href="{{ asset('components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/css/images/logo.png') }}"/> <span class="fa fa-home"></span></a>
        </div>
        @if( Auth::check() )
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="{{ Request::is('departments*') ? 'active' : '' }}"><a href="{{ route('departments.index') }}"><i class="fa fa-users"></i> Departments</a></li>
              <li class="{{ Request::is('publisher*')   ? 'active' : '' }}"><a href="{{ route('publishers.index') }}"><i class="fa fa-building-o"></i> Publishers</a></li>
              <li class="{{ Request::is('programs*')    ? 'active' : '' }}"><a href="{{ route('programs.index') }}"><i class="fa fa-dot-circle-o"></i> Programs</a></li>
              <li class="{{ Request::is('machines*')    ? 'active' : '' }}"><a href="{{ route('machines.index') }}"><i class="fa fa-desktop"></i> Machines</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="{{ route('logout') }} "><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        @endif
      </div>
    </div>

    @yield('content')

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Include all application specific javascript. -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
  </body>
</html>