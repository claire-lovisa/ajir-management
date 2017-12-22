<section class="col-sm-8 table-responsive col-sm-offset-2">


    <div class="panel panel-default">
      <div class="panel-body">
        <form action="" method="POST">
          <div class="row">
            <div class="col-lg-12 text-left">
              <label>Modifier l'intitulé de la question : "<?= htmlentities(ucfirst($question->nomQuestion()))?>" ?</label>
              <input type="text" name="nouveauNomQuestion">

              <button class="btn btn-default pull-right" name="modifierNomQuestion" type="submit">Modifier</button>
            </div>
          </div>
        </form>
      </div>
    </div>



  <p> Sélectionnez une réponse à modifier : </p>
  <div class="list-group">
    <?php
    $i=0;
    foreach ($listeReponses as $reponse)
    {
        $i = $i+1;
        $lienModif = "/modifier-reponse".$reponse->idReponse();
        $lienSuppr = "/supprimer-reponse".$reponse->idReponse();
    ?>
        <li class="list-group-item">
          <?= htmlspecialchars(ucfirst($reponse->nomReponse())); ?> <?php if($reponse->estCorrecte()) {echo '(réponse correcte)';}  ?>
          <div class="btn-group pull-right">
            <a href=<?=$lienModif?> class="btn btn-action">Modifier</a>
          </div>

        </li>
    <?php
    }
    ?>

  </div>
</section>
