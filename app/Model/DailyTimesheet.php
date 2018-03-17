<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DailyTimesheet extends Model
{
    protected $table = 'daily_timesheet';

    public function getMeta($table, $from, $to, $employee_id, $billable)
    {
        $tableField = [
            'project' => 'project_id',
            'tasks' => 'task_id'
        ];

        return DB::select("SELECT daily_timesheet.{$tableField[$table]}, SUM(daily_timesheet.duration) as sum, $table.name
                  FROM daily_timesheet INNER JOIN $table ON daily_timesheet.{$tableField[$table]}=$table.id
                  WHERE daily_timesheet.date >= '$from' 
                  AND daily_timesheet.date <= '$to' 
                  AND daily_timesheet.employee_id=$employee_id 
                  AND daily_timesheet.billable = $billable 
                  GROUP BY daily_timesheet.{$tableField[$table]} 
                  ");
    }

    public function getDailyInfo($employee_id, $date)
    {
        return DB::table('daily_timesheet')->select('daily_timesheet.*', 'project.name as project', 'tasks.name as task', 'project_owners.company_name as client')
            ->where('daily_timesheet.employee_id', '=', $employee_id)
            ->where('daily_timesheet.date', '=', $date)
            ->join("project", "project.id", "=", "daily_timesheet.project_id")
            ->join("tasks", "tasks.id", "=", "daily_timesheet.task_id")
            ->join("project_owners", "project_owners.id", "=", "daily_timesheet.client_id")
            ->get();
    }

}
