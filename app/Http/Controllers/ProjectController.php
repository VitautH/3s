<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Project;

class ProjectController extends Controller
{

    public function index()
    {

        return view('project');
    }
}
