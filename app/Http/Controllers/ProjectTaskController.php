<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;

class ProjectTaskController extends Controller
{
	public function store(Project $project,Request $request)
	{




        $this->authorize('update',$project);

		$data = $request->validate([

			'title' => 'required'
		]);

		$task = Task::make($data);

		$project->tasks()->save($task);
		
		return redirect($project->path()); 

	}


	public function update(Project $project,Task $task,Request $request)
    {





        $this->authorize('update',$project);

    	$attributes = $request->validate([
            'title' => 'sometimes',
            'completed' => 'sometimes'
        ]);


    	
        $task->update([
        	'title' => $request->get('title'),
        	'completed' => $request->has('completed')
        ]);

        return redirect($project->path());


    }


   
}
