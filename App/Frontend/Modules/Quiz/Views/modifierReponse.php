<section class="col-sm-8 table-responsive col-sm-offset-2">


    <div class="panel panel-default">
      <div class="panel-body">
        <form action="" method="POST">
          <div class="row">
            <div class="col-lg-12 text-left">
              <label>Modifier l'intitulé de la réponse : "<?= htmlentities(ucfirst($reponse->nomReponse()))?>" ?</label>
              <input type="text" name="nouveauNomReponse">

              <button class="btn btn-default pull-right" name="modifierNomReponse" type="submit">Modifier</button>
            </div>
          </div>
        </form>
      </div>
    </div>

</section>
