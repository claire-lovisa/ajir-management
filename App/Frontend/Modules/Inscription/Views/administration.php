<h1 class="lead col-sm-offset-2">Gestion des nouveaux inscrits</h1>
<p class="tagline col-sm-offset-2">Pour rappel, les droits correspondent aux rangs suivants :
  <ul class="col-sm-offset-2">
    <li> 1 : Membre actif </li>
    <li> 2 : Trésorier, vice-trésorier, comptable, responsable communication </li>
    <li> 3 : Président, vide-président, responsable études, responsable développement commercial </li>
    <li> 4 : Secrétaire général, directeur des ressources humaines </li>
    <li> 5 : DSI </li>
  </ul>
</p>

<section class="col-sm-8 table-responsive col-sm-offset-2">
  <table class="table table-bordered table-striped table-condensed">
    <thead>
      <tr>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Droits demandés</th>
      </tr>
    </thead>
    <tbody>

<?php
foreach ($utilisateursNonValides as $utilisateurNonValides)
{
  echo '<form action="" method="POST">';
?>
      <input type="hidden" name="idUtilisateurAValider" value="<?=$utilisateurNonValides->idUtilisateur()?>">
      <tr>
        <td><?= htmlspecialchars(ucfirst($utilisateurNonValides->prenom())); ?></td>
        <td><?= htmlspecialchars(ucfirst($utilisateurNonValides->nom())); ?></td>
        <td><?= htmlspecialchars($utilisateurNonValides->email()); ?></td>
        <td><?= htmlspecialchars($utilisateurNonValides->droits());  ?></td>
        <td><button class="btn btn-action" name="ok" type="submit" ?>Valider</button></td>
        <td><button class="btn btn-action" name="ko" type="submit" ?>Refuser</button></td>
      </tr>

<?php
  echo '</form>';
}
?>
    </tbody>
  </table>
</section>
