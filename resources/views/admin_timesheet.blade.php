@extends('layouts.admin')
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
                                    <a href="#daily" data-toggle="tab" aria-expanded="true">Daily timesheet</a>
                                </li>
                                <li class="">
                                    <a href="#weekly" data-toggle="tab" aria-expanded="true">Weekly timesheet</a>
                                </li>
                                <li class="">
                                    <a href="#yearly" data-toggle="tab" aria-expanded="true">Yearly timesheet</a>
                                </li>
                            </ul>
                            <div id="myTab1Content" class="tab-content ">
                                <div class="tab-pane fade active in" id="daily">
                                    <div class="row">
                                        <div class="col-md-3 col-md-offset-3">
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
                                                <div class="row">
                                                    @if($employee_current == null)
                                                        <p>Choose employee:</p>
                                                    @else
                                                        <p>Employee:</p>
                                                    @endif
                                                    <select class="form-control employee_select"
                                                            id="daily_choose_employee" name="employee">
                                                        @if($employee_current !== null)
                                                            <option value="{{$employee_current}}"
                                                                    selected>{{$employees[$employee_current]->first_name.' '.$employees[$employee_current]->last_name}}</option>
                                                        @else
                                                            <option value="" selected>Choose employee</option>
                                                        @endif
                                                        @foreach($employees as $i=>$employee)
                                                            @if(($employee_current === null) ||(($employee_current !== null) and  ($employee->id !== $employees[$employee_current]->id)) )
                                                                <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{ csrf_field() }}
                                            </form>
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
                                                        <tr data-id="{{$item['id']}}">
                                                            <td class="first_cell_daily"><input
                                                                        class="checkbox_daily_item"
                                                                        data-id="{{$item['id']}}"
                                                                        type="checkbox"></td>
                                                            <td class="project_time">{{toHrsView($item['duration'])}}</td>
                                                            <td class="project_task"
                                                                data-task_id="{{$item['task_id']}}">{{$item['task']}}</td>
                                                            <td class="project_client"
                                                                data-client_id="{{$item['client_id']}}">{{$item['client']}}</td>
                                                            <td class="project_project"
                                                                data-project_id="{{$item['project_id']}}">{{$item['project']}}</td>
                                                            <td class="text_note">{{$item['note']}}</td>
                                                            <td>
                                                                <i class="fa fa-usd @if($item['billable']==1) billable_icon @endif"
                                                                   data-id="{{$item['id']}}" aria-hidden="true"></i>
                                                            </td>
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
                                        <div class="col-md-4 col-lg-3 central-part">
                                            <div class="row">
                                                <p>Employee:
                                                    @if($employee_current !==null)
                                                        <b>{{$employees[$employee_current]->first_name.' '.$employees[$employee_current]->last_name}}</b>
                                                    @else
                                                        N/A
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
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
                                            <table class="table">
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
                                            <p>Employee:
                                                @if($employee_current !==null)
                                                    <b>{{$employees[$employee_current]->first_name.' '.$employees[$employee_current]->last_name}}</b>
                                                @else
                                                    N/A
                                                @endif
                                            </p>
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
                                                    <th>Capped</th>
                                                    <th>Used</th>
                                                    <th>Balance</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Business Trip</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                </tr>
                                                <tr>
                                                    <td>Sickness</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                </tr>
                                                <tr>
                                                    <td>Unpaid leave</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                </tr>
                                                <tr>
                                                    <td>Vacation</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                </tr>
                                                <tr>
                                                    <td>Work remotely</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                    <td>0 days</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- /.tab-pane -->
                                <!-- /.tab-pane -->
                            </div> <!-- /.tab-content -->
                        </div>
                    </div> <!-- /.portlet-body -->
                </div> <!-- /.portlet -->
            </div> <!-- /.container -->
        </div> <!-- .content -->
    </div> <!-- /.content-page -->
    @include ('templates.modal-hide')
@endsection