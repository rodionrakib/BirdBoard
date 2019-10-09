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


    /** @test */
    public function owned_and_shared_project_can_be_seen_from_dashboard()
    {
        $this->withoutExceptionHandling();

        $motu = $this->signIn();

        $projectByMotu = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $patlu = factory(User::class)->create();

        $projectByMotu->invite($patlu);

        $this->signIn($patlu);

        $this->get('/projects')->assertSee($projectByMotu->title);


    }


    /** @test */

    public function user_but_not_owner_cant_update_others_project()
    {
        //$this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->patch($project->path(),['description' => 'Honey Boney','title' => 'updated']);

        $response->assertStatus(403);
    }

    /** @test */




    public function user_but_not_owner_cant_delete_others_project()
    {
        $owner = $this->signIn();

        $project = factory(Project::class)->create(['owner_id'=>auth()->id()]);

        $user = factory(User::class)->create();

        $this->assertCount(1,Project::all());

        $this->actingAs($user)->delete($project->path());

        $this->assertCount(1,Project::all());

        $project->invite($user);

        $this->actingAs($user)->delete($project->path())
                ->assertStatus(403);

    }




    public function owner_can_delete_his_project()
    {
        $owner = $this->signIn();

        $project = factory(Project::class)->create(['owner_id'=>auth()->id()]);

        $this->assertCount(1,Project::all());

        $this->actingAs($owner)->delete('/projects/'.$project->id);

        $this->assertCount(0,Project::all());

    }

    /** @test */

    public function owner_can_update_his_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(),['title' => 'updated','description' => 'As Usual']);

        $this->assertDatabaseHas('projects',['title' => 'updated']);

    }


/** @test */
    public function user_can_create_projects()
    {
        $this->signIn();


        $this->post('/projects',[
            'title' => 'new project',
            'description' => 'cool project'
        ]);

        $this->assertDatabaseHas('projects',['title'=> 'new project','description'=> 'cool project']);


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

}
