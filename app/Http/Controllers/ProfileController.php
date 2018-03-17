<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\EmployeeProjects;
use Auth;
use File;
use App\User;
use App\Model\Employee;


class ProfileController extends Controller
{

    public function index()
    {
        $userId = Auth::user()['employee_id'];
        $employee_info = EmployeeProjects::getEmployeeProjects($userId);
        $employee = new Employee();

        if ($vacation = $employee->getVacationSum(Auth::user()['employee_id'], 'Vacation')) {
            $vacation = $vacation->balance;
        } else {
            $vacation = null;
        }
        $photoUrl = Auth::user()['photo_url'];
        if (empty($photoUrl)) {
            $photoUrl = "/images/avatars/no-photo.png";
        } else {
            $photoUrl = "/images/avatars/{$photoUrl}";
        }

        $layout = 'layouts.app';

        return view('profile', compact('employee_info', 'photoUrl'), compact('layout', 'vacation'));
    }

    public function projects()
    {
        $userId = Auth::user()['employee_id'];
        $projects = EmployeeProjects::getEmployeeProjects($userId);
        $layout = 'layouts.app';

        return view('projects', compact('projects'), compact('layout'));
    }

    public function upload(Request $request)
    {
        $this->ValidatePhoto($request);
        $photoName = time() . '.' . $request->avatar_photo->getClientOriginalExtension();
        $request->avatar_photo->move(public_path('images/avatars'), $photoName);
        $user = User::find(Auth::user()['id']);
        $path = "images/avatars/" . $user->photo_url;
        if (file_exists($path)) {
            File::delete($path);
        }
        $user->photo_url = $photoName;
        $user->save();

        return $photoName;
    }

    public function ValidatePhoto(Request $request)
    {
        $this->validate($request, [
            'avatar_photo' => 'mimes:jpeg,bmp,png',
        ]);
    }

}
