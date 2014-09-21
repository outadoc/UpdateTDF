<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'ajout/édition d'épreuve.
	 * (c) 2014 Baptiste Candellier
	 * Date: 20/09/14
	 * Time: 11:07
	 */

	namespace TDF;

	/** @var $pays array */
	/** @var $title string */

?>
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1>
				<?php echo $title; ?>
			</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<form role="form" method="post"
			<?php echo 'action="form-epreuve.php' . ((isset($key_annee) && isset($key_epreuve)) ? '?annee=' . $key_annee . '&epreuve=' . $key_epreuve : '') . '"'; ?>>
			<?php

				echo FormUtils::getNumberField("n_annee", "Année", 1800, 2999, 1,
					(isset($epreuve) ? $epreuve->ANNEE : Time::getCurrentYear()));

				echo FormUtils::getNumberField("n_epreuve", "N° épreuve", 0, 50, 1,
					(isset($epreuve) ? $epreuve->N_EPREUVE : 0));

				echo FormUtils::getDropdownList("code_tdf_d", "Pays de départ", "CODE_TDF", "NOM", $pays,
					(isset($epreuve) ? $epreuve->CODE_TDF_D : "FRA"));

				echo FormUtils::getTextField("ville_d", "Ville de départ",
					(isset($epreuve) ? $epreuve->VILLE_D : null), true, 40, "TOULON");

				echo FormUtils::getDropdownList("code_tdf_a", "Pays d'arrivée", "CODE_TDF", "NOM", $pays,
					(isset($epreuve) ? $epreuve->CODE_TDF_A : "FRA"));

				echo FormUtils::getTextField("ville_a", "Ville d'arrivée",
					(isset($epreuve) ? $epreuve->VILLE_A : null), true, 40, "PARIS");

				echo FormUtils::getNumberField("distance", "Distance (km)", 0, 500, 0.5,
					(isset($epreuve) ? $epreuve->DISTANCE : 100));

				echo FormUtils::getNumberField("distance", "Moyenne (km)", 0, 100, 0.001,
					(isset($epreuve) ? $epreuve->MOYENNE : 15));

				echo FormUtils::getTextField("jour", "Jour (JJ/MM)",
					(isset($epreuve) ? $epreuve->JOUR : null), true, 40, "JJ/MM");

				echo FormUtils::getDropdownList("cat_code", "Code catégorie",
					"ID", "ID", array(
						//PRO, ETA, CME et CMI
						(object)array("ID" => "PRO"),
						(object)array("ID" => "ETA"),
						(object)array("ID" => "CME"),
						(object)array("ID" => "CMI")
					), (isset($epreuve) ? $epreuve->CAT_CODE : "ETA"));

				echo '<input type="submit" class="btn btn-default">';

			?>
		</form>
	</div>
</div>