<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\User;

class ProjectTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;




 /** @test */
 public function only_authenticated_can_create_a_project()
 {
     $attributes = factory(Project::class)->raw();
     $response = $this->post('/projects',$attributes);
     $response->assertRedirect('/login');

 }

 /** @test */
 public function one_user_cant_see_others_project()
 {
     // create two user
     // add a project to one ank make sure other cant access it
     $project = factory(Project::class)->create();

     $owner = factory(User::class)->create();
     $hacker = factory(User::class)->create();

     $owner->projects()->save($project);

     $response = $this->actingAs($hacker)->get('/projects/'.$project->id);
     $response->assertStatus(403);
     $response = $this->actingAs($owner)->get('/projects/'.$project->id);
     $response->assertOk();


 }

 /** @test */

 public function guest_cannot_see_a_project()
 {

      $project = factory(Project::class)->create();

      $response = $this->get('/projects/'.$project->id);

      $response->assertRedirect('/login');

 }

 /** @test */

 public function a_project_require_a_title()
 {
    $owner = factory(User::class)->create();

    $attributes = factory(Project::class)->raw(['title'=> '']);

    $response = $this->actingAs($owner)->post('/projects',$attributes);

    $response->assertSessionHasErrors('title');

 }

    /** @test */
    public function a_project_require_a_description()
    {
        $owner = factory(User::class)->create();

        $attributes = factory(Project::class)->raw(['description'=> '']);

        $response = $this->actingAs($owner)->post('/projects',$attributes);

        $response->assertSessionHasErrors('description');

    }

}
