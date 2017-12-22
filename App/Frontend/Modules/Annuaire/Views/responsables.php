<h1 class="lead col-sm-offset-2">Annuaire des responsables</h1>

<section class="col-sm-8 table-responsive col-sm-offset-2">
  <table class="table table-bordered table-striped table-condensed">
    <thead>
      <tr>
        <th><a href="/annuaire-responsables1">Prénom</a></th>
        <th><a href="/annuaire-responsables2">Nom</a></th>
        <th><a href="/annuaire-responsables3">Rang</a></th>
        <th><a href="/annuaire-responsables4">Année de mandat</a></th>
        <th><a href="/annuaire-responsables5">Email</a></th>
      </tr>
    </thead>
    <tbody>

<?php
foreach ($listeRespos as $respo)
{
?>
      <tr>
        <td><?= htmlspecialchars(ucfirst($respo->prenom())); ?></td>
        <td><?= htmlspecialchars(ucfirst($respo->nom())); ?></td>
        <td><?= htmlspecialchars(ucfirst(implode(" ",preg_split("/-/", $respo->rang())))); ?></td>
        <td><?= htmlspecialchars($respo->anneeMandat()); ?></td>
        <td><?= htmlspecialchars($respo->email()); ?></td>
      </tr>

<?php
}
?>
    </tbody>
  </table>
</section>

</div>
