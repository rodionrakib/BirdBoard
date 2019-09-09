<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function save(Request $request)
    {
        // validate
        $attribute = $request->all();

        // persist
        Project::create($attribute);

        // redirect
        return redirect('/projects');
    }

    public function index()
    {
        $projects = Project::all();
        return view('projects.index',compact('projects'));
    }
}
