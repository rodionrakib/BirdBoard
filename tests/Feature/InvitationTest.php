<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;


class InvitationTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function invited_user_can_add_task_to_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);


        $project->invite($invitedUser = factory(User::class)->create());



        $this->signIn($invitedUser);



        $this->actingAs($invitedUser)->post('/projects/'.$project->id.'/tasks',[
            'title' => 'Buy A Car'
        ]);

        $this->assertDatabaseHas('tasks',['title' => 'Buy A Car']);


    }
}
