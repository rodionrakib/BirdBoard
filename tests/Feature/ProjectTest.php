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

public function guest_cant_visit_projects()
{
    $this->get('/projects')->assertRedirect('/login');
}

 /** @test */
 public function guest_cant_create_a_project()
 {

     $response = $this->post('/projects',['title' => '']);
     $response->assertRedirect('/login');

 }





/** @test */

 public function owner_can_update_his_project()
 {
    $this->withoutExceptionHandling();

    $this->signIn();
     
    $project = factory(Project::class)->create(['owner_id' => auth()->id()]);


    $this->patch($project->path(),['description' => 'Honey Boney','title' => 'updated']);
     
    $this->assertDatabaseHas('projects',['description' => 'Honey Boney','title' => 'updated']);
     
 }


 /** @test */

 public function one_user_cannot_delete_others_project()
 {
    $this->signIn();

    $otherUser  = factory(User::class)->create();
     
    $project = factory(Project::class)->make();

    $otherUser->projects()->save($project);

    $response = $this->delete($project->path()) ;

    $response->assertForbidden(); 

    $this->assertCount(1,Project::all());  

 }



 /** @test */

 public function owner_can_delete_his_project()
 {
      $this->signIn();
     
      $project = factory(Project::class)->create(['owner_id'=>auth()->id()]);

      $this->assertCount(1,Project::all()); 

      $this->delete('/projects/'.$project->id);
     
      $this->assertCount(0,Project::all());     

 }



 /** @test */

 public function owner_can_create_a_project()
 {
     $this->signIn();
     
     $data = factory(Project::class)->raw(['owner_id'=>auth()->id()]);

     $this->post('/projects',$data);
     
     $this->assertDatabaseHas('projects',$data);
     

 }




 /** @test */

 public function a_project_notes_is_optional()
 {
        $this->signIn();

        $attr = factory(Project::class)->raw(['notes' => '']);

        $response = $this->post('/projects',$attr);

        $response->assertSessionHasNoErrors('notes');

 }

 /** @test */

 public function a_project_require_a_title()
 {
        $this->signIn();

        $attr = factory(Project::class)->raw(['title' => '']);

        $response = $this->post('/projects',$attr);

        $response->assertSessionHasErrors('title');

 }

    /** @test */
    public function a_project_require_a_description()
    {
        $this->signIn();

        $attr = factory(Project::class)->raw(['description' => '']);

        $response = $this->post('/projects',$attr);

        $response->assertSessionHasErrors('description');

    }


    /** @test */

    public function owner_can_update_project_notes()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
     
        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(),[
            'notes' => 'I need to update my note',
            'title' => 'Update Title',
            'description' => 'lorem ipsum'

        ]);

        $this->assertDatabaseHas('projects',[
            'notes' => 'I need to update my note',
            'title' => 'Update Title',
            'description' => 'lorem ipsum'

        ]);


    }

}
