@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="team-profiles-row row">
                    <div class="block  col-md-3 col-md-offset-1">
                        <ul class="team-profiles-menu">
                            <li><i class="fa fa-users" aria-hidden="true"></i><a href="/admin/users"> All Employees
                                    - {{$employee_count}}</a></li>
                            <li><i class="fa fa-tasks" aria-hidden="true"></i> <a href="/admin/projects">All
                                    Projects- {{$project_count}}</a></li>
                            @if($notification_count==0)
                                <li><i class="fa fa-bell" aria-hidden="true"></i> <a href="#">Notifications
                                        - 0 </a></li>
                            @else
                                <div class="dropdown">
                                    <li class="dropdown-toggle" type="button" data-toggle="dropdown"><i
                                                class="fa fa-bell" aria-hidden="true"></i> <a href="#">Notifications
                                            - {{$notification_count}}</a><span class="caret"></span></li>
                                    <ul class="dropdown-menu">
                                        @foreach($notification_employees as $i=>$notification_employee)
                                            <li>
                                                <a href="/admin/statistic/employee/{{$notification_employee->id}}">{{$notification_employee->employee_FirstName.' '.$notification_employee->employee_LastName}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </ul>
                    </div>
                    <div class="block col-md-5 col-md-offset-1">
                        <div id="datepicker" data-date="{{ date('m-d-Y') }}"></div>
                        <input type="hidden" id="my_hidden_input">
                    </div>
                    <script type="text/javascript">
                        $('#datepicker').datepicker();
                        $('#datepicker').on('changeDate', function () {
                            $('#my_hidden_input').val(
                                $('#datepicker').datepicker('getFormattedDate')
                            );
                        });
                    </script>
                </div>
            </div>
        </div>
    </div> <!-- /.content-page -->
@endsection
