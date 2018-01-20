<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BaseDataTest extends TestCase
{
    use WithoutMiddleware;

    public function testFederalStatIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/statfederal');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'statut', 'nom', 'tri'
                ]]
            ]);
    }

    public function testInterventionTypeIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/typeintervention');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'id_stat', 'nom', 'tri'
                ]]
            ]);
    }

    public function testGradeIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/grade');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'abr', 'nom', 'grp', 'tri'
                ]]
            ]);
    }

    public function tesCoursIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/cours');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'prec', 'id_gra', 'id_gra2004', 'id_fon', 'fon_cumul', 'abr',
                    'nom', 'tri'
                ]]
            ]);
    }

    public function testDistrictLocalityIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/districtlocality');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'nom', 'localite'
                ]]
            ]);
    }

    public function testControlesMedicauxTypesIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/cmedtype');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'type', 'tri'
                ]]
            ]);
    }
}
