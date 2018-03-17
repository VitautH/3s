<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class YearlyTimesheet extends Model
{
    protected $table = 'yearly_timesheet';

    public function yearlyTimesheetItems()
    {
        return $this->hasMany('App\Model\YearlyItems', 'year_timesheet_id', 'id');
    }

    public function yearlyTimesheet($employee_id)
    {
        return DB::select("SELECT yearly_timesheet_items.*, t.*, sum(t.used) as sum_used   
                    FROM yearly_timesheet_items
                    LEFT JOIN (SELECT year_timesheet_id, used, balance FROM yearly_timesheet WHERE employee_id=$employee_id) AS t 
                    ON yearly_timesheet_items.id=t.year_timesheet_id 
                    WHERE year=".date('Y')."
                    GROUP BY name");
    }


}
