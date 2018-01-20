<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class TransfertTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    private $connectionsToTransact = ['mysql_dba'];

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

    public function testTransfertCreation()
    {
        $this->loadSisUser();

        // Création du transfert
        $response = $this->json('POST', '/v1/transfert/rapport-intervention', [[
            'date_debut' => "2018-01-20T17:10:19+01:00",
            'date_fin' => "2018-01-20T17:55:00+01:00",
            'objet' => 'Rapport de test'
        ]]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $response = $this->get('/v1/transfert?complet=1&transmis=0');
        $content = $response->decodeResponseJson();

        // Confirmation réception transfert
        $response = $this->json('PUT', '/v1/transfert/'.$content['data'][count($content['data']) - 1]['id'].'/recu');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }
}
