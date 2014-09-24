<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'ajout/édition d'épreuve.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

	/** @var $pays array */
	/** @var $annees array */
	/** @var $title string */
	/** @var $maxAnnee integer */

	/** @var $data_annee integer */
	/** @var $data_n_epreuve integer */
	/** @var $data_code_tdf_d string */
	/** @var $data_code_tdf_a string */
	/** @var $data_ville_d string */
	/** @var $data_ville_a string */
	/** @var $data_distance float */
	/** @var $data_moyenne float */
	/** @var $data_jour string */
	/** @var $data_cat_code string */

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
			<?php echo 'action="form-epreuve.php' . ((isset($key_annee) && isset($key_n_epreuve)) ? '?annee=' . $key_annee . '&epreuve=' . $key_n_epreuve : '') . '"'; ?>>
			<?php

				echo FormUtils::getDropdownList("n_annee", "Année", "ANNEE", "ANNEE", $annees,
					(isset($epreuve) ? $epreuve->ANNEE : $data_annee), null);

				echo FormUtils::getNumberField("n_epreuve", "N° épreuve", 0, 50, 1,
					(isset($epreuve) ? $epreuve->N_EPREUVE : $data_n_epreuve), 0);

				echo FormUtils::getDropdownList("code_tdf_d", "Pays de départ", "CODE_TDF", "NOM", $pays,
					(isset($epreuve) ? $epreuve->CODE_TDF_D : $data_code_tdf_d), "FRA");

				echo FormUtils::getTextField("ville_d", "Ville de départ",
					(isset($epreuve) ? $epreuve->VILLE_D : $data_ville_d), null, true, 40, "TOULON");

				echo FormUtils::getDropdownList("code_tdf_a", "Pays d'arrivée", "CODE_TDF", "NOM", $pays,
					(isset($epreuve) ? $epreuve->CODE_TDF_A : $data_code_tdf_a), "FRA");

				echo FormUtils::getTextField("ville_a", "Ville d'arrivée",
					(isset($epreuve) ? $epreuve->VILLE_A : $data_ville_a), null, true, 40, "PARIS");

				echo FormUtils::getNumberField("distance", "Distance (km)", 0, 500, 0.5,
					(isset($epreuve) ? $epreuve->DISTANCE : $data_distance), 100);

				echo FormUtils::getNumberField("moyenne", "Moyenne (km)", 0, 100, 0.001,
					(isset($epreuve) ? $epreuve->MOYENNE : $data_moyenne), null, true, true);

				echo FormUtils::getTextField("jour", "Jour (JJ/MM)",
					(isset($epreuve) ? $epreuve->JOUR : $data_jour), null, true, 40, "JJ/MM", "[0-9]{2}/[0-9]{2}");

				echo FormUtils::getDropdownList("cat_code", "Code catégorie",
					"ID", "ID", array(
						//PRO, ETA, CME et CMI
						(object)array("ID" => "PRO"),
						(object)array("ID" => "ETA"),
						(object)array("ID" => "CME"),
						(object)array("ID" => "CMI")
					), (isset($epreuve) ? $epreuve->CAT_CODE : $data_cat_code), "ETA");

				echo '<input type="submit" class="btn btn-default">';

			?>
		</form>
	</div>
</div>