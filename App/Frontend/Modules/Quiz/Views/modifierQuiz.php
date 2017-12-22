<section class="col-sm-8 table-responsive col-sm-offset-2">


    <div class="panel panel-default">
      <div class="panel-body">
        <form action="" method="POST">
          <div class="row">
            <div class="col-lg-12 text-left">
              <label>Modifier le nom du quiz : "<?= htmlentities(ucfirst($quiz->nomQuiz()))?>" ?</label>
              <input type="text" name="nouveauNomQuiz">

              <button class="btn btn-default pull-right" name="modifierNomQuiz" type="submit">Modifier</button>
            </div>
          </div>
        </form>
      </div>
    </div>



  <p> Sélectionnez une question à modifier ou supprimer : </p>
  <div class="list-group">
    <?php
    foreach ($listeQuestions as $question)
    {
        $lienModif = "/modifier-question".$question->idQuestion();
        $lienSuppr = "/supprimer-question".$question->idQuestion();
    ?>
        <li class="list-group-item">
          <?= htmlspecialchars(ucfirst($question->nomQuestion())); ?>

          <div class="btn-group pull-right">
            <a href=<?=$lienModif?> class="btn btn-action">Modifier</a>
            <a href=<?=$lienSuppr?> class="btn btn-action">Supprimer</a>
          </div>

        </li>
    <?php
    }
    ?>

    <div class="col-lg-12 text-right">
      <a href="/ajouter-question<?= $quiz->idQuiz() ?>" class="btn btn-default">Ajouter une question</a>
    </div>

  </div>
</section>
