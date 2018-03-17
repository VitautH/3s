<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Employee extends Model
{
    protected $table = 'employee';

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function projectPosition()
    {
        return $this->hasMany('App\Model\ProjectPosition');
    }

    public function employeeProjects()
    {
        return $this->hasMany('App\Model\EmployeeProjects', 'employee_id', 'id');
    }

    public function getVacationSum($employee_id, $name)
    {

        return DB::table('yearly_timesheet')->select('balance')
            ->where('yearly_timesheet.employee_id', '=', $employee_id)
            ->where('yearly_timesheet_items.name', '=', $name)
            ->join("yearly_timesheet_items", "yearly_timesheet.year_timesheet_id", "=", "yearly_timesheet_items.id")
            ->orderBy('yearly_timesheet.created_at', 'desc')
            ->limit(1)
            ->first();
    }

}
