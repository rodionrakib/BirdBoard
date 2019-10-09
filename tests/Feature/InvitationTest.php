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

    public function non_owner_cant_invite()
    {
        $user = $this->signIn();

        $project = factory(Project::class)->create();

        $this->actingAs($user)->post($project->path().'/invitation')
            ->assertStatus(403);



    }

    /** @test */
    public function must_have_a_account_to_whom_invitation_sent()
    {
        // $this->withoutExceptionHandling();


        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $response = $this->post($project->path().'/invitation',[
            'email' => 'dummy@gmail.com'
        ]);

        $response->assertSessionHasErrors(['email'=> 'User must have account']);


    }




    /** @test */
    public function only_owner_can_share_his_project()
    {

        $owner = $this->signIn();

    
       $ownerProject = factory(Project::class)->create(['owner_id' => auth()->id()]);



        $sharedUser = factory(User::class)->create();

        $ownerProject->invite($sharedUser);



         $this->actingAs($sharedUser)->post(
            $ownerProject->path().'/invitation',[

                'email' => factory(User::class)->create()->email
            ]

         )->assertStatus(403);


    }

    /** @test */

    public function must_be_owner_to_share_a_project()
    {
         $user = factory(User::class)->create();

    
         $project = factory(Project::class)->create();


         $anotherUser = factory(User::class)->create();

         $this->actingAs($user)->post(
            $project->path().'/invitation',[

                'email' => $anotherUser->email
            ]

         )->assertForbidden();

    }

    /** @test */
    public function project_can_be_invited()
    {
        $this->withoutExceptionHandling();

        $owner = $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);


        $inviteToUser = factory(User::class)->create();

        $this->actingAs($owner)->post($project->path().'/invitation',[
            'email' => $inviteToUser->email
        ]);

        $this->assertTrue($project->members->contains($inviteToUser));



    }

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
