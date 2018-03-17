<?php use \App\Http\Controllers\AdminTimesheetController; ?>
@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="portlet portlet-boxed">
                    <div class="portlet-body">

                        <div class="row">
                            <div class="col-lg-12 statistics">
                                <h4>TIMESHEET DETAILS</h4>

                                <p>Timesheet period: <span class="timesheet_period"><b>{{$from.' / '.$to}}</b></span></p>
                                <p>Status: <span class="timesheet_status">Submitted by <b>{{$employee->first_name. ' '.$employee->last_name}}</b></span></p>
                                    <span class="submit_timesheet_wrap">
                                        <button class="submit_timesheet btn btn-success"  data-id_timesheet="{{$notification_id}}">Approve</button>
                                    </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 statistics">
                                <h4>Total Time Worked</h4>
                                <table class="table total_hours table-striped">
                                    <thead>
                                    <tr>
                                        <th>Hours worked</th>
                                        <th>Approved time off</th>
                                        <th>Total Paid Hours</th>
                                        <th>Workload (hrs)</th>
                                        <th>Break Time (hrs)</th>
                                        <th>Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="timesheet_duration">{{toHrsView($time['total'])}}</td>
                                        <td class="timesheet_approved">{{toHrsView($time['approved'])}}</td>
                                        <td class="">{{toHrsView($time['billable'])}}</td>
                                        <td class="timesheet_workload">{{$time['workload']}}</td>
                                        <td class=""></td>
                                        <td class="timesheet_balance">{{toHrsView($time['balance'])}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 statistics">
                                <h4>Tasks</h4>
                                <table class="table total_hours table-striped">
                                    <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Billable Hours</th>
                                        <th>Non-billable Hours</th>
                                        <th>Hours Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data_tasks as $key => $task)
                                        <tr>
                                            <td class="">{{$key}}</td>
                                            <td class=""> {{toHrsView($task['billable'])}}</td>
                                            <td class="">{{toHrsView($task['unbillable'])}}</td>
                                            <td class="">{{toHrsView($task['total'])}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 statistics">
                                <h4>Projects</h4>
                                <table class="table total_hours table-striped">
                                    <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Billable Hours</th>
                                        <th>Non-billable Hours</th>
                                        <th>Hours Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data_projects as $key => $project)
                                        <tr>
                                            <td class="">{{$key}}</td>
                                            <td class=""> {{toHrsView($project['billable'])}}</td>
                                            <td class="">{{toHrsView($project['unbillable'])}}</td>
                                            <td class="">{{toHrsView($project['total'])}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 statistics">
                                <h4>Hours by week</h4>
                                <table class="table total_hours table-striped ">
                                    <tbody>
                                    @foreach($weeksTime as $key => $range)
                                        <tr><td class=""> {{$key}}</td><td class=""> Total time worked: {{toHrsView($range)}}</td></tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 statistics">
                                <h4>Daily timesheets</h4>
                                <table class="table total_hours table-striped">
                                    <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Project</th>
                                        <th>Time worked</th>
                                        <th>Time Off</th>
                                        <th>Note</th>
                                        <th>Duration (h)</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dailyTimesheet as $key => $timesheet)
                                        <tr>
                                        <tr data-date="{{$key}}" >
                                            <td class="statistic_date" >{{fromDateView($key)}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @if(is_array($timesheet))
                                            @foreach($timesheet as  $key2 => $item)
                                                @if($key2 === 'sum')
                                                    @continue
                                                @endif
                                                <tr>
                                                    <td class="statistic_task">{{$item['task']}}</td>
                                                    <td>{{$item['project']}}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{$item['note']}}</td>
                                                    <td>{{toHrsView($item['duration'])}}</td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        @if(is_array($timesheet))
                                            <tr>
                                                <td class="statistic_total">Total Time Worked</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{toHrsView($timesheet['sum'])}}</td>
                                                <td>{{toHrsView($timesheet['sum'] - 480)}}</td>
                                            </tr>
                                            @endif
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection