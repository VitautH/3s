<?php

namespace App\Http\Controllers;

use Auth;

use App\Model\Project;
use App\Model\YearlyTimesheet;
use App\Model\Notification;
use App\Model\Task;
use App\Model\ProjectOwner;
use Illuminate\Http\Request;
use App\Model\DailyTimesheet;


class TimesheetController extends Controller
{
    const WORKLOAD = 160;

    public function index(Request $request)
    {
        $date = $request->date ? $request->date : date("Y-m-d");

        $dailyTimesheet = new DailyTimesheet();
        $dailyTimesheet = $dailyTimesheet->getDailyInfo(Auth::user()['employee_id'], $date);
        $timesheetPeriod = $this->getTimesheetPeriod($request);
        $lastWeeks = $this->getLastWeeks($request);
        $weeklyTimesheet = $this->weeklyTimesheet($request);
        $projects = Project::all();
        $clients = ProjectOwner::all();
        $tasks = Task::all();
        $yearlyTimesheet = $this->yearlyTimesheet();

        return view('timesheet', compact('dailyTimesheet', 'lastWeeks', 'weeklyTimesheet', 'projects', 'clients', 'tasks', 'timesheetPeriod', 'yearlyTimesheet'));
    }

    public function getByDate(Request $request)
    {
        $dailyTimesheet = new DailyTimesheet();
        $dailyTimesheet = $dailyTimesheet->getDailyInfo(Auth::user()['employee_id'], $request->date);

        return $dailyTimesheet;
    }

    public function getById(Request $request)
    {
        return DailyTimesheet::find((int)$request->id);
    }

