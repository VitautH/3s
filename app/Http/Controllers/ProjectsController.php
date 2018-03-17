<?php

namespace App\Http\Controllers;

use App\Model\Employee;
use Illuminate\Http\Request;
use App\Model\Project;
use App\Model\ProjectOwner;
use App\Model\ProjectPosition;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::getProjects();

       return view('admin_projects', compact('projects'));
    }
}
