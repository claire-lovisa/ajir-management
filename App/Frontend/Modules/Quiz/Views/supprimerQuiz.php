<h1 class="lead col-sm-offset-2">Suppression de quiz</h1>


  <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="panel panel-default">
      <div class="panel-body">
        <form action="" method="POST">
          <div class="row">
            <div class="col-lg-12 text-center">
              <label>Êtes-vous sûr de vouloir supprimer le quiz "<?= htmlentities(ucfirst($quiz->nomQuiz()))?>" ?</label>
            </br>
              <button class="btn btn-default" name="supprimer" type="submit">Supprimer</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
