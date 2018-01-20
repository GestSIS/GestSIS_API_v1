<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Core\Sis;
use App\Core\Auth;
use App\Core\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function loadSisUser(){
        Sis::retrieveSettings(env('SIS_ID'));
        Auth::actingAs(new User(env('USER_ID')));
    }
}
