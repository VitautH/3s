@extends('layouts.admin')
@section('content')
    <link href="{{ asset('css/team_users.css') }}" rel="stylesheet">
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <h2 class="title-page">All Employees</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-1">
                        <div class="block table-users table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Salary</th>
                                    <th>Project</th>
                                    <th>Hourly Rate</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->id }}</td>
                                        <td>
                                            <a href="/admin/user/{{$employee->id}}"> {{ $employee->first_name.' '. $employee->last_name }}</a>
                                        </td>
                                        <td>{{ $employee->title }}</td>
                                        <td>{{ $employee->salary }} BYN</td>
                                        <td>
                                            @foreach ($employee->project_name as $i=>$projectName)

                                                <a href="/admin/projects"> {{$projectName}} </a>
                                                @if($i < count($employee->project_name)-1)
                                                    <hr>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($employee->project_rate as $i=>$projectRate)
                                                {{$projectRate}} $
                                                @if($i < count($employee->project_rate)-1)
                                                    <hr>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.container -->
    </div> <!-- .content -->
@endsection