    public function insert(Request $request)
    {
        $this->validateRequest($request);
        try {
            $dailyTimesheet = new DailyTimesheet;
            $dailyTimesheet->employee_id = Auth::user()['employee_id'];
            $dailyTimesheet->project_id = $request->project_id;
            $dailyTimesheet->task_id = $request->task_id;
            $dailyTimesheet->client_id = $request->client_id;
            $dailyTimesheet->duration = $request->duration;
            $dailyTimesheet->date = $request->date;
            $dailyTimesheet->billable = $request->billable;
            $dailyTimesheet->note = $request->note;
            $dailyTimesheet->save();

            return response()->json(['success' => true, 'last_id' => $dailyTimesheet->id]);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()]);
        }

    }

    public function update(Request $request)
    {
        $this->validateRequest($request);
        try {
            $dailyTimesheet = DailyTimesheet::find((int)$request->id);
            $dailyTimesheet->project_id = $request->project_id;
            $dailyTimesheet->task_id = $request->task_id;
            $dailyTimesheet->client_id = $request->client_id;
            $dailyTimesheet->duration = $request->duration;
            $dailyTimesheet->date = $request->date;
            $dailyTimesheet->billable = $request->billable;
            $dailyTimesheet->note = $request->note;
            $dailyTimesheet->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete(Request $request)
    {
        try {
            DailyTimesheet::destroy($request->id);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $dailyTimesheet = DailyTimesheet::find((int)$request->id);
            $dailyTimesheet->billable = $request->billable;
            $dailyTimesheet->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function getLastWeeks(Request $request)
    {
        $data = [];
        $date = !isset($request->weekly_date) ? date('m/d', strtotime('monday this week')) . " - " . date('m/d', strtotime('sunday this week')) : $request->weekly_date;

        $data[] = $date;

        $date = explode('-', $date);

        for ($i = 1; $i <= 4; $i++) {
            $data[] = date('m/d', strtotime("$date[0] - $i week")) . " - " . date('m/d', strtotime("$date[1] - $i week"));
        }

        return array_reverse($data);
    }

    public function weeklyTimesheet(Request $request)
    {
        $date = $request->date;
        // по умолчанию текущая неделя
        $date = $date == null ? date('m/d', strtotime('monday this week')) . " - " . date('m/d', strtotime('sunday this week')) : $date;

        $date = explode('-', $date);
        $buf_date = date('Y-m-d', strtotime($date[0] . ' - 1 day'));
        $data_date = [];

        // дни и даты текущей недели
        while ($buf_date < date('Y-m-d', strtotime($date[1]))) {
            $buf_date = date('Y-m-d', strtotime($buf_date . ' + 1 day'));
            $data_date[] = $buf_date;
        }

        // получение проектов по датам
        $data_weekly = [];
        foreach ($data_date as $value) {
            $data_weekly[$value] = DailyTimesheet::all()
                ->where('employee_id', Auth::user()['employee_id'])
                ->where('date', date('Y-m-d', strtotime($value)));
        }

        // получение всех сущестсвующих проектов, чтобы не обращаться к БД каждый раз
        $projects = [];
        $data_projects = Project::all();
        foreach ($data_projects as $project) {
            $projects[$project->id] = $project->name;
        }

        // приведение информации в массив проект -> дата -> сумма потраченного времени
        $array_projects = [];
        foreach ($data_weekly as $key => &$item) {
            foreach ($item as $value) {
                if (!isset($array_projects[$projects[$value->project_id]][$value->date])) {
                    $array_projects[$projects[$value->project_id]][$value->date] = 0;
                }
                $array_projects[$projects[$value->project_id]][$value->date] += $value->duration;
            }
            $item = '';
        }
        unset($item);

        foreach ($array_projects as &$item) {
            foreach ($item as &$value) {
                $value = $this->toHrsView($value);
            }
            $item = array_merge($data_weekly, $item);
        }
        unset($value);
        unset($item);

        return $array_projects;
    }

    public function getTimesheetPeriod(Request $request)
    {
        $data = [];
        if (!$request->from && !$request->to) {
            $from = date('Y-m-d', strtotime('first day of this month'));
            $to = date('Y-m-d', strtotime('last day of this month'));
        } else {
            $from = $this->toDateView($request->from);
            $to = $this->toDateView($request->to);
        }

        $dailyTimesheet = DailyTimesheet::all()
            ->where('employee_id', Auth::user()['employee_id'])
            ->where('date', '>=', $from)
            ->where('date', '<=', $to);

        $data['period'] = date('d/m/Y', strtotime($from)) . " - " . date('d/m/Y', strtotime($to));

        $data['workload'] = self::WORKLOAD;
        $data['duration'] = 0;
        foreach ($dailyTimesheet as $item) {
            $data['duration'] += $item->duration;
        }

        $approved = Notification::all()->where('employee_id', Auth::user()['employee_id'])->where('date_from', '>=', $from)
            ->where('date_to', '<=', $to)->pluck('duration')->first();

        $data['approved'] = $this->toHrsView($approved);
        $data['balance'] = $data['duration'] - (self::WORKLOAD * 60);
        $data['balance'] = $this->toHrsView($data['balance']);
        $data['duration'] = $this->toHrsView($data['duration']);
        $data['status'] = Notification::all()
            ->where('date_from', $from)
            ->where('date_to', $to)
            ->where('employee_id', Auth::user()['employee_id'])
            ->pluck('status')
            ->first() ? 'Submitted By Employee' : 'Open';

        return $data;
    }

    public function insertNotification(Request $request)
    {
        try {
            $from = $this->toDateView($request->from);
            $to = $this->toDateView($request->to);
            $notification = new Notification;
            $notification->employee_id = Auth::user()['employee_id'];
            $notification->duration = $request->duration;
            $notification->date_from = $from;
            $notification->date_to = $to;
            $notification->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function timesheetStatistic(Request $request)
    {
        $period = explode('-', $request->period);

        $from = date('Y-m-d', strtotime("first day of {$period[0]}"));
        $to = date('Y-m-d', strtotime($period[1]));

        $period_submit = date('d/m/Y', strtotime($period[0])) . ' - ' . date('d/m/Y', strtotime($period[1]));

        $status = Notification::all()
            ->where('date_from', $from)
            ->where('date_to', $to)
            ->where('employee_id', Auth::user()['employee_id'])
            ->pluck('status')
            ->first() ? 'Submitted By Employee' : 'Open';

        $time = [];

        // total time
        $time['total'] = DailyTimesheet::all()
            ->where('employee_id', Auth::user()['employee_id'])
            ->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->sum('duration');

        $time['billable'] = DailyTimesheet::all()
            ->where('employee_id', Auth::user()['employee_id'])
            ->where('billable', 1)
            ->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->sum('duration');

        $time['balance'] = (self::WORKLOAD * 60) - $time['billable'];
        $time['workload'] = self::WORKLOAD;
        $time['approved'] = Notification::all()
            ->where('employee_id', Auth::user()['employee_id'])
            ->where('date_from', '>=', $from)
            ->where('date_to', '<=', $to)
            ->pluck('duration')
            ->first();

        $dailyTimesheet = new DailyTimesheet();
        $projects = new Project();
        $tasks = new Task();

        //task total time
        $tasksBill = $dailyTimesheet->getMeta($tasks->getTable(), $from, $to, Auth::user()['employee_id'], 1);
        $tasksUnBill = $dailyTimesheet->getMeta($tasks->getTable(), $from, $to, Auth::user()['employee_id'], 0);
        $data_tasks = [];

        if (isset($tasksBill)) {
            foreach ($tasksBill as $item) {
                $data_tasks[$item->name]['billable'] = isset($item->sum) ? $item->sum : 0;
                $data_tasks[$item->name]['unbillable'] = 0;
                $data_tasks[$item->name]['total'] = isset($item->sum) ? $item->sum : 0;
            }
        }

        foreach ($tasksUnBill as $item) {
            $data_tasks[$item->name]['billable'] = isset($data_tasks[$item->name]['billable']) ? $data_tasks[$item->name]['billable'] : 0;
            $data_tasks[$item->name]['unbillable'] = $item->sum;
            $data_tasks[$item->name]['total'] = $data_tasks[$item->name]['billable'] + $item->sum;
        }

        //project total time
        $projectsBill = $dailyTimesheet->getMeta($projects->getTable(), $from, $to, Auth::user()['employee_id'], 1);
        $projectsUnBill = $dailyTimesheet->getMeta($projects->getTable(), $from, $to, Auth::user()['employee_id'], 0);
        $data_projects = [];

        if (isset($projectsBill)) {
            foreach ($projectsBill as $item) {
                $data_projects[$item->name]['billable'] = isset($item->sum) ? $item->sum : 0;
                $data_projects[$item->name]['unbillable'] = 0;
                $data_projects[$item->name]['total'] = isset($item->sum) ? $item->sum : 0;
            }
        }

        foreach ($projectsUnBill as $item) {
            $data_projects[$item->name]['billable'] = isset($data_projects[$item->name]['billable']) ? $data_projects[$item->name]['billable'] : 0;
            $data_projects[$item->name]['unbillable'] = $item->sum;
            $data_projects[$item->name]['total'] = $data_projects[$item->name]['billable'] + $item->sum;
        }

        // worked total time by weeks
        $lastMonday = date('Y-m-d', strtotime("last monday of {$period[0]}"));
        $sunday = date('Y-m-d', strtotime("$lastMonday + 6 days"));

        $last_week = date('m/d', strtotime($lastMonday)) . " - " . date('m/d', strtotime($sunday));
        $request->weekly_date = $last_week;

        $week_range = $this->getLastWeeks($request);
        $weeksTime = [];
        foreach ($week_range as $week) {
            $week_date = explode('-', $week);
            $weeksTime[$week] = DailyTimesheet::all()
                ->where('employee_id', Auth::user()['employee_id'])
                ->where('date', '>=', date('Y-m-d', strtotime($week_date[0])))
                ->where('date', '<=', date('Y-m-d', strtotime($week_date[1])))->sum('duration');
        }

        // получение всех существующих проектов, чтобы не обращаться к БД каждый раз
        $projects = [];
        $buf_projects = Project::all();
        foreach ($buf_projects as $project) {
            $projects[$project->id] = $project->name;
        }

        $tasks = [];
        $buf_tasks = Task::all();
        foreach ($buf_tasks as $task) {
            $tasks[$task->id] = $task->name;
        }

        $dailyTimesheet = DailyTimesheet::all()
            ->where('employee_id', Auth::user()['employee_id'])
            ->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->groupBy('date');


        foreach ($dailyTimesheet as $key => $timesheet) {
            $sum = 0;
            foreach ($timesheet as $item) {
                $sum += $item->duration;
                $item->setAttribute('project', $projects[$item->project_id]);
                $item->setAttribute('task', $tasks[$item->task_id]);
            }
            $dailyTimesheet[$key]['sum'] = $sum;
        }

        $days = [];

        while ($from <= $to) {
            $days[$from] = '';
            $from = date('Y-m-d', strtotime("$from + 1 day"));
        }

        $dailyTimesheet = $dailyTimesheet->toarray();
        $dailyTimesheet = array_merge($days, $dailyTimesheet);

        return view('timesheet-submit', compact('time', 'data_tasks', 'data_projects', 'weeksTime', 'dailyTimesheet', 'period_submit', 'status'));
    }

    public function yearlyTimesheet()
    {
        $yearlyTimesheet = new YearlyTimesheet();

        return $yearlyTimesheet->yearlyTimesheet(Auth::user()['employee_id']);
    }

    protected function validateRequest(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required|integer',
            'task_id' => 'required|integer',
            'client_id' => 'required|integer',
            'duration' => 'required|integer',
            'date' => 'required|date_format:Y-m-d',
            'billable' => 'required|integer',
        ]);

    }

    protected function toHrsView($minutes)
    {
        $negative = false;
        if ($minutes < 0) {
            $negative = true;
            $minutes = abs($minutes);
        }
        $result = (intval($minutes / 60)) . ':' . (($minutes % 60 < 10) ? '0' . $minutes % 60 : $minutes % 60);
        $result = $negative ? "-" . $result : $result;

        return $result;
    }

    protected function toDateView($date)
    {
        $result = explode('/', $date);
        $result = array_reverse($result);
        $result = implode('-', $result);
        $result = date('Y-m-d', strtotime($result));

        return $result;
    }

}
