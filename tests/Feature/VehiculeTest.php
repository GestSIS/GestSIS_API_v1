<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VehiculeTest extends TestCase
{
    use WithoutMiddleware;

    public function testVehiculeIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/vehicule');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'nom', 'tri'
                ]]
            ]);
    }
}
