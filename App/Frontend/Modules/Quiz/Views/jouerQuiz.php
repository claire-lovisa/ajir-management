<!-- container -->
	<div class="container">

		<div class="row">

			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="lead col-sm-offset-2"><?=htmlentities(ucfirst($quiz->nomQuiz()))?></h1>
				</header>

				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">

							<form action="" method="POST">
								<div class="top-margin">
									<p class="tagline"><?=htmlentities(ucfirst($question->nomQuestion()))?></p>
								</div>

								<hr>

								<div class="row">
                  <!-- Petit foreach des familles pour affichier les boutons en fonction de $listeReponses -->
                  <!-- On va faire un submit pour traiter l'affichage en php, parce que relou en JS -->
                  <!-- Utiliser une image comme bouton ? :) -->
                  <?php
                  $i=-1;
                  foreach ($listeReponses as $reponse)
                  {
                    $i = $i + 1;
                  ?>

                  <div class="col-lg-6">
										<button class="btn btn-action" name="bouton<?=$i?>" type="submit" style="width:100%"<?php if(isset($bonneReponse)){echo 'disabled';} ?>><?=htmlentities(ucfirst($reponse->nomReponse()));?></button>
									</div>

                  <?php
                    if($reponse->estCorrecte()==1) {
                      $nomBonneReponse = $reponse->nomReponse();
                    }
                  }
                  ?>

								</div>
							</form>

              <?php
              if(isset($bonneReponse)) {
                if($bonneReponse == '1') {
                  $lienSuivant = 'jouer-quiz'.$quiz->idQuiz().'~'.($nbBonnesReponses+1).'~'.($numQuestion+1);
                  $lienTerminer = 'bilan-quiz'.$quiz->idQuiz().'~'.($nbBonnesReponses+1).'~'.($numQuestion+1);
                }
                else {
                  $lienSuivant = 'jouer-quiz'.$quiz->idQuiz().'~'.($nbBonnesReponses).'~'.($numQuestion+1);
                  $lienTerminer = 'bilan-quiz'.$quiz->idQuiz().'~'.($nbBonnesReponses).'~'.($numQuestion+1);
                }
              }
              ?>

              <!-- TERMINER REDIRIGE SUR UNE PAGE POUR LE SCORE -->
              <div class="col-lg-6 pull-right">

                <?php if ($numQuestion == $nbTotalQuestions-1): ?>
                  <a href="<?=$lienTerminer?>" class="btn btn-default" name="terminer" <?php if(!isset($bonneReponse)){echo 'disabled';} ?>>Terminer</a>
                <?php else: ?>
                  <a href="<?=$lienSuivant?>" class="btn btn-default" name="suivant" <?php if(!isset($bonneReponse)){echo 'disabled';} ?>>Suivant</a>
                <?php endif ?>

              </div>


						</div>
					</div>


          <?php
          if(isset($bonneReponse)) {
            if($bonneReponse == '1') {
              echo 'Bravo, c\'est une bonne réponse !';
            }
            else {
              echo 'Dommage, ce n\'est pas la bonne réponse ! C\'était "'.htmlentities(ucfirst($nomBonneReponse)).'"';
            }
          }

          ?>
				</div>

			</article>
			<!-- /Article -->

			</div>
		</div>
		<!-- /container -->
