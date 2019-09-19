<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn()
    {
    	$this->actingAs(factory(User::class)->create());
    }
}
