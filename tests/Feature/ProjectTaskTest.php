<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Project;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;


    /** @test */

    public function a_project_can_have_tasks()
    {

      $this->withoutExceptionHandling();

      $this->actingAs(factory(User::class)->create());

      $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

      $this->post('/projects/'.$project->id.'/tasks',['title' => 'Buy toothpaste']);

      $this->get('/projects')->assertSee('Buy toothpaste');



    }

    /** @test */
    public function task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->actingAs(factory(User::class)->create());

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $task = factory(Task::class)->make();

        $project->tasks()->save($task);

        $this->patch($project->path().'/tasks/'.$task->id,[
            'title' => 'Task Updated Title',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',['title' => 'Task Updated Title', 'completed' => true,'project_id'=> $project->id]);

    }

    /** @test */
    public function project_can_be_deleted_by_owner()
    {
        $this->withoutExceptionHandling();

        $this->signIn();


        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);



        $this->actingAs($project->owner)->delete($project->path());


        $this->assertDatabaseMissing('projects',['id' => $project->id]);
    }


/** @test */

    public function a_task_can_be_updated_only_by_owner()
    {
        //$this->withoutExceptionHandling();

        $this->signIn();

        $this->actingAs(factory(User::class)->create());

        $project = factory(Project::class)->create(); // this project dont belongs to user


        $task = factory(Task::class)->create(); 

        $project->tasks()->save($task);


        $response = $this->patch($project->path().'/tasks/'.$task->id,[
            'title' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseMissing('tasks',['title' => 'changed']);

        $response->assertStatus(403);

    }
}
