<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    protected $table = 'project';

    public function projectOwner()
    {
        return $this->hasOne('App\Model\ProjectOwner', 'id', 'owner_id');
    }

    public function employeeProjects()
    {
        return $this->hasMany('App\Model\EmployeeProjects', 'id', 'employee_id');
    }


    public static function getProjects()
    {
        $array = [];
        $result = DB::table('project')
            ->select('project.id', 'project.workload', 'project.rate', 'project.name', 'project.workload AS projectWorkload', 'project_positions.employee_id',
                'project_positions.workload', 'project_positions.project_id', 'project.owner_id',
                DB::raw('CONCAT(project_owners.first_name, " ", project_owners.last_name) AS owner_full_name'),
                DB::raw('CONCAT(employee.first_name, " ", employee.last_name) AS employee_full_name'),
                'employee.id AS employee_id'
            )
            ->where('project.end_date', '>=', date("Y-m-d"))
            ->join("project_owners", "project_owners.id", "=", "project.owner_id")
            ->join("project_positions", "project_positions.project_id", "=", "project.id")
            ->join("employee", "project_positions.employee_id", "=", "employee.id")
            ->get();
        foreach ($result as $i => $result) {
            if (!isset($array[$result->id])) {
                $array[$result->id] = ['ownerName' => $result->owner_full_name, 'projectName' => $result->name, 'projectWorkload' => $result->projectWorkload, 'projectRate' => $result->rate];
                $array[$result->id]['employees'][] = ['employee_full_name' => $result->employee_full_name, 'workload' => $result->workload, 'id' => $result->employee_id];
            } else {
                $array[$result->id]['employees'][] = ['employee_full_name' => $result->employee_full_name, 'workload' => $result->workload, 'id' => $result->employee_id];
            }
        }

        return $array;
    }

    public function getTable()
    {
        return $this->table;

    }
}
