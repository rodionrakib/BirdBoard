<?php

namespace Tests\Unit;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
class ProjectTest extends TestCase
{
   use RefreshDatabase;


   /** @test */
   public function a_project_can_be_invited()
   {
       $this->withoutExceptionHandling();

       $this->signIn();

       $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

       $invitedUser = factory(User::class)->create();

       $project->invite($invitedUser);

       $this->assertTrue( $project->members->contains($invitedUser));
       $this->assertDatabaseHas('project_member',['project_id' => $project->id,'user_id' => $invitedUser->id]);



   }


   /** @test */
   public function shared_and_owned_project_are_accessable()
   {
       $this->withoutExceptionHandling();

       $john = $this->signIn();

       $projectByJohn = factory(Project::class)->create(['owner_id' => auth()->id()]);

       $doe = factory(User::class)->create();

       $projectByJohn->invite($doe);



        $this->assertCount(1,$doe->getAccessableProject());


   }
}
