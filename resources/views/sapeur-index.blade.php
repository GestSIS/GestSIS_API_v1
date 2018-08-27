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
      <div class="col-md-3 col-lg-3 col-sm-6 col-6"> <!-- TODO Find a solution for small devices by hidding the sapeur list-->
        <div class="card">
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
        <div class="card card-primary">
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
                      <!-- TODO auto-complete -->
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
        <div class="card card-success">
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
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->


      <div class="col-md-4 col-lg-4 col-sm-6 col-6">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form">
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input class="form-control" id="exampleInputEmail1" placeholder="Enter email" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;" autocomplete="off" type="email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input class="form-control" id="exampleInputPassword1" placeholder="Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" autocomplete="off" type="password">
              </div>
              <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input class="custom-file-input" id="exampleInputFile" type="file">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text" id="">Upload</span>
                  </div>
                </div>
              </div>
              <div class="form-check">
                <input class="form-check-input" id="exampleCheck1" type="checkbox">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.card -->

        <!-- Form Element sizes -->
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Different Height</h3>
          </div>
          <div class="card-body">
            <input class="form-control form-control-lg" placeholder=".input-lg" type="text">
            <br>
            <input class="form-control" placeholder="Default input" type="text">
            <br>
            <input class="form-control form-control-sm" placeholder=".input-sm" type="text">
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Different Width</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-3">
                <input class="form-control" placeholder=".col-3" type="text">
              </div>
              <div class="col-4">
                <input class="form-control" placeholder=".col-4" type="text">
              </div>
              <div class="col-5">
                <input class="form-control" placeholder=".col-5" type="text">
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Input addon -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Input Addon</h3>
          </div>
          <div class="card-body">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input class="form-control" placeholder="Username" type="text">
            </div>

            <div class="input-group mb-3">
              <input class="form-control" type="text">
              <div class="input-group-append">
                <span class="input-group-text">.00</span>
              </div>
            </div>

            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">$</span>
              </div>
              <input class="form-control" type="text">
              <div class="input-group-append">
                <span class="input-group-text">.00</span>
              </div>
            </div>

            <h4>With icons</h4>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
              </div>
              <input class="form-control" placeholder="Email" type="email">
            </div>

            <div class="input-group mb-3">
              <input class="form-control" type="text">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-check"></i></span>
              </div>
            </div>

            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fa fa-dollar"></i>
                </span>
              </div>
              <input class="form-control" type="text">
              <div class="input-group-append">
                <div class="input-group-text"><i class="fa fa-ambulance"></i></div>
              </div>
            </div>

            <h5 class="mt-4 mb-2">With checkbox and radio inputs</h5>

            <div class="row">
              <div class="col-lg-6">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <input type="checkbox">
                    </span>
                  </div>
                  <input class="form-control" type="text">
                </div>
                <!-- /input-group -->
              </div>
              <!-- /.col-lg-6 -->
              <div class="col-lg-6">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><input type="radio"></span>
                  </div>
                  <input class="form-control" type="text">
                </div>
                <!-- /input-group -->
              </div>
              <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->

            <h5 class="mt-4 mb-2">With buttons</h5>

            <p>Large: <code>.input-group.input-group-lg</code></p>

            <div class="input-group input-group-lg mb-3">
              <div class="input-group-prepend">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                  Action
                </button>
                <ul class="dropdown-menu">
                  <li class="dropdown-item"><a href="#">Action</a></li>
                  <li class="dropdown-item"><a href="#">Another action</a></li>
                  <li class="dropdown-item"><a href="#">Something else here</a></li>
                  <li class="dropdown-divider"></li>
                  <li class="dropdown-item"><a href="#">Separated link</a></li>
                </ul>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
            <!-- /input-group -->

            <p>Normal</p>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <button type="button" class="btn btn-danger">Action</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
            <!-- /input-group -->

            <p>Small <code>.input-group.input-group-sm</code></p>
            <div class="input-group input-group-sm">
              <input class="form-control" type="text">
              <span class="input-group-append">
                <button type="button" class="btn btn-info btn-flat">Go!</button>
              </span>
            </div>
            <!-- /input-group -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

@stop
