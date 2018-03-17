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
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mvpready-admin.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="layout-fixed">
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
                <ul class="nav navbar-nav navbar-right">
                    <li class="divider"></li>
                    <li>
                        <a id="logout" href="{{ route('logout') }}"
                           onclick="event.preventDefault();">
                           </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper">
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        <span class="logo">
                            Softera Solutions
                        </span>
                    </div>
                    <button class="navbar-toggle pull-right" type="button" data-toggle="collapse"
                            data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-cog"></i>
                    </button>
                </div><!-- /.navbar-header -->
                <div class="navbar-collapse collapse">
                    <div class="welcome-user col-md-offset-1 col-md-3">Hi, {{Auth::user()->name()}}!</div>
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

                    <a href="/" class="">
                        <i class="fa fa-file-text-o"></i>
                        My Profile
                    </a>

                    <a href="{{route('projects')}}" class="">
                        <i class="fa fa-file-text-o"></i>
                        Projects
                    </a>

                    <a href="{{route('timesheet')}}">
                        <i class="fa fa-file-text-o"></i>
                        Timesheets
                    </a>


                    {{--<li class="dropdown has_sub">
                        <a href="#" class="">
                            <i class="fa fa-file-text-o"></i>
                            Workload
                            <span class="pull-right">
                <i class="fa fa-angle-right"></i>
              </span>
                        </a>

                        <ul class="list-unstyled timesheet-menu">
                            <li>
                                <a href="{{route('timesheet')}}">
                                    Daily Timesheet
                                    <small><i class="fa fa-external-link pull-right text-secondary"
                                              style="position: relative; top: 3px;"></i></small>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('timesheet')}}">
                                    Weekly Timesheet
                                    <small><i class="fa fa-external-link pull-right text-secondary"
                                              style="position: relative; top: 3px;"></i></small>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('timesheet')}}">
                                    Yearly Timesheet
                                    <small><i class="fa fa-external-link pull-right text-secondary"
                                              style="position: relative; top: 3px;"></i></small>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('timesheet')}}">
                                    Timesheet
                                    <small><i class="fa fa-external-link pull-right text-secondary"
                                              style="position: relative; top: 3px;"></i></small>
                                </a>
                            </li>
                        </ul>
                    </li>--}}
                </ul>
            </div>
                <div class="clearfix"></div>
            </div><!-- /.sidebar-inner -->
        </div> <!-- /.side-menu -->
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/mvpready-admin.js') }}"></script>
    <script src="{{ asset('js/mvpready-core.js') }}"></script>
    <script src="{{ asset('js/mvpready-helpers.js') }}"></script>
    <script src="{{ asset('js/custom-scripts.js') }}"></script>
</body>
</html>
