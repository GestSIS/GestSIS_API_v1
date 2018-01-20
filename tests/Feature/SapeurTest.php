<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class SapeurTest extends TestCase
{
    use WithoutMiddleware;

    public function testSapeurIndex()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/sapeurs?start=0&limit=20');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id', 'nom', 'prenom', 'porteur', 'permis_c1', 'permis_c1_date', 'groupes', 'tel_prive', 'tel_prive_rta',
                    'tel_prof', 'tel_prof_rta', 'tel_mobile', 'tel_mobile_rta', 'date_naissance', 'email', 'no_rue', 'rue',
                    'date_inco', 'date_sortie', 'npa', 'localite', 'civilite', 'fonction', 'grade', 'photo'
                ]]
            ]);
    }

    public function testSapeurDetails()
    {
        $this->loadSisUser();

        $response = $this->get('/v1/sapeurs/10');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'sapeur' => [
                    'id', 'nom', 'prenom', 'porteur', 'permis_c1', 'permis_c1_date', 'groupes', 'tel_prive', 'tel_prive_rta',
                    'tel_prof', 'tel_prof_rta', 'tel_mobile', 'tel_mobile_rta', 'date_naissance', 'email', 'no_rue', 'rue',
                    'date_inco', 'date_sortie', 'profession', 'employeur', 'no_avs', 'permis_b', 'permis_b_date', 'lieu_travail',
                    'actif', 'cpt_bancaire', 'no_ccp', 'iban', 'iban_statut', 'politique', 'npa', 'localite', 'civilite', 'fonction', 'grade', 'photo'
                ],
                'mutations' => [[
                    'id', 'date_inco', 'date_sortie', 'localite'
                ]],
                'fonctions' => [[
                    'id', 'nom', 'nom_abr', 'date', 'fin', 'remarque'
                ]],
                'groupes' => [[
                    'id', 'no', 'nom'
                ]],
                'cours' => [[
                    'id', 'nom', 'nom_abr', 'date', 'lieu'
                ]],
                'promotions' => [[
                    'id', 'grade', 'grade_abr', 'date', 'remarque'
                ]],
                'ctrl_med' => [[
                    'id', 'date_consultation', 'date_validite', 'accepte', 'encours', 'type',
                    'medecin'
                ]],
                'exercices' => [], // Testé dans ExerciceTest
                'interventions' => [] // Testé dans InterventionTest
            ]);
    }
}
