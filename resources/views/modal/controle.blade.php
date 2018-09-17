<div id="modal-controle" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form">
        <div class="card-header">
          <h3>Paramètres pour la saisie d'un contrôle médical</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="controle-sapeur">Sapeur</label>
            <input type="text" disabled class="form-control" id="controle-sapeur">
            <!-- TODO AJOUTER Nom du sapeur + age -->
          </div>
          <div class="form-group">
            <label for="controle-medecin">Médecin</label>
            <select id="controle-medecin" class="form-control">
              <option>Patrick Voirol</option>
              <option>Dominique Beleer</option>
              <option>Christophe Donzé</option>
              <!-- TODO Lister les médecins -->
            </select>
          </div>
          <div class="form-group">
            <label for="controle-type">Type</label>
            <select id="controle-type" class="form-control">
              <option>Contrôle PAR</option>
              <option>Contrôle C1</option>
              <option>Vaccin</option>
              <!-- TODO Lister les types de controles médicaux -->
            </select>
          </div>
          <div class="form-group">
            <label>Status</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="accepte">
              <label class="form-check-label">Accepté</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="actif">
              <label class="form-check-label">Actif</label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="controle-date-consultation">Date de consultation</label>
                <input type="date" class="form-control" id="controle-date-consultation">
              </div>
              <div class="form-group">
                <label for="controle-date-validite">Date de validité</label>
                <input type="date" class="form-control" id="controle-date-validite">
              </div>
            </div>
            <div class="col-md-6">
              <div class="btn-group" style="top: 55%;transform: translateY(-55%);">
                <button type="button" class="btn btn-default">+2 ans</button>
                <button type="button" class="btn btn-default">+3 ans</button>
                <button type="button" class="btn btn-default">+5 ans</button>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="controle-remarque">Remarques</label>
            <input type="text" class="form-control" id="controle-remarque">
          </div>
          <!-- TODO Ajout de la zone pour déposer des documents -->
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Ajouter</button>
          <button type="submit" class="btn btn-secondary">Annuler</button>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-medecin">Gérer les médecins</button>
        </div>
      </form>
    </div>
  </div>
</div>
