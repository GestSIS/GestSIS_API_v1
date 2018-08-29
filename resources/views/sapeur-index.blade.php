@extends('layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Sapeurs</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Sapeurs</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!--<div class="col-md-3 col-lg-3 col-sm-6 col-6">
      </div>-->
      <div class="col-md-12 col-lg-12 col-sm-12 col-12">
        <a class="btn btn-app">
          <i class="fas fa-info"></i> Info
        </a>
        <a class="btn btn-app">
          <i class="fas fa-medal"></i> Fonctions
        </a>
        <a class="btn btn-app">
          <i class="fas fa-book-open"></i> Cours
        </a>
        <a class="btn btn-app">
          <i class="fas fa-award"></i> Promotion
        </a>
        <a class="btn btn-app">
          <i class="fas fa-sitemap"></i> Organisation
        </a>
        <a class="btn btn-app">
          <i class="fas fa-toolbox"></i> Matériel personnel
        </a>
        <a class="btn btn-app">
          <i class="fas fa-car"></i> Permis
        </a>
        <a class="btn btn-app">
          <i class="fas fa-file-medical-alt"></i> Contrôles médicaux
        </a>
        <a class="btn btn-app">
          <i class="fas fa-university"></i> Banque
        </a>
        <a class="btn btn-app">
          <i class="fas fa-calendar-alt"></i> Exercices
        </a>
      </div>
      <div class="col-md-3 col-lg-3 col-sm-6 col-6"> <!-- TODO Find a solution for small devices by hidding the sapeur list-->
        <div class="card card-primary card-outline">
          <div class="card-header">
            <!--<h3 class="card-title">TODO Ajout des tris sur actif/inactif/tous</h3>-->
            <!--<div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input name="table_search" class="form-control float-right" placeholder="Search" type="text">

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
              </div>
            </div>-->
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table table-hover table-condensed">
              <tbody>
              <!--<tr>
                <th>Task</th>
                <th>Progress</th>
                <th style="width: 40px">Label</th>
              </tr>-->
              <!-- TODO loop sur sapeurs -->
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
              <tr>
                <td>Sapeur name</td>
              </tr>
            </tbody></table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-5 col-lg-5 col-sm-6 col-6">
        <!-- general form elements -->
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Données personnelles</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form">
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Civilité</label>
                <select class="form-control">
                  <option>Monsieur</option>
                  <option>Madame</option>
                </select>
              </div>
              <!-- NOM -->
              <div class="form-group">
                <label for="nomInput">Nom</label>
                <input class="form-control" id="nomInput" placeholder="">
              </div>
              <!-- PRENOM -->
              <div class="form-group">
                <label for="prenomInput">Prénom</label>
                <input class="form-control" id="prenomInput" placeholder="">
              </div>
              <!-- RUE -->
              <div class="row">
                <div class="col-8">
                  <div class="form-group">
                    <label for="rueInput">Rue</label>
                    <input type="text" class="form-control" id="rueInput">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label for="nInput">N°</label>
                    <input class="form-control" id="nInput">
                  </div>
                </div>
              </div>
              <!-- NPA + LOCALITE -->
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label for="npaInput">NPA</label>
                    <input type="text" class="form-control" id="npaInput">
                  </div>
                </div>
                <div class="col-8">
                  <div class="form-group">
                    <label for="localiteInput">Localité</label>
                    <select class="form-control" id="localiteInput">
                      <option>Saulcy</option>
                      <option>Bassecourt</option>
                      <!-- TODO auto-complete + auto sélection with NPA -->
                    </select>
                  </div>
                </div>
              </div>
              <!-- N° AVS -->
              <div class="form-group">
                <label for="avsInput">N° AVS</label>
                <input type="text" class="form-control" id="avsInput">
              </div>
              <!-- DATE NAISSANCE + SUFFIXE -->
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label for="naissanceInput">Date de naissance</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                      <input class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" id="naissanceInput" type="text">
                      <!-- TODO fix this -->
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="suffixeInput">Suffixe</label>
                    <input type="text" class="form-control" id="suffixeInput">
                  </div>
                </div>
                <div class="col-5">
                  <p>Permet de différencier deux personnes ayant le même nom et prénom.</p>
                </div>
              </div>
              <!-- REMARQUE -->
              <div class="form-group">
                <label for="remarqueInput">Remarques</label>
                <input type="text" class="form-control" id="remarqueInput">
              </div>
            </div>
            <!-- /.card-body -->

            <!--<div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>-->
          </form>
        </div>
        <!-- /.card -->

        <!-- Form Element sizes -->
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Contact</h3>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="emailInput">Email</label>
              <div class="input-group mb-3">
                <!--<label for="emailInput">Email</label>-->
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                </div>
                <input class="form-control" type="email" id="emailInput">
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  <label for="remarqueInput">Tel priv</label>
                </div>
                <div class="form-group">
                  <label for="remarqueInput">Smartphone</label>
                </div>
                <div class="form-group">
                  <label for="remarqueInput">Tel Prof</label>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <input type="text" class="form-control" id="remarqueInput">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="remarqueInput">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="remarqueInput">
                </div>
              </div>
              <!-- TODO N° Transmis pour alarm au CET -->
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->

      <div class="col-md-4 col-lg-4 col-sm-6 col-6">
        <!-- general form elements -->
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Références professionnelles</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form">
            <div class="card-body">
              <div class="form-group">
                <label for="professionInput">Profession</label>
                <input class="form-control" id="professionInput" type="text">
              </div>
              <div class="form-group">
                <label for="employeurInput">Employeur</label>
                <input class="form-control" id="employeurInput" type="text">
              </div>
              <div class="form-group">
                <label for="lieuTravailInput">Lieu de travail</label>
                <input class="form-control" id="lieuTravailInput" type="text">
              </div>
              <!-- TODO Add image -->
            </div>
          </form>
        </div>
        <!-- /.card -->

        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Incorporation / Sortie</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form">
            <div class="card-body">
              <!-- TODO Migrations content -->
            </div>
          </form>
        </div>
        <!-- /.card -->

        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Informations</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form">
            <div class="card-body">
              <div class="form-group">
                <label for="fonctionInput">Fonction principale</label>
                <input class="form-control" id="fonctionInput" type="text">
              </div>
              <div class="form-group">
                <label for="gradeInput">Grade actuel</label>
                <input class="form-control" id="gradeInput" type="text">
              </div>
              <!-- TODO Actif et Porteur checkbox -->
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

@stop
