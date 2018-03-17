<?php

namespace App\Http\Controllers;

use App\Model\Project;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Model\Employee;
use App\Model\Notification;

class AdminController extends Controller
{
    public function index()
    {
        $employee_count = Employee::all()->count();
        $project_count = Project::all()->count();
        $notification_count = Notification::all()->where('status', '=', 1)->count();
        $notification_employees = Notification::getEmployees();

        return view('admin_main', compact('employee_count'), compact('project_count', 'notification_count', 'notification_employees'));
    }
}
