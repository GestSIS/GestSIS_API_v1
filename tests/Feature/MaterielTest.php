<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MaterielTest extends TestCase
{
    use WithoutMiddleware;

    public function testMaterielIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/materiel');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'nom', 'tri'
                ]]
            ]);
    }
}
