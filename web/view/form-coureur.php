<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'édition/ajout de coureur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	/** @var $title string */
	/** @var $data_prenom string */
	/** @var $data_nom string */
	/** @var $data_annee_naissance string */
	/** @var $data_annee_tdf string */
	/** @var $data_code_tdf string */
	/** @var $pays string */

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
			<?php echo 'action="form-coureur.php' . (isset($n_coureur) ? '?n_coureur=' . $n_coureur : '') . '"'; ?>>
			<?php

				echo FormUtils::getTextField("prenom", "Prénom",
					(isset($coureur) ? $coureur->PRENOM : $data_prenom), true, 20, "Alberto");
				echo FormUtils::getTextField("nom", "Nom",
					(isset($coureur) ? $coureur->NOM : $data_nom), true, 30, "CONTADOR");

				echo FormUtils::getNumberField("annee_naissance", "Année de naissance", 1800, 2999, 1,
					(isset($coureur) ? $coureur->ANNEE_NAISSANCE : (($data_annee_naissance != null) ? $data_annee_naissance : 1955)));
				echo FormUtils::getNumberField("annee_tdf", "Année du 1er TDF", 1903, 2999, 1,
					(isset($coureur) ? $coureur->ANNEE_TDF : (($data_annee_tdf != null) ? $data_annee_tdf : Time::getCurrentYear())));

				echo FormUtils::getDropdownList("code_tdf", "Pays", "CODE_TDF", "NOM",
					$pays, (isset($coureur)) ? $coureur->CODE_TDF : (($data_code_tdf != null) ? $data_code_tdf : 'FRA'));

				echo '<input type="submit" class="btn btn-default">';

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

</script>