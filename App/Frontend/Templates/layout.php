<!--
  Ce document sert à disposer les éléments "fixes" de chaque page (menu, head ...).
-->

<!DOCTYPE html>
<html lang="fr">
<head>

  <meta http-equiv="content-type" content="text/html" charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author"   content="Claire LOVISA">

  <title> <?= isset($title) ? $title : 'AJIR' ?> </title>
  <link rel="shortcut icon" href="/images/favicon.ico">

  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/font-awesome.min.css">

  <link rel="stylesheet" href="/css/bootstrap-theme.min.css" media="screen" >
  <link rel="stylesheet" href="/css/main.css">
</head>

<?php if (isset($accueil)): ?>
<body class="accueil">
<?php else: ?>
<body>
<?php endif ?>

  <!-- Navigation -->
  <?php if (isset($accueil)): ?>
  <div class="navbar navbar-inverse navbar-fixed-top">
  <?php else: ?>
  <div class="navbar navbar-inverse navbar-fixed-top navbar-other">
  <?php endif ?>
  <div class="container">
    <div class="navbar-header">

      <!-- Toggle Button -->
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- /Toggle Button -->

      <a class="navbar-brand" href="/"><img src="/images/logoBlancPetit.png" alt="Logo AJIR"></a>
    </div>

    <nav class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="/">Accueil</a>
        </li>
        <li><?php if (($user->getAttribute('droits') !== null) AND ($this->app->user()->getAttribute('estValide') == '1') AND $user->getAttribute('droits')>=5): ?>
              <a href="/inscription-admin"> Gestion des inscriptions</a>
            <?php endif ?>
        </li>
        <li class="dropdown"><?php if ($user->isAuthenticated()): ?>
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Annuaires
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
                <a href="/annuaire-responsables"> Annuaire des responsables</a>
            </li>
            <li><?php if (($user->getAttribute('droits') !== null) AND ($this->app->user()->getAttribute('estValide') == '1') AND $user->getAttribute('droits')>=2): ?>
                  <a href="/annuaire-intervenants"> Annuaire des intervenants</a>
                <?php endif ?>
            </li>
          </ul>
          <?php endif ?>
        </li>
        <li class="dropdown"><?php if ($user->isAuthenticated()): ?>
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Quiz
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
                <a href="/quiz"> Jouer</a>
            </li>
            <li><?php if (($user->getAttribute('droits') !== null) AND ($this->app->user()->getAttribute('estValide') == '1') AND $user->getAttribute('droits')>=2): ?>
                  <a href="/ajouter-quiz"> Créer</a>
                <?php endif ?>
            </li>
            <li><?php if (($user->getAttribute('droits') !== null) AND ($this->app->user()->getAttribute('estValide') == '1') AND $user->getAttribute('droits')>=2): ?>
                  <a href="/quiz-update"> Modifier ou supprimer</a>
                <?php endif ?>
            </li>
          </ul>
          <?php endif ?>
        </li>
        <li>
          <?php if (!$user->isAuthenticated()): ?>
          <a href="/inscription"><span class="glyphicon glyphicon-user"></span> S'inscrire</a>
          <?php endif ?>
        </li>
        <li>
          <?php if ($user->isAuthenticated()): ?>
          <a href="/deconnexion"><span class="glyphicon glyphicon-log-out"></span> <?= htmlentities(ucfirst($user->getAttribute('prenom'))) ?> - Se déconnecter</a>
          <?php else: ?>
          <a href="/connexion"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a>
          <?php endif ?>
        </li>
      </ul>
    </nav>
  </div>
  </div>
  <!-- /Navigation -->

    <?php if (isset($accueil)): ?>
    <header id="head">
    	<div class="container">
      	<div class="row">
          <?php if ($user->hasFlash()) echo '<p class="tagline">', $user->getFlash(), '</p>'; ?>
          <?= $content ?>
      	</div>
      </div>
    </header>
    <?php else: ?>
    <header id="head" class="secondary"></header>
    <div class="container">
      <div class="row">
        <?php if ($user->hasFlash()) echo '<p class="tagline">', $user->getFlash(), '</p>'; ?>
        <?= $content ?>
    	</div>
  	</div>
    <?php endif ?>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

</body>

</html>
