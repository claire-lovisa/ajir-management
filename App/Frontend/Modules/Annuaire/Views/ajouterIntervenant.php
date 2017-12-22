<!-- container -->
	<div class="container">

		<div class="row">

			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="lead col-sm-offset-2">Ajout d'un intervenant</h1>
				</header>

				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">

							<form action="" method="POST">
								<div class="top-margin">
									<label>Prénom <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="prenom" required>
								</div>
                <div class="top-margin">
									<label>Nom <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="nom" required>
								</div>
                <div class="top-margin">
									<label>E-mail <span class="text-danger">*</span></label>
									<input type="email" class="form-control" name="email" required>
								</div>
                <div class="top-margin">
									<label>Département <span class="text-danger">*</span></label>
                  <select class="form-control" name="departement" required>
                   <option value="asi">ASI</option>
                   <option value="cfi">CFI</option>
                   <option value="ep">EP</option>
                   <option value="gc">GC</option>
                   <option value="gm">GM</option>
                   <option value="meca">Meca</option>
                   <option value="mrie">MRIE</option>
                   <option value="stpi">STPI</option>
                  </select>
								</div>
                <div class="top-margin">
									<label>Date de fin d'adhésion <span class="text-danger">*</span></label>
									<input type="date" class="form-control" name="dateFinAdhesion" required>
								</div>
                <div class="top-margin">
									<label>Compétences</label>

                  <?php
									asort($competences);
                  foreach ($competences as $competence)
                  {
                  ?>
									<div class="checkbox">
                    <label><input type="checkbox" name="competences[]" value=<?= strtolower(str_replace(" ","&",$competence)) ?>><?= htmlspecialchars(ucfirst($competence)) ?></label>
                  </div>
                  <?php
                  }
                  ?>
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
