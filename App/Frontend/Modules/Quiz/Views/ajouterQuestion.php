<!-- container -->
	<div class="container">

		<div class="row">

			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="lead col-sm-offset-2"><?= ucfirst($nomQuiz) ?> : Ajouter une question</h1>
				</header>

				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">

							<form action="" method="POST">
								<div class="top-margin">
									<label>Nom de la question <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="nomQuestion" required>
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
