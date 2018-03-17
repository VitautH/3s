<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    protected $table = 'notifications';

    public static function getEmployees()
    {
        $result = DB::table('notifications')->select('notifications.employee_id', 'notifications.status', 'employee.id',
            'employee.first_name as employee_FirstName',
            'employee.last_name as employee_LastName')
            ->where('notifications.status', '=', 1)
            ->join("employee", "employee.id", "=", "notifications.employee_id")
            ->get();

        return $result;
    }

}
