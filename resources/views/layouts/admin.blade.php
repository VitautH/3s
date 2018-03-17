<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Softera Solutions') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mvpready-admin.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Jquery -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js') }}"></script>
    <script src="{{ asset('js/admin_timesheets.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
</head>
<body class="layout-fixed  ">
<div id="wrapper">
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <div class="navbar-brand">
                    <a href="/" class="logo" style="color: white; ">
                        Softera Solutions
                    </a>
                </div>
                <button class="navbar-toggle pull-right" type="button" data-toggle="collapse"
                        data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-cog"></i>
                </button>
            </div><!-- /.navbar-header -->
            <div class="navbar-collapse collapse">
                <div class="welcome-admin col-md-offset-1 col-md-3">Hi, Admin!</div>
                <ul class="nav navbar-nav navbar-right">
                    <li class="divider"></li>
                    <li>
                        <a id="logout" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
        </div> <!--/.container -->
    </div> <!--/.navbar -->
    <div class="sidebar">
        <div class="sidebar-bg"></div><!-- /.sidebar-bg -->
        <div class="sidebar-trigger sidebar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <i class="fa fa-bars"></i>
        </div><!-- /.sidebar-trigger -->
        <div class="sidebar-inner sidebar-collapse collapse">
            <ul class="sidebar-menu">
                <li class="menu-title sidebar-header">
                    <span>Admin menu</span>
                </li>
                <li>
                    <a href="/admin">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Home Page
                    </a>
                </li>
                <li>
                    <a href="/admin/users">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        Profiles
                    </a>
                </li>
                <li>
                    <a href="/admin/projects">
                        <i class="fa fa-tasks" aria-hidden="true"></i>
                        Projects
                    </a>
                </li>
                <li>
                    <a href="/admin/timesheets">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        Timesheets
                    </a>
                </li>
                <li>
                    <a href="/admin/report">
                        <i class="fa fa-trello" aria-hidden="true"></i>
                        Timesheets Reports
                    </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div><!-- /.sidebar-inner -->
    </div> <!-- /.side-menu -->
    @yield('content')
</div>
<!-- Scripts -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/mvpready-admin.js') }}"></script>
<script src="{{ asset('js/mvpready-core.js') }}"></script>
<script src="{{ asset('js/mvpready-helpers.js') }}"></script>
{{--<script src="{{ asset('js/custom-scripts.js') }}"></script>--}}
</body>
</html>
