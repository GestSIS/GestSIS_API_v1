<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SisTest extends TestCase
{
    public function testSisIndex()
    {
        $response = $this->get('/v1/sis');
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'actif' => true,
                'mobile' => true
            ])
            ->assertJsonStructure([
                'data' => [[
                    'abr', 'actif', 'id', 'mobile', 'nom', 'url'
                ]]
            ]);
    }
}
