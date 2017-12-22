<h1 class="lead col-sm-offset-2">Annuaire des intervenants</h1>

<?php if ($user->isAuthenticated() AND ($user->getAttribute('estValide') == '1') AND ($user->getAttribute('droits') !== null) AND $user->getAttribute('droits')>=4): ?>
<section class="col-sm-8 table-responsive col-sm-offset-2">
  <a href="/ajouter-intervenant" class="btn btn-link" role="button">Ajouter un intervenant</a>
  <a href="supprimer-intervenant" class="btn btn-link" role="button">Supprimer un intervenant</a>
  <a href="ajouter-competence" class="btn btn-link" role="button">Ajouter une compétence</a>
  <a href="supprimer-competence" class="btn btn-link" role="button">Supprimer une compétence</a>
</section>
<?php endif ?>

<section class="col-sm-8 table-responsive col-sm-offset-2">
<div class="panel panel-default">
  <div class="panel-body">
    <form action="" method="POST">
      <div class="row">
        <div class="col-lg-12 text-left">
          <label>Compétence(s) recherchée(s) : </label>

          <?php
            asort($toutesLesCompetences);
            foreach ($toutesLesCompetences as $competence){ ?>
              <label class="checkbox-inline">
                <input type="checkbox" name="competencesCherchees[]" value="<?=$competence?>" /><?= htmlspecialchars(ucfirst(str_replace("&"," ",$competence))) ?>
              </label>
            <?php } ?>

          <button class="btn btn-default pull-right" name="recherche" type="submit">Rechercher</button>
        </div>
      </div>
    </form>
  </div>
</div>
</section>

<section class="col-sm-8 table-responsive col-sm-offset-2">
  <table class="table table-bordered table-striped table-condensed">
    <thead>
      <tr>
        <th><a href="/annuaire-intervenants1">Prénom</a></th>
        <th><a href="/annuaire-intervenants2">Nom</a></th>
        <th><a href="/annuaire-intervenants3">Département</a></th>
        <th><a href="/annuaire-intervenants4">Compétences</a></th>
        <th><a href="/annuaire-intervenants5">Email</a></th>
        <th><a href="/annuaire-intervenants6">Statut adhésion</a></th>
      </tr>
    </thead>
    <tbody>

<?php
foreach ($listeIntervenants as $intervenant)
{
  // Si on ne recherche pas une compétence spécifique
  if(!isset($competencesCherchees)) {
    ?>
          <tr>
            <td><?= htmlspecialchars(ucfirst($intervenant->prenom())); ?></td>
            <td><?= htmlspecialchars(ucfirst($intervenant->nom())); ?></td>
            <td><?= htmlspecialchars(ucfirst(implode(" ",preg_split("/-/", $intervenant->departement())))); ?></td>
            <td><?php
              $competences = $intervenant->competences();
              $nbCompetences = count($competences);
              $i = 1;

              foreach ($competences as $competence){
                if($nbCompetences>$i) { ?>
                  <?= htmlspecialchars(ucfirst(str_replace("&"," ",$competence)))."," ?>
                <?php
                  $i = $i+1;
                } else { ?>
                  <?= htmlspecialchars(ucfirst(str_replace("&"," ",$competence))) ?>
                <?php }?>
              <?php } ?></td>
            <td><?= htmlspecialchars($intervenant->email()); ?></td>
            <td><?= ($intervenant->dateFinAdhesion() > date("Y-m-d")) ? "En cours" : "Terminée"  ?></td>
          </tr>

    <?php
    }
    // Si on recherche une compétence spécifique, ou plusieurs
    else {
      $competencesSontDansIntervenant = 1;
      $competences = $intervenant->competences();
      // Si une compétence recherchée n'est pas dans l'intervenant, alors $competencesSontDansIntervenant
      // prend la valeur 0 et on n'affiche pas cet intervenant
      foreach($competencesCherchees as $competenceCherchee) {
        if(!in_array($competenceCherchee,$competences)) {
          $competencesSontDansIntervenant = 0;
        }
      }
      if($competencesSontDansIntervenant == 1) {
        ?>
          <tr>
            <td><?= htmlspecialchars(ucfirst($intervenant->prenom())); ?></td>
            <td><?= htmlspecialchars(ucfirst($intervenant->nom())); ?></td>
            <td><?= htmlspecialchars(ucfirst(implode(" ",preg_split("/-/", $intervenant->departement())))); ?></td>
            <td><?php
              $nbCompetences = count($competences);
              $i = 1;
              foreach ($competences as $competence){
                if($nbCompetences>$i) { ?>
                  <?= htmlspecialchars(ucfirst(str_replace("&"," ",$competence)))."," ?>
                <?php
                  $i = $i+1;
                } else { ?>
                  <?= htmlspecialchars(ucfirst(str_replace("&"," ",$competence))) ?>
                <?php }?>
              <?php } ?></td>
            <td><?= htmlspecialchars($intervenant->email()); ?></td>
            <td><?= ($intervenant->dateFinAdhesion() > date("Y-m-d")) ? "En cours" : "Terminée"  ?></td>
          </tr>
    <?php
      }
    }
  }
  ?>
    </tbody>
  </table>
</section>
