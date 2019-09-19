<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;
use App\User;

class TaskTest extends TestCase
{
	use RefreshDatabase;

	/** @test */

    public function task_can_be_added_to_projects()
    {

    $this->withoutExceptionHandling();



    $project =  factory(\App\Project::class)->create();

    $project->addTask(['title'=> 'Clean Room']);

    $this->assertDatabaseHas('tasks',['title'=> 'Clean Room']);


    }


    /** @test */

    public function guest_cannot_add_task()
    {
        $project = factory(\App\Project::class)->create();

        $response = $this->post($project->path().'/tasks',['title' => 'Nak Gollacce']);

        $response->assertRedirect('/login');        
    }

    /** @test */

    public function only_ownre_of_the_project_can_add_task()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(\App\Project::class)->create();

        $response = $this->post($project->path().'/tasks',['title' => 'Nak Gollacce']);

        $response->assertStatus(403);



    }

}
