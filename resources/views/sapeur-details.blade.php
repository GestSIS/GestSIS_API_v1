<section class="content">
  <div class="row">
    <!--<div class="col-md-3 col-lg-3 col-sm-6 col-6">
    </div>-->
    <div class="mb-3">
      <nav class="nav-tabs">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-link active" id="nav-sapeur-tab" data-toggle="tab" href="#nav-sapeur" role="tab" aria-controls="nav-sapeur" aria-selected="true"><i class="fas fa-info"></i> Info</a>
          <a class="nav-link" id="nav-fonction-tab" data-toggle="tab" href="#nav-fonction" role="tab" aria-controls="nav-fonction" aria-selected="false"><i class="fas fa-medal"></i> Fonctions</a>
          <a class="nav-link" id="nav-cours-tab" data-toggle="tab" href="#nav-cours" role="tab" aria-controls="nav-cours" aria-selected="false"><i class="fas fa-book-open"></i> Cours</a>
          <a class="nav-link" id="nav-promotion-tab" data-toggle="tab" href="#nav-promotion" role="tab" aria-controls="nav-promotion" aria-selected="false"><i class="fas fa-award"></i> Promotion</a>
          <a class="nav-link" id="nav-organisation-tab" data-toggle="tab" href="#nav-organisation" role="tab" aria-controls="nav-organisation" aria-selected="false"><i class="fas fa-sitemap"></i> Organisation</a>
          <a class="nav-link" id="nav-materiel-tab" data-toggle="tab" href="#nav-materiel" role="tab" aria-controls="nav-materiel" aria-selected="false"><i class="fas fa-toolbox"></i> Matériel personnel</a>
          <a class="nav-link" id="nav-permis-tab" data-toggle="tab" href="#nav-permis" role="tab" aria-controls="nav-permis" aria-selected="false"><i class="fas fa-car"></i> Permis</a>
          <a class="nav-link" id="nav-medical-tab" data-toggle="tab" href="#nav-medical" role="tab" aria-controls="nav-medical" aria-selected="false"><i class="fas fa-file-medical-alt"></i> Contrôles médicaux</a>
          <a class="nav-link" id="nav-banque-tab" data-toggle="tab" href="#nav-banque" role="tab" aria-controls="nav-banque" aria-selected="false"><i class="fas fa-university"></i> Banque</a>
          <a class="nav-link" id="nav-exercice-tab" data-toggle="tab" href="#nav-exercice" role="tab" aria-controls="nav-exercice" aria-selected="false"><i class="fas fa-calendar-alt"></i> Exercices</a>
        </div>
      </nav>
    </div>
    <!-- /.col -->
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-sapeur" role="tabpanel" aria-labelledby="nav-sapeur-tab">
        <div class="row">
          <div class="col-sm-6">
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
                      @foreach($civilites as $civilite)
                        <option {{ $sap_details['civilite_id'] == $civilite['id'] ? 'selected' : '' }} value="{{ $civilite['id'] }}">{{ $civilite['designation'] }}</option>
                      @endforeach
                    </select>
                  </div>
                  <!-- NOM -->
                  <div class="form-group">
                    <label for="nomInput">Nom</label>
                    <input type="text" class="form-control" value="{{ $sap_details['nom'] }}">
                  </div>
                  <!-- PRENOM -->
                  <div class="form-group">
                    <label for="prenomInput">Prénom</label>
                    <input type="text" class="form-control" value="{{ $sap_details['prenom'] }}">
                  </div>
                  <!-- RUE -->
                  <div class="row">
                    <div class="col-8">
                      <div class="form-group">
                        <label for="rueInput">Rue</label>
                        <input type="text" class="form-control" value="{{ $sap_details['rue'] }}">
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="nInput">N°</label>
                        <input type="text" class="form-control" value="{{ $sap_details['no_rue'] }}">
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
                    <input type="text" class="form-control" value="{{ $sap_details['no_avs'] }}">
                  </div>
                  <!-- DATE NAISSANCE + SUFFIXE -->
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="naissanceInput">Date de naissance</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input class="form-control" type="date" value="{{ date('Y-m-d', strtotime($sap_details['date_naissance'])) }}">
                          <!-- TODO fix this -->
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="suffixeInput">Suffixe</label>
                        <input type="text" class="form-control" value="{{ $sap_details['suffixe'] }}">
                      </div>
                    </div>                      
                  </div>
                  <p>Permet de différencier deux personnes ayant le même nom et prénom.</p>
                  <!-- REMARQUE -->
                  <div class="form-group">
                    <label for="remarqueInput">Remarques</label>
                    <textarea class="form-control" rows="3">{{ $sap_details['remarques'] }}</textarea>
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
                    <input class="form-control" type="email" value="{{ $sap_details['email'] }}">
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
                      <input type="text" class="form-control" value="{{ $sap_details['tel_prive'] }}">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" value="{{ $sap_details['tel_mobile'] }}">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" value="{{ $sap_details['tel_prof'] }}">
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

          <div class="col-sm-6">
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
                    <input type="text" class="form-control" value="{{ $sap_details['profession'] }}">
                  </div>
                  <div class="form-group">
                    <label for="employeurInput">Employeur</label>
                    <input type="text" class="form-control" value="{{ $sap_details['employeur'] }}">
                  </div>
                  <div class="form-group">
                    <label for="lieuTravailInput">Lieu de travail</label>
                    <input type="text" class="form-control" value="{{ $sap_details['lieu_travail'] }}">
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
      </div>
      <div class="tab-pane fade" id="nav-fonction" role="tabpanel" aria-labelledby="nav-fonction-tab">
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
              <!-- /.card-header -->
              <div class="card-body">
                <table data-toggle="table"
                        data-url="http://bootstrap-table.wenzhixin.net.cn/examples/gh/get/response.json/wenzhixin/bootstrap-table/tree/master/docs/data/data1/"
                        data-search="true"
                        data-show-refresh="true"
                        data-show-toggle="true"
                        data-show-columns="true">
                    <thead>
                    <tr>
                      <th data-field="date">Date</th>
                      <th data-field="Abr">Abr</th>
                      <th data-field="fonction">Fonction</th>
                      <th data-field="fin">Fin</th>
                      <th data-field="remarques">Remarques</th>
                    </tr>
                    </thead>
                </table>
                <!-- TODO Fetch data -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-cours" role="tabpanel" aria-labelledby="nav-cours-tab">
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
              <!-- /.card-header -->
              <div class="card-header">
                <button class="btn btn-primary">Ajouter un cours</button>
              </div>
              <div class="card-body">
                <table data-toggle="table"
                        data-url="http://bootstrap-table.wenzhixin.net.cn/examples/gh/get/response.json/wenzhixin/bootstrap-table/tree/master/docs/data/data1/"
                        data-search="true"
                        data-show-refresh="true"
                        data-show-toggle="true"
                        data-show-columns="true">
                    <thead>
                    <tr>
                      <th data-field="date">Date</th>
                      <th data-field="Abr">Abr</th>
                      <th data-field="designation">Désignation</th>
                      <th data-field="lieu">Lieu</th>
                    </tr>
                    </thead>
                </table>
                <!-- TODO Fetch data -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-promotion" role="tabpanel" aria-labelledby="nav-promotion-tab">
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
              <!-- /.card-header -->
              <div class="card-header">
                <button class="btn btn-primary">Ajouter une promotion</button>
              </div>
              <div class="card-body">
                <table data-toggle="table"
                        data-url="http://bootstrap-table.wenzhixin.net.cn/examples/gh/get/response.json/wenzhixin/bootstrap-table/tree/master/docs/data/data1/"
                        data-search="true"
                        data-show-refresh="true"
                        data-show-toggle="true"
                        data-show-columns="true">
                    <thead>
                    <tr>
                      <th data-field="date">Date</th>
                      <th data-field="Abr">Abr</th>
                      <th data-field="designation">Désignation</th>
                      <th data-field="remarques">Remarques</th>
                    </tr>
                    </thead>
                </table>
                <!-- TODO Fetch data -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-organisation" role="tabpanel" aria-labelledby="nav-organisation-tab">
        <div class="row">
          <div class="col-12">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
              <!-- /.card-header -->
              <div class="card-body">
                <table data-toggle="table"
                        data-url="http://bootstrap-table.wenzhixin.net.cn/examples/gh/get/response.json/wenzhixin/bootstrap-table/tree/master/docs/data/data1/"
                        data-search="true"
                        data-show-refresh="true"
                        data-show-toggle="true"
                        data-show-columns="true">
                    <thead>
                    <tr>
                      <th data-field="date">Groupe</th>
                      <th data-field="Abr">Designation</th>
                    </tr>
                    </thead>
                </table>
                <!-- TODO Fetch data -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-materiel" role="tabpanel" aria-labelledby="nav-materiel-tab">
        <!-- TODO more complexe interface -->
      </div>
      <div class="tab-pane fade" id="nav-permis" role="tabpanel" aria-labelledby="nav-permis-tab">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <table class="table">
                  <tbody>
                    <tr>
                      <td class="text-right"><img src="{{ asset('img/a.gif') }}"></td>
                      <td><p>A</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="{{ asset('img/a1.gif') }}"></td>
                      <td><p>A1</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/b.gif"></td>
                      <td><p>B</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/b1.gif"></td>
                      <td><p>B1</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/c.gif"></td>
                      <td><p>C</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><i class="fab fa-gripfire text-danger" style="font-size:1.5em"></i><img src="img/c1.gif"></td>
                      <td><p>C1</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/d.gif"></td>
                      <td><p>D</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/d1.gif"></td>
                      <td><p>D1</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/be.gif"></td>
                      <td><p>BE</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/ce.gif"></td>
                      <td><p>CE</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/c1e.gif"></td>
                      <td><p>C1E</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/de.gif"></td>
                      <td><p>DE</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-right"><img src="img/d1e.gif"></td>
                      <td><p>D1E</p></td>
                      <td>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                          </div>
                          <input type="date" class="form-control">
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-medical" role="tabpanel" aria-labelledby="nav-medical-tab">

      </div>
      <div class="tab-pane fade" id="nav-banque" role="tabpanel" aria-labelledby="nav-banque-tab">

      </div>
      <div class="tab-pane fade" id="nav-exercice" role="tabpanel" aria-labelledby="nav-exercice-tab">

      </div>
    </div>
  </div>
  <!-- /.row -->
</section>