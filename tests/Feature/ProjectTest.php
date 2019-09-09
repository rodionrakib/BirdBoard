<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;


    /** @test */
 public function a_user_can_create_a_project()
 {
     $this->withoutExceptionHandling();

     $attributes = [
         'title' => $this->faker->sentence,
         'description' => $this->faker->text(150)
     ];

     $this->post('/projects',$attributes)->assertRedirect('/projects');

     $this->assertDatabaseHas('projects',$attributes);

     $this->get('/projects')->assertSee($attributes['description']);

 }
}