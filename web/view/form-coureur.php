<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'édition/ajout de coureur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

	if (isset($_GET['error'])) {
		echo AlertBanner::getGenericErrorMessage("Erreur !", "Suppression du coureur impossible (il a probablement des participations).");
	}

	if (isset($error)) {
		die(AlertBanner::getGenericErrorMessage("Oups !", $error));
	}

?>
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1>
				<?php
					/** @var $title string */
					echo $title;
				?>
			</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<form role="form" method="post"
			<?php echo 'action="form-coureur.php' . (isset($n_coureur) ? '?n_coureur=' . $n_coureur : '') . '"'; ?>>
			<?php

				echo FormUtils::getTextField("prenom", "Prénom",
					(isset($coureur) ? $coureur->PRENOM : ""), true, 20);
				echo FormUtils::getTextField("nom", "Nom",
					(isset($coureur) ? $coureur->NOM : ""), true, 30);

				echo FormUtils::getNumberField("annee_naissance", "Année de naissance", 1800, 2999, 1,
					(isset($coureur) ? $coureur->ANNEE_NAISSANCE : 1955));
				echo FormUtils::getNumberField("annee_tdf", "Année du 1er TDF", 1903, 2999, 1,
					(isset($coureur) ? $coureur->ANNEE_TDF : Time::getCurrentYear()));

				echo FormUtils::getDropdownList("code_tdf", "Pays", "CODE_TDF", "NOM",
					$pays, (isset($coureur)) ? $coureur->CODE_TDF : 'FRA');

				echo '<input type="submit" class="btn btn-default">';

				if ($n_coureur !== null) {
					echo '<a class="btn btn-danger" id="delete" href="delete-coureur.php?n_coureur=' . $n_coureur . '">Supprimer</a>';
				}

			?>

		</form>
	</div>
</div>
<script type="application/javascript">

	var annee_naissance = $("input[name=annee_naissance]"),
		annee_tdf = $("input[name=annee_tdf]");

	annee_naissance.change(function (e) {
		//si l'année du premier TDF est inférieure à l'année de naissance,
		//on met les deux égaux
		if (annee_tdf.val() < annee_naissance.val()) {
			annee_tdf.val(annee_naissance.val());
		}
	});

	annee_tdf.change(function (e) {
		//si l'année de naissance est supérieure à l'année du premier TDF,
		//on met les deux égaux
		if (annee_naissance.val() > annee_tdf.val()) {
			annee_naissance.val(annee_tdf.val());
		}
	});

	<?php

		if(isset($coureur)) {
			echo
				'$("#delete").click(function () {
					return confirm(\'Voulez-vous vraiment supprimer le coureur ' . $coureur->PRENOM . ' ' . $coureur->NOM . ' ?\');
				});';
		}
	?>

</script>