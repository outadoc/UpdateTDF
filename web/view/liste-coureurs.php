<?php

	/**
	 * Fichier de vue pour l'affichage de la liste des coureurs.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

?>
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1>Liste des coureurs</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-striped sorted">
			<thead>
			<tr>
				<th>#</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Pays</th>
				<th>Année Naissance</th>
				<th>Année 1er TDF</th>
			</tr>
			</thead>
			<tbody>
			<?php

				/** @var $coureurs array */
				foreach ($coureurs as $coureur) {
					echo "<tr>";
					echo '<td><a href="coureur.php?n_coureur=' . $coureur->N_COUREUR . '">' . $coureur->N_COUREUR . "</a></td>";
					echo "<td>" . $coureur->NOM . "</td>";
					echo "<td>" . $coureur->PRENOM . "</td>";
					echo "<td>" . $coureur->PAYS . "</td>";
					echo "<td>" . $coureur->ANNEE_NAISSANCE . "</td>";
					echo "<td>" . $coureur->ANNEE_TDF . "</td>";
					echo "</tr>\n";
				}

			?>
			</tbody>
		</table>
	</div>
</div>