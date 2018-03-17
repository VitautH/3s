<?php use \App\Http\Controllers\AdminTimesheetController; ?>
@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="portlet portlet-boxed">
                    <div class="portlet-body">
                        <br class="xs-20">
                        <div class="portlet-body1">
                            <div class="row">
                                <div class="col-lg-12 timesheet_table">
                                    <h2> Timesheets Reports</h2>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Timesheet Period</th>
                                            <th>Workload</th>
                                            <th>Time Worked</th>
                                            <th>Approved time off</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($timesheetPeriods as $timesheetPeriod)
                                            <tr>
                                                <td class="timesheet_period"><a
                                                            href="/admin/user/{{$timesheetPeriod['employee_id']}}">
                                                        {{$timesheetPeriod['employee_first_name'].'
                                                        '.$timesheetPeriod['employee_last_name']}}</a>
                                                </td>
                                                <td class="timesheet_period">{{$timesheetPeriod['period']}}</td>
                                                <td class="timesheet_workload">{{$timesheetPeriod['workload']}}</td>
                                                <td class="timesheet_duration">{{$timesheetPeriod['duration']}}</td>
                                                <td class="timesheet_approved">{{$timesheetPeriod['approved']}}</td>
                                                <td class="timesheet_balance">{{$timesheetPeriod['balance']}}</td>
                                                @if($timesheetPeriod['status']== AdminTimesheetController::APPROVE)
                                                    <td class="timesheet_status">Approved by Manager</td>
                                                @else
                                                    <td class="timesheet_status">
                                        <button class="submit_timesheet btn btn-success"
                                                data-id_timesheet="{{$timesheetPeriod['id']}}">Approve</button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- /.tab-pane -->
                    </div> <!-- /.tab-content -->
                </div>
            </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
    </div> <!-- /.container -->
@endsection