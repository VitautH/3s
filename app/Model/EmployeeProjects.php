<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeProjects extends Model
{
    protected $table = 'employee_projects';

    public static function getEmployeeProjects($id)
    {
        $result = DB::table('employee')->select('employee.*', 'project_positions.project_id', 'project_positions.workload as project_positionsWorkload',
            'project.name', 'project.rate', 'project.workload as projectWorkload','project_owners.first_name as project_ownersFirstName',
            'project_owners.last_name as project_ownersLastName')
            ->where('employee.id', '=', $id)
            ->join("project_positions", "project_positions.employee_id", "=", "employee.id")
            ->join("project", "project.id", "=", "project_positions.project_id")
            ->join("project_owners", "project_owners.id", "=", "project.owner_id")
            ->get();

        return $result;
    }
}
