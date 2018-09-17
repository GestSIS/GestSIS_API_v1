
<div id="modal-promotion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form">
        <div class="card-header">
          <h3>Paramètres pour la saisie d'une promotion</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="promotion-name">Grade</label>
            <select id="promotion-name" class="form-control">
              <option>Major</option>
              <option>Capitaine</option>
              <option>Lieutenant</option>
              <option>Sergent</option>
              <option>Fourrier</option>
              <!-- TODO Lister les grades -->
            </select>
          </div>
          <div class="form-group">
            <label for="promotion-date">Date de la promotion</label>
            <input type="date" class="form-control" id="promotion-date">
          </div>
          <div class="form-group">
            <label for="promotion-remarque"></label>
            <input type="textarea" class="form-control" id="promotion-remarque">
          </div>
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
