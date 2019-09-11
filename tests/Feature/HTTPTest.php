<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HTTPTest extends TestCase
{
  /** @test */
  public function home_page_found()
  {
      $response = $this->get('/');
      $response->assertStatus(200);
  }

}
