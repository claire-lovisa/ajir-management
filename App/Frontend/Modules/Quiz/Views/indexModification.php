<h1 class="lead col-sm-offset-2">Sélectionnez le quiz à modifier ou supprimer</h1>

<section class="col-sm-8 table-responsive col-sm-offset-2">
  <div class="list-group">
    <?php
    asort($listeQuiz);
    foreach ($listeQuiz as $quiz)
    {
        $lienModif = "/modifier-quiz".$quiz->idQuiz();
        $lienSuppr = "/supprimer-quiz".$quiz->idQuiz();
    ?>
        <li class="list-group-item">
          <?= htmlspecialchars(ucfirst($quiz->nomQuiz())); ?>

          <div class="btn-group pull-right">
            <a href=<?=$lienModif?> class="btn btn-action">Modifier</a>
            <a href=<?=$lienSuppr?> class="btn btn-action">Supprimer</a>
          </div>

        </li>
    <?php
    }
    ?>
  </div>
</section>
