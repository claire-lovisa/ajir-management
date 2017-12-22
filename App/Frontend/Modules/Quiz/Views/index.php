<h1 class="lead col-sm-offset-2">Liste des quiz</h1>

<section class="col-sm-8 table-responsive col-sm-offset-2">
  <div class="list-group">
    <?php
    asort($listeQuiz);
    foreach ($listeQuiz as $quiz)
    {
        $lien = "/jouer-quiz".$quiz->idQuiz()."~0~0";
    ?>
      <li class="list-group-item">
        <span><?=htmlspecialchars(ucfirst($quiz->nomQuiz()))?></span>
        <a href=<?=$lien?> class="icon"><span class="glyphicon glyphicon-play-circle pull-right"></span></a>
      </li>
    <?php
    }
    ?>
  </div>
</section>
