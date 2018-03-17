@extends('layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="portlet portlet-boxed">
                    <div class="portlet-body">
                        <br class="xs-20">
                        <div class="portlet-body1">

                            <ul id="myTab1" class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a href="#daily" data-toggle="tab" aria-expanded="true">Daily</a>
                                </li>
                                <li class="">
                                    <a href="#weekly" data-toggle="tab" aria-expanded="true">Weekly</a>
                                </li>
                                <li class="">
                                    <a href="#yearly" data-toggle="tab" aria-expanded="true">Yearly</a>
                                </li>
                                <li class="">
                                    <a href="#timesheet" data-toggle="tab" aria-expanded="true">Timesheet</a>
                                </li>
                            </ul>

                            <div id="myTab1Content" class="tab-content ">

                                <div class="tab-pane fade active in" id="daily">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row current_date_wrapper">
                                                <div class="col-md-12 current_date">
                                                    <span class="current_day"></span>
                                                    <span class="current_month"></span>
                                                    <span class="current_year"></span>
                                                    <span style="display: none" class="current_date_hidden"></span>
                                                </div>
                                            </div>
                                            <div class="calend"></div>
                                        </div>
                                        <div class="col-md-4 col-lg-3 central-part">
                                            <form id="daily_timesheet_form">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <p>Duration:</p>
                                                    <input type="text" class="form-control" name="time" data-type="hrs"
                                                           id="billable_time_input" maxlength="5" value="0:00"
                                                           placeholder="0">
                                                    <span class="time_type">
                                                                    <span id="hrs_type"
                                                                          class="active_time_type">HRS</span>
                                                                    <span id="min_type">MIN</span>
                                                                </span>

                                                    <span id="error_msg"></span>
                                                </div>
                                                <div class="row">
                                                    <p>Task:</p>
                                                    <select class="form-control task_select" name="task">
                                                        <option value=""></option>
                                                        @foreach($tasks as $task)
                                                            <option data-name="{{$task->name}}"
                                                                    value="{{$task->id}}">{{$task->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>Client:</p>
                                                    <select class="form-control task_select" name="client">
                                                        <option value=""></option>
                                                        @foreach($clients as $client)
                                                            <option data-name="{{$client->company_name}}"
                                                                    value="{{$client->id}}">{{$client->company_name}}</option>
                                                        @endforeach


                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>Project:</p>
                                                    <select class="form-control task_select" name="project">
                                                        <option value=""></option>
                                                        @foreach($projects as $project)
                                                            <option value="{{$project->id}}">{{$project->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row billable_buttons_row">

                                                    <div class="col-md-4">
                                                        <button type="button" id="billable_check"
                                                                class="btn btn-secondary billable_buttons ">
                                                            Billable
                                                        </button>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button id="save_daily_time" type="submit"
                                                                class="btn btn-success billable_buttons">
                                                            Save
                                                        </button>
                                                    </div>
                                                    <div class="col-md-4 ">
                                                        <button class="btn btn-danger billable_buttons"
                                                                type="reset">
                                                            Cancel
                                                        </button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-3 col-lg-offset-1 col-md-4">
                                            <div class="form-group">
                                                <label for="billable_textarea" class="notBold">Note:</label>
                                                <textarea class="form-control" rows="7"
                                                          id="billable_textarea"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="select_all_wrapper">
                                                <input type="checkbox" id="select_all">
                                                <span id="delete_all">Delete</span>
                                            </div>

                                            <div class="daily_timesheet_panel">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Time</th>
                                                        <th>Task</th>
                                                        <th>Client</th>
                                                        <th>Project name</th>
                                                        <th>Note</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="table_daily_timesheet">

                                                    @foreach($dailyTimesheet as $item)
                                                        <tr data-id="{{$item->id}}">
                                                            <td class="first_cell_daily"><input
                                                                        class="checkbox_daily_item"
                                                                        data-id="{{$item->id}}"
                                                                        type="checkbox"></td>
                                                            <td class="project_time">{{toHrsView($item->duration)}}</td>
                                                            <td class="project_task"
                                                                data-task_id="{{$item->task_id}}">{{$item->task}}</td>
                                                            <td class="project_client"
                                                                data-client_id="{{$item->client_id}}">{{$item->client}}</td>
                                                            <td class="project_project"
                                                                data-project_id="{{$item->project_id}}">{{$item->project}}</td>
                                                            <td class="text_note">{{$item->note}}</td>
                                                            <td><a data-id="{{$item->id}}" id="edit_daily_timesheet"
                                                                   href="javascript:void(0)">Edit</a><a
                                                                        href="javascript:void(0)"><i
                                                                            class="fa fa-usd @if($item->billable>0) billable_icon @endif"
                                                                            data-id="{{$item->id}}"
                                                                            aria-hidden="true"></i></a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12 daily_timesheet_total-time">
                                                <span> 0:00</span></div>
                                        </div>
                                    </div>
                                </div> <!-- /.tab-pane -->

                                <div class="tab-pane fade " id="weekly">
                                    <div class="row">
                                        <div class="col-lg-8 col-lg-offset-2 weekly_timesheet_weeks">
                                            <div class="col-lg-12 ">
                                                <table class="table table-condensed">
                                                    <tr class="week_range_list">
                                                        @foreach($lastWeeks as $week)
                                                            <td><a href="javascript:void(0)"
                                                                   data-date="{{$week}}"
                                                                   class="week_range">{{$week}}</a></td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 weekly_timesheet_projects">
                                            <table class="table table-striped">
                                                <thead>
                                                <th>Client/Project/Task</th>
                                                @foreach($weeklyTimesheet as $key => $item)
                                                    @foreach($item as $date => $value)
                                                        <th class="date_th">{{strftime("%A, %m/%d", strtotime($date))}}</th>
                                                    @endforeach
                                                    @break
                                                @endforeach
                                                <th>Sum</th>
                                                </thead>
                                                <tbody>
                                                @foreach($weeklyTimesheet as $key => $item)
                                                    <tr class="projects_weekly_{{$key}}">
                                                        <td class="weekly_project_name">{{$key}}</td>
                                                        @foreach($item as $date => $value)
                                                            <td class="weekly_duration_{{$key}}"
                                                                data-date="{{strftime("%m/%d", strtotime($date))}}_day"
                                                                @if(!$value) style="color: #ccc" @endif>  @if($value){{$value}} @else
                                                                    0:00 @endif  </td>
                                                        @endforeach
                                                        <td class="weekly_sum"></td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td>Sum:</td>
                                                    @foreach($weeklyTimesheet as $key => $item)
                                                        @foreach($item as $date => $value)
                                                            <td class="day_sum"
                                                                data-date="sum_{{strftime("%m/%d", strtotime($date))}}"></td>
                                                        @endforeach
                                                        @break
                                                    @endforeach
                                                    <td id="total_sum"></td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- /.tab-pane -->

                                <div class="tab-pane fade" id="yearly">
                                    <div class="row">
                                        <div class="col-lg-12 yearly_timesheet_title">
                                            <p>Employee Name: {{Auth::user()->name()}}</p>
                                            <p>Year: {{date("Y")}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 yearly_timesheet_table">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Current Year</th>
                                                    <th>Rollover from prior year</th>
                                                    <th>Used</th>
                                                    <th>Balance</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($yearlyTimesheet as $item)
                                                    <tr>
                                                        <td>{{$item->name}}</td>
                                                        <td>{{$item->count_days}} days</td>
                                                        <td>@if(isset($item->rollover)){{$item->rollover}} @else
                                                                0 @endif days
                                                        </td>
                                                        <td>@if($item->sum_used){{$item->sum_used}} @else 0 @endif days</td>
                                                        <td>{{$item->count_days - $item->sum_used}} days</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- /.tab-pane -->

                                <div class="tab-pane fade" id="timesheet">
                                    <div class="row">
                                        <div class="col-lg-12 timesheet_single">
                                            <div class="col-lg-3">
                                                <select class="form-control">
                                                    {{--<option>Open</option>--}}
                                                    {{--<option>Submited By Employee</option>--}}
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="input-daterange input-group"
                                                     id="datepicker_range_timesheet">
                                                    <input type="text" class="form-control"
                                                           name="start"/>
                                                    <span class="input-group-addon">to</span>
                                                    <input type="text" class="form-control"
                                                           name="end"/>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 timesheet_table">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
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
                                                <tr>
                                                    <td class="timesheet_period">{{$timesheetPeriod['period']}}</td>
                                                    <td class="timesheet_workload">{{$timesheetPeriod['workload']}}</td>
                                                    <td class="timesheet_duration">{{$timesheetPeriod['duration']}}</td>
                                                    <td class="timesheet_approved">{{$timesheetPeriod['approved']}}</td>
                                                    <td class="timesheet_balance">{{$timesheetPeriod['balance']}}</td>
                                                    <td class="timesheet_status">{{$timesheetPeriod['status']}}</td>
                                                    @if($timesheetPeriod['status']=='Open')
                                                        <td class="submit_timesheet_wrap">
                                                            <button class="btn btn-success" id="submit_timesheet">
                                                                Submit
                                                            </button>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <a class="statistics_href"
                                                           href="{{route('statistic', $parameters = array('period' => str_replace('/','.',$timesheetPeriod['period'])), $secure = null)}}"><img
                                                                    style="height: 30px" src="/images/pencil.png"></a>
                                                    </td>
                                                </tr>
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
        </div> <!-- .content -->
    </div> <!-- /.content-page -->
    @include ('templates.modal-hide')
@endsection