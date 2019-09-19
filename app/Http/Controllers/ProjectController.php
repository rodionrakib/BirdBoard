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

    public function create()
    {
        return view('projects.create');
    }


    public function save(Request $request)
    {
        
        $validatedData = $this->validation($request);

        $validatedData['owner_id'] = auth()->id();


        // persist
        Project::create($validatedData);

        // redirect
        return redirect('/projects');
    }

    public function update(Request $request,Project $project)
    {



        $project->update($request->all());
        

        return redirect($project->path());

    }

    public function edit(Project $project)
    {
        return view('projects.edit',compact('project')); 
    }
    public function destroy(Project $project)
    {
        abort_if($project->owner_id !== auth()->id(),403);

        $project->delete();
    }

    public function validation($request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'notes' => 'sometimes',
        ]);
    }


}
