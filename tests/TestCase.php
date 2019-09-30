<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn(User $user = null)
    {

        if($user){
            $this->actingAs($user);
            return $user;
        }
        else{
            $this->actingAs($user = factory(User::class)->create());
            return $user;
        }
        //return $user ? $this->actingAs($user) : $this->actingAs(factory(User::class)->create());

    }
}
