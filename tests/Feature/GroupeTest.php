<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class GroupeTest extends TestCase
{
    use WithoutMiddleware;

    public function testGroupeIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/groupes');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'id_pere', 'type', 'numero', 'designation', 'info', 'tri', 'fils', 'prefixe'
                ]]
            ]);

    }
}
