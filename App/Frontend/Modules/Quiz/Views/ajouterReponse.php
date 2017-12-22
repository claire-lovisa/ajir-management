<!-- container -->
	<div class="container">

		<div class="row">

			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="lead col-sm-offset-2"><?= ucfirst($nomQuestion) ?> : Ajouter une réponse</h1>
          <p class="tagline col-sm-offset-2">
            Coche la bonne réponse !
          </p>
				</header>

				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">

							<form action="" method="POST">
								<div class="top-margin">
                  <label class="radio-inline"><input type="radio" name="repCorrecte" value="1">Première réponse <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="reponse1" required>
                  <label class="radio-inline"><input type="radio" name="repCorrecte" value="2">Deuxième réponse <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="reponse2" required>
                  <label class="radio-inline"><input type="radio" name="repCorrecte" value="3">Troisième réponse <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="reponse3" required>
                  <label class="radio-inline"><input type="radio" name="repCorrecte" value="4">Quatrième réponse <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="reponse4" required>
								</div>

								<hr>

								<div class="row">
									<div class="col-lg-12 text-right">
										<button class="btn btn-action" type="submit">Ajouter</button>
									</div>
								</div>
							</form>
						</div>
					</div>

				</div>

			</article>
			<!-- /Article -->

			</div>
		</div>
		<!-- /container -->
