<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InterventionTest extends TestCase
{
    use WithoutMiddleware;

    public function testInterventionIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/interventions?start=0&limit=20');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'date', 'heure', 'lieu', 'objet', 'date_fin', 'heure_fin', 'quittance',
                    'present', 'nb_heures', 'nb_heures_piquet', 'nb_heures_entretien', 'type',
                    'npa', 'localite', 'traitement', 'stat_fed'
                ]]
            ]);
    }

    public function testInterventionDetails()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/interventions/5000013');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'intervention' => [
                    'id', 'date', 'heure', 'lieu', 'objet', 'date_fin', 'heure_fin', 'rapport_police',
                    'stat_fed_nb', 'personnes_sauvees', 'animaux_sauves', 'description', 'proprietaire',
                    'responsable', 'degre', 'type', 'npa', 'localite', 'traitement', 'stat_fed',
                    'chef_int_nom', 'chef_int_prenom'
                ],
                'sapeurs' => [[
                    'id', 'nom', 'prenom', 'quittance', 'present', 'nb_heure', 'nb_heure_piquet',
                    'nb_heure_entretien'
                ]],
                'groupes' => [[
                    'id', 'no', 'nom'
                ]],
                'vehicules' => [[
                    'id', 'nom'
                ]],
                'materiel' => [[
                    'id', 'nom'
                ]]
            ]);
    }
}
