<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Model\Employee;
use App\Model\ProjectPosition;
use App\Model\Project;
use App\Model\EmployeeProjects;

class UsersController extends Controller
{
    public function index()
    {

        $employees = Employee::all();

        foreach ($employees as &$item) {

            $item->setAttribute('project_id', Employee::find($item->id)->projectPosition()->pluck('project_id'));
            $item->setAttribute('project_name', Project::find($item->project_id)->pluck('name'));
            $item->setAttribute('project_rate', Project::find($item->project_id)->pluck('rate'));

        }

        unset($item);

        return view('admin_users', compact('employees'));
    }

    public function viewUser(Request $request)
    {
        $userId = preg_match('/^\d+$/', $request->id);
        if ($userId) {
            if (Employee::find($request->id) !== null) {
                $employee_info = EmployeeProjects::getEmployeeProjects($request->id);
                $photoUrl = User::all()->where('employee_id', '==', $request->id)->pluck('photo_url')->first();
                if (empty($photoUrl)) {
                    $photoUrl = "/images/avatars/no-photo.png";
                } else {
                    $photoUrl = "/images/avatars/{$photoUrl}";
                }

                $employee = new Employee();

                if ($vacation = $employee->getVacationSum($request->id, 'Vacation')) {
                    $vacation = $vacation->balance;
                } else {
                    $vacation = null;
                }
                $layout = 'layouts.admin';

                return view('profile', compact('employee_info', 'photoUrl'), compact('layout', 'vacation'));
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }
}