<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Activity;

class ProjectController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {

        $projects = auth()->user()->getAccessableProject();
        return view('projects.index',compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update',$project);

        $activities = $project->getActivities();

       
        //dd($activities);                            


        return view('projects.show',['project' => $project , 'activities' => $activities]);
    }

    public function create()
    {
        return view('projects.create');
    }


    public function save(Request $request)
    {
        
        $data = $this->validation($request);

        $data['owner_id'] = auth()->id();

        Project::create($data);

        return redirect('/projects');
    }

    public function update(Request $request,Project $project)
    {

        $this->authorize('update',$project);

        $data = $this->validation($request);

        $project->update($data);
        

        return redirect($project->path());

    }

    public function edit(Project $project)
    {
        return view('projects.edit',compact('project')); 
    }
    public function destroy(Project $project)
    {


        $this->authorize('manage',$project);

        $project->delete();

        return redirect('/projects');
    }

    public function validation($request)
    {
        return $request->validate([
            'title' => 'required|sometimes|max:255',
            'description' => 'required|sometimes',
            'notes' => 'sometimes',
        ]);
    }


}
