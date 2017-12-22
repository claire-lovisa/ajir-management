<!-- container -->
	<div class="container">

		<div class="row">

			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="page-title">Inscription</h1>
				</header>

				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="thin text-center">Création d'un nouveau compte</h3>
							<p class="text-center text-muted">Si vous êtes déjà inscrit, <a href="/connexion">connectez-vous</a> pour pouvoir accéder au contenu proposé. </p>
							<hr>

							<form action="" method="post">
								<div class="row top-margin">
									<div class="col-sm-6">
										<label>Prénom <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="prenom" required>
									</div>
									<div class="col-sm-6">
										<label>Nom <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="nom" required>
									</div>
								</div>

								<div class="row top-margin">
									<div class="col-sm-6">
										<label>E-mail <span class="text-danger">*</span></label>
										<input type="email" class="form-control" name="email" required>
									</div>
									<div class="col-sm-6">
										<label>Poste occupé <span class="text-danger">*</span></label>
										<select class="form-control" name="rang" required>
										 <option value="président">Président</option>
										 <option value="vice-président">Vice-président</option>
										 <option value="trésorier">Trésorier</option>
										 <option value="vice-trésorier">Vice-trésorier</option>
										 <option value="comptable">Comptable</option>
										 <option value="secrétaire-général">Secrétaire général</option>
										 <option value="directeur-des-ressources-humaines">Directeur des ressources humaines</option>
										 <option value="responsable-qualité">Responsable qualité</option>
										 <option value="responsable-études">Responsable des études</option>
										 <option value="responsable-développement-commercial">Responsable du développement commercial</option>
										 <option value="responsable-communication">Responsable communication</option>
										 <option value="directeur-des-systèmes-d'information">Directeur des systèmes d'information</option>
										 <option value="membre-actif">Membre actif</option>
										</select>
									</div>
								</div>

								<div class="row top-margin">
									<div class="col-sm-12">
										<label>Mot de passe <span class="text-danger">*</span></label>
										<input type="password" class="form-control" name="mdp" required>
									</div>
								</div>

								<div class="row top-margin">
									<div class="col-sm-12">
										<label>Confirmation du mot de passe <span class="text-danger">*</span></label>
										<input type="password" class="form-control" name="verifMdp" required>
									</div>
								</div>

								<hr>

								<div class="row">
									<div class="col-lg-4 text-right col-lg-offset-8">
										<button class="btn btn-action" type="submit">S'incrire</button>
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
