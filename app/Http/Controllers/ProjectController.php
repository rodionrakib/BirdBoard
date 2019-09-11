<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {

        $projects = auth()->user()->projects;
        return view('projects.index',compact('projects'));
    }

    public function show(Project $project)
    {
        abort_if(auth()->id() !== $project->owner->id,403);
        return view('projects.show',compact('project'));
    }

    public function save(Request $request)
    {
        // validate
        $attribute = $request->validate(['title' => 'required', 'description' => 'required']);

        // persist
        Project::create($attribute);

        // redirect
        return redirect('/projects');
    }


}
