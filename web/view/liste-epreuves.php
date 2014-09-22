<?php

	/**
	 * Fichier de vue pour l'affichage de la liste des épreuves.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

?>
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1>Liste des épreuves</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-striped sorted">
			<thead>
			<tr>
				<th>Année</th>
				<th>Numéro</th>
				<th>Pays de départ</th>
				<th>Ville de départ</th>
				<th>Pays d'arrivée</th>
				<th>Ville d'arrivée</th>
				<th>Distance</th>
				<th>Moyenne</th>
				<th>Date</th>
				<th>Catégorie</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			<?php

				/** @var $epreuves array */

				foreach ($epreuves as $epreuve) {
					echo "<tr>";
					echo '<td class="center">' . $epreuve->ANNEE . "</td>";
					echo '<td class="center">' . $epreuve->N_EPREUVE . "</td>";
					echo "<td>" . $epreuve->CODE_TDF_D . "</td>";
					echo "<td>" . $epreuve->VILLE_D . "</td>";
					echo "<td>" . $epreuve->CODE_TDF_A . "</td>";
					echo "<td>" . $epreuve->VILLE_A . "</td>";
					echo "<td>" . $epreuve->DISTANCE . "</td>";
					echo "<td>" . $epreuve->MOYENNE . "</td>";
					echo "<td>" . $epreuve->JOUR . "</td>";
					echo '<td class="center">' . $epreuve->CAT_CODE . '</td>';
					echo '<td class="center"><a href="form-epreuve.php?annee=' . $epreuve->ANNEE . '&epreuve=' . $epreuve->N_EPREUVE . '"><span class="glyphicon glyphicon-edit"></span></a>';
					echo "</tr>\n";
				}

			?>
			</tbody>
		</table>
	</div>
</div>