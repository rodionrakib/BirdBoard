<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\Task;
class ActivityFeedTest extends TestCase
{

    use RefreshDatabase;


    /** @test */

    public function creating_a_project_makes_a_activity()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->assertDatabaseHas('activities',['description' => 'created']);
    }


    /** @test */

    public function updating_a_project_makes_a_activity()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $project->title = "New Title";

        $project->save();

        $this->assertDatabaseHas('activities',['description' => 'updated']);
    }

    /** @test */

    public function creating_a_project_task_makes_a_activity()
    {

    	$this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $task = factory(Task::class)->make(['project_id' => $project->id] );

        $project->tasks()->save($task);

        //dd($task->activities->last());
        $this->assertDatabaseHas('activities',['activityable_id' => $project->tasks->last()->id]);

    }




    /** @test */

    public function compleating_a_task_makes_a_activity()
    {

    	$this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $task = factory(Task::class)->make(['project_id' => $project->id] );

        $project->tasks()->save($task);



        $this->actingAs($project->owner)->patch($task->path(),[
        	'completed' => true,
        ]);

        $this->assertDatabaseHas('activities',['description' => 'task_completed','activityable_id' => $project->id]);
    }


/** @test */
    public function incompleating_a_task_makes_a_activity()
    {

        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $task = factory(Task::class)->make(['project_id' => $project->id] );

        $project->tasks()->save($task);



        $this->actingAs($project->owner)->patch($task->path(),[
            'completed' => false,
        ]);

        $this->assertDatabaseHas('activities',['description' => 'task_incompleted','activityable_id' => $project->id]);
    }


}
