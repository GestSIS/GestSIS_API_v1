
<div id="modal-cours" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form">
        <div class="card-header">
          <h3>Paramètres pour la saisie d'un cours</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="cours-name">Cours</label>
            <select id="cours-name" class="form-control">
              <option>Commandant</option>
              <option>Chef d'intervention 1</option>
              <option>Chef d'intervention 2</option>
              <option>Chef de groupe</option>
              <option>Fourrier</option>
              <!-- TODO Lister les cours -->
            </select>
          </div>
          <div class="form-group">
            <label for="cours-date">Date du cours</label>
            <input type="date" class="form-control" id="cours-date">
          </div>
          <div class="form-group">
            <label for="cours-localite">Cours</label>
            <select id="cours-localite" class="form-control">
              <option>Saulcy</option>
              <option>Glovelier</option>
              <option>Bassecourt</option>
              <option>Courfaivre</option>
              <option>Boécourt</option>
              <!-- TODO Lister les localités -->
            </select>
          </div>
          <div class="form-group">
            <label for="cours-precedent">Cours précédent</label>
            <select id="cours-precedent" class="form-control" disabled>
              <option>Commandant</option>
              <option>Chef d'intervention 1</option>
              <option>Chef d'intervention 2</option>
              <option>Chef de groupe</option>
              <option>Fourrier</option>
              <!-- TODO Lister les cours -->
            </select>
          </div>
          <div class="form-group">
            <label>Grade</label>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <select class="form-control select" data-placeholder="Select a State" tabindex="-1">
                  <option>Major</option>
                  <option>Soldat</option>
                  <option>Appointé</option>
                  <option>Lieutenant-Colonel</option>
                  <option>Fourrier</option>
                  <option>Sergent Major</option>
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
              <div class="form-group">
                <input type="date" class="form-control">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <div class="form-group">
            <label>Fonction</label>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <select class="form-control" disabled>
                  <option>Fourrier</option>
                  <option>Electricien</option>
                  <option>Sapeur</option>
                  <option>Responsable Matériel</option>
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
              <div class="form-group">
                <input type="date" class="form-control">
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <div class="form-group">
            <label>Fonction remplacé</label>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <select class="form-control" disabled>
                  <option>Fourrier</option>
                  <option>Electricien</option>
                  <option>Sapeur</option>
                  <option>Responsable Matériel</option>
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Sauvegarder</button>
          <button type="submit" class="btn btn-secondary">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</div>
