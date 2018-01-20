<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TelephoneTest extends TestCase
{
    use WithoutMiddleware;

    public function testTelephoneIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/telephones');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'numero', 'nom', 'tri'
                ]]
            ]);
    }
}
