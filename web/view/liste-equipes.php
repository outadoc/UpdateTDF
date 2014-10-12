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
			<h1>Liste des équipes actives</h1>
		</div>
	</div>
</div>
<div class="row">
	<table class="table table-striped table-condensed sortable">
		<thead>
		<tr>
			<!-- n_equipe, annee_creation, n_sponsor, nom, na_sponsor, annee_sponsor, code_tdf -->
			<th class="center">Année création</th>
			<th>Nom du sponsor</th>
			<th class="center">Nom abrégé</th>
			<th class="center">Année du sponsor</th>
			<th>Pays</th>
		</tr>
		</thead>
		<tbody>
		<?php

			/** @var $sponsors array */

			foreach ($sponsors as $sponsor) {
				echo "<tr>";
				echo '<td class="center">' . $sponsor->ANNEE_CREATION . "</td>";
				echo "<td>" . $sponsor->NOM . "</td>";
				echo '<td class="center">' . $sponsor->NA_SPONSOR . "</td>";
				echo '<td class="center">' . $sponsor->ANNEE_SPONSOR . "</td>";
				echo "<td>" . $sponsor->PAYS . "</td>";
				echo "</tr>";
			}

		?>
		</tbody>
	</table>
</div>
<script type="application/javascript">

	$(".delete").click(function () {
		return confirm('Voulez-vous vraiment supprimer cette épreuve ?');
	});

</script>