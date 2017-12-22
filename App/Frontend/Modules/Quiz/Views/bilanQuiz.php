<h1 class="lead col-sm-offset-2">Résultats du quiz suivant : <?=htmlentities(ucfirst($quiz->nomQuiz()))?></h1>

<section class="col-sm-8 table-responsive col-sm-offset-2">
  <div class="list-group">
    <p class="tagline">Vous avez obtenu un score de <?=$nbBonnesReponses?> sur <?=$nbTotalQuestions?>.</p>
  </div>
</section>
