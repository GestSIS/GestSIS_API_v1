<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransfertTest extends TestCase
{
    use WithoutMiddleware;

    public function testTranfertIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/transfert');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'categorie', 'nom', 'contenu', 'date_creation', 'date_reception', 'complet'
                ]]
            ]);
    }

    // TODO : Tester la création d'une transfert + confirmation réception (Laravel 5.5)
}
