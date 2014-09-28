<?php

	/**
	 * Fichier de vue pour l'affichage des détails d'un coureur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	/** @var $n_coureur integer */
	/** @var $coureur object */
	/** @var $participations array */

?>
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1>Détails du coureur
				<small><?php echo htmlspecialchars($coureur->PRENOM . " " . $coureur->NOM); ?> </small>
			</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="glyphicon glyphicon-user"></span>
					&nbsp;Fiche d'identité
					<a href="form-coureur.php?n_coureur=<?php echo $n_coureur ?>"
					   class="pull-right">Modifier</a>
				</h3>

			</div>
			<div class="panel-body">
				<ul>
					<?php

						echo "<li><strong>Nom :</strong> " . htmlspecialchars($coureur->NOM) . "</li>";
						echo "<li><strong>Prénom :</strong> " . htmlspecialchars($coureur->PRENOM) . "</li>";
						echo "<li><strong>Pays :</strong> " . htmlspecialchars($coureur->PAYS) . "</li>";
						echo "<li><strong>Année de naissance :</strong> "
							. htmlspecialchars($coureur->ANNEE_NAISSANCE) . "</li>";
						echo "<li><strong>Année de 1er Tour de France :</strong> "
							. htmlspecialchars($coureur->ANNEE_TDF) . "</li>";

					?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="glyphicon glyphicon-bullhorn"></span>
					&nbsp;Participations
				</h3>

			</div>
			<table class="table table-striped">
				<thead>
				<tr>
					<th class="center">Année</th>
					<th class="center">Dossard #</th>
					<th class="center">Jeune</th>
					<th>Sponsor</th>
				</tr>
				</thead>
				<tbody>
				<?php

					foreach ($participations as $participation) {
						if ($participation->VALIDE == 'O') {
							echo '<tr>';
						} else {
							echo '<tr class="strike">';
						}

						echo '<td class="center">' . $participation->ANNEE . '</td>';
						echo '<td class="center">' . $participation->N_DOSSARD . '</td>';
						echo '<td class="center">' . (($participation->JEUNE == 'o') ? "Oui" : "Non") . '</td>';
						echo '<td>' . $participation->NOM . '</td>';
						echo '</tr>';
					}

				?>
				</tbody>
			</table>
		</div>
	</div>
</div>