<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExerciceTest extends TestCase
{
    use WithoutMiddleware;

    public function testExerciceIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/exercices?start=0&limit=20');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'date', 'heure', 'lieu', 'communication', 'duree', 'statut', 'categorie',
                    'localite', 'convoque', 'present', 'amende', 'type_excuse', 'id_type_excuse',
                    'presences_completees',
                    'sapeurs' => [[
                        'id', 'nom', 'prenom', 'convoque', 'present', 'absent', 'amende', 'type_excuse'
                    ]]
                ]]
            ]);
    }

    public function testExerciceExcuseType()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/excusestypes');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'designation'
                ]]
            ]);
    }

    public function testExerciceDetails()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/exercices/4000120');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'exercice' => [
                    'id', 'date', 'heure', 'lieu', 'communication', 'description', 'duree',
                    'statut', 'categorie', 'localite'
                ],
                'sapeurs' => [[
                    'id', 'nom', 'prenom', 'convoque', 'present', 'absent', 'amende', 'type_excuse'
                ]]
            ]);
    }
}
