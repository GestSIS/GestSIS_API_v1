<section class="content">
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
      <!-- form start -->
      <form role="form">
        <div class="row">
          <div class="col-sm-6">
            <!-- general form elements -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Données personnelles</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <label for="f-sap-civilite">Civilité</label>
                  <select class="form-control" id="f-sap-civilite" name="civilite_id">
                    @foreach($civilites as $civilite)
                      <option {{ $sap_details['civilite_id'] == $civilite['id'] ? 'selected' : '' }} value="{{ $civilite['id'] }}">{{ $civilite['designation'] }}</option>
                    @endforeach
                  </select>
                </div>
                <!-- NOM -->
                <div class="form-group">
                  <label for="f-sap-nom">Nom</label>
                  <input type="text" class="form-control" id="f-sap-nom" name="nom" value="{{ $sap_details['nom'] }}">
                </div>
                <!-- PRENOM -->
                <div class="form-group">
                  <label for="f-sap-prenom">Prénom</label>
                  <input type="text" class="form-control" id="f-sap-prenom" name="prenom" value="{{ $sap_details['prenom'] }}">
                </div>
                <!-- RUE -->
                <div class="row">
                  <div class="col-8">
                    <div class="form-group">
                      <label for="f-sap-rue">Rue</label>
                      <input type="text" class="form-control" id="f-sap-rue" name="rue" value="{{ $sap_details['rue'] }}">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label for="f-sap-no-rue">N°</label>
                      <input type="text" class="form-control" id="f-sap-no-rue" name="no_rue" value="{{ $sap_details['no_rue'] }}">
                    </div>
                  </div>
                </div>
                <!-- NPA + LOCALITE -->
                <div class="form-group">
                  <label for="f-sap-localite">NPA Localité</label>
                  <select class="required" id="f-sap-localite" name="localite_id" style="width: 100%" data-url="{{ route('api.v1.sis.localities') }}">
                    <option value="{{ $sap_details['localite_id'] }}">{{ $sap_details['npa'].' '.$sap_details['localite'] }}</option>
                  </select>
                </div>
                <!-- N° AVS -->
                <div class="form-group">
                  <label for="f-sap-avs">N° AVS</label>
                  <input type="text" class="form-control" id="f-sap-avs" name="no_avs" value="{{ $sap_details['no_avs'] }}">
                </div>
                <!-- DATE NAISSANCE + SUFFIXE -->
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="f-sap-date-naissance">Date de naissance</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                        <input class="form-control" type="date" id="f-sap-date-naissance" name="date_naissance" value="{{ date('Y-m-d', strtotime($sap_details['date_naissance'])) }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="f-sap-suffixe">Suffixe</label>
                      <input type="text" class="form-control" id="f-sap-suffixe" name="suffixe" value="{{ $sap_details['suffixe'] }}">
                    </div>
                  </div>
                </div>
                <p>Permet de différencier deux personnes ayant le même nom et prénom.</p>
                <!-- REMARQUE -->
                <div class="form-group">
                  <label for="f-sap-remarques">Remarques</label>
                  <textarea class="form-control" rows="3" id="f-sap-remarques" name="remarques">{{ $sap_details['remarques'] }}</textarea>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Contact</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="f-sap-email">Email</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                    <input class="form-control" type="email" id="f-sap-email" name="email" value="{{ $sap_details['email'] }}">
                  </div>
                </div>
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                      <label for="f-sap-tel-prive">Tel priv</label>
                    </div>
                    <div class="form-group">
                      <label for="f-sap-tel-mobile">Smartphone</label>
                    </div>
                    <div class="form-group">
                      <label for="f-sap-tel-prof">Tel Prof</label>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="f-sap-tel-prive" name="tel_prive" value="{{ $sap_details['tel_prive'] }}">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="f-sap-tel-mobile" name="tel_mobile" value="{{ $sap_details['tel_mobile'] }}">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="f-sap-tel-prof" name="tel_prof" value="{{ $sap_details['tel_prof'] }}">
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
                    <label for="f-sap-profession">Profession</label>
                    <input type="text" class="form-control" id="f-sap-profession" name="profession" value="{{ $sap_details['profession'] }}">
                  </div>
                  <div class="form-group">
                    <label for="f-sap-employeur">Employeur</label>
                    <input type="text" class="form-control" id="f-sap-employeur" name="employeur" value="{{ $sap_details['employeur'] }}">
                  </div>
                  <div class="form-group">
                    <label for="f-sap-lieu-travail">Lieu de travail</label>
                    <input type="text" class="form-control" id="f-sap-lieu-travail" name="lieu_travail" value="{{ $sap_details['lieu_travail'] }}">
                  </div>
                  <!-- TODO Add image -->
                </div>
              </form>
            </div>
            <!-- /.card -->

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Incorporation / Sortie</h3>
                <button class="btn btn-primary">Modifier</button> <!-- TODO  -->
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form">
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

            <div class="card card-primary">
              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <div class="tab-pane fade" id="nav-fonction" role="tabpanel" aria-labelledby="nav-fonction-tab">
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-12">
          <!-- general form elements -->
          <div class="card card-primary card-outline">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="sap-fonctions" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Abr</th>
                    <th>Fonction</th>
                    <th>Fin</th>
                    <th>Remarques</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sap_details['fonctions'] as $fonction)
                    <tr id="row_{{ $fonction['id'] }}">
                      <td>{{ date('d.m.Y', strtotime($fonction['date'])) }}</td>
                      <td>{{ $fonction['nom_abr'] }}</td>
                      <td>{{ $fonction['nom'] }}</td>
                      <td>{{ date('d.m.Y', strtotime($fonction['fin'])) }}</td>
                      <td>{{ $fonction['remarque'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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
              <table id="sap-cours" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th data-field="date">Date</th>
                    <th data-field="Abr">Abr</th>
                    <th data-field="designation">Désignation</th>
                    <th data-field="lieu">Lieu</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sap_details['cours'] as $cours)
                    <tr id="row_{{ $cours['id'] }}">
                      <td>{{ date('d.m.Y', strtotime($cours['date'])) }}</td>
                      <td>{{ $cours['nom_abr'] }}</td>
                      <td>{{ $cours['nom'] }}</td>
                      <td>{{ $cours['lieu'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
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
              <table id="sap-promotions" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th data-field="date">Date</th>
                    <th data-field="Abr">Abr</th>
                    <th data-field="designation">Désignation</th>
                    <th data-field="remarques">Remarques</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sap_details['promotions'] as $promotion)
                    <tr id="row_{{ $promotion['id'] }}">
                      <td>{{ date('d.m.Y', strtotime($promotion['date'])) }}</td>
                      <td>{{ $promotion['grade_abr'] }}</td>
                      <td>{{ $promotion['grade'] }}</td>
                      <td>{{ $promotion['remarque'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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
                    <td class="text-right"><img src="{{ asset('img/b.gif') }}"></td>
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
                    <td class="text-right"><img src="{{ asset('img/b1.gif') }}"></td>
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
                    <td class="text-right"><img src="{{ asset('img/c.gif') }}"></td>
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
                    <td class="text-right"><i class="fab fa-gripfire text-danger" style="font-size:1.5em"></i><img src="{{ asset('img/c1.gif') }}"></td>
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
                    <td class="text-right"><img src="{{ asset('img/d.gif') }}"></td>
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
                    <td class="text-right"><img src="{{ asset('img/d1.gif') }}"></td>
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
                    <td class="text-right"><img src="{{ asset('img/be.gif') }}"></td>
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
                    <td class="text-right"><img src="{{ asset('img/ce.gif') }}"></td>
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
                    <td class="text-right"><img src="{{ asset('img/c1e.gif') }}"></td>
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
                    <td class="text-right"><img src="{{ asset('img/de.gif') }}"></td>
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
                    <td class="text-right"><img src="{{ asset('img/d1e.gif') }}"></td>
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
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-12">
          <!-- general form elements -->
          <div class="card card-primary card-outline">
            <!-- /.card-header -->
            <div class="card-header">
              <button class="btn btn-primary">Ajouter un contrôle</button>
              <button class="btn btn-primary">Gérer les médecins</button> <!-- TODO add médecin management via modal -->
            </div>
            <div class="card-body">
              <table data-toggle="table" data-url="http://bootstrap-table.wenzhixin.net.cn/examples/gh/get/response.json/wenzhixin/bootstrap-table/tree/master/docs/data/data1/"
                data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true">
                <thead>
                  <tr>
                  </tr>
                </thead>
              </table>
              <table id="sap-exercices" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th data-field="medecin">Médecin</th>
                    <th data-field="type">Type</th>
                    <th data-field="consultation">Consultation</th>
                    <th data-field="validite">Validité</th>
                    <th data-field="designation">Désignation</th>
                    <th data-field="accepter">Accepter</th>
                    <th data-field="actif">Actif</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sap_details['controles'] as $controle)
                    <tr id="row_{{ $controle['id'] }}">
                      <td>{{ $controle['medecin'] }}</td>
                      <td>{{ $controle['type'] }}</td>
                      <td>{{ date('d.m.Y', strtotime($controle['date_consultation'])) }}</td>
                      <td>{{ date('d.m.Y', strtotime($controle['date_validite'])) }}</td>
                      <td>{{ $controle['designation'] }}</td>
                      <td>{{ $controle['accepte'] }}</td>
                      <td>{{ $controle['encours'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- TODO Fetch data -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-banque" role="tabpanel" aria-labelledby="nav-banque-tab">
      <!-- TODO think about data needed for iso20022 generation -->
    </div>
    <div class="tab-pane fade" id="nav-exercice" role="tabpanel" aria-labelledby="nav-exercice-tab">
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-12">
          <!-- general form elements -->
          <div class="card card-primary card-outline">
            <div class="card-body">
              <table id="sap-exercices" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th data-field="date">Date</th>
                    <th data-field="heure">Heure</th>
                    <th data-field="categorie">Catégorie</th>
                    <th data-field="localite">Localité</th>
                    <th data-field="communication">Communication</th>
                    <th data-field="c">C</th>
                    <th data-field="p">P</th>
                    <th data-field="ex">Ex</th>
                    <th data-field="excuse">Excuse</th>
                    <th data-field="a">A</th>
                    <th data-field="solde">Solde</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sap_details['exercices']['data'] as $exercice)
                    <tr id="row_{{ $exercice['id'] }}">
                      <td>{{ date('d.m.Y', strtotime($exercice['date'])) }}</td>
                      <td>{{ $exercice['heure'] }}</td>
                      <td>{{ $exercice['categorie'] }}</td>
                      <td>{{ $exercice['localite'] }}</td>
                      <td>{{ $exercice['communication'] }}</td>
                      <td>{{ $exercice['convoque'] }}</td>
                      <td>{{ $exercice['present'] }}</td>
                      <td>{{ $exercice['id_type_excuse'] }}</td>
                      <td>{{ $exercice['type_excuse'] }}</td>
                      <td>TODO Absent</td>
                      <td>TODO Solde</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- TODO Fetch data -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
