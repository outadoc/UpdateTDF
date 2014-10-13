<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'édition/ajout de coureur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	/** @var $data_prenom string */
	/** @var $data_nom string */
	/** @var $data_annee_naissance integer */
	/** @var $data_annee_tdf integer */
	/** @var $data_code_tdf string */
	/** @var $pays array */

?>
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1><?= PAGE_TITLE ?></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4 col-lg-offset-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<form role="form"
				      method="post" <?= 'action="form-coureur.php' . (isset($n_coureur) ? '?n_coureur=' . $n_coureur : '') . '"' ?>>
					<?php

						echo FormUtils::getTextField("prenom", "Prénom",
							(isset($coureur) ? $coureur->PRENOM : $data_prenom), "", true, 30, "Alberto");
						echo FormUtils::getTextField("nom", "Nom",
							(isset($coureur) ? $coureur->NOM : $data_nom), "", true, 20, "CONTADOR");

						echo FormUtils::getNumberField("annee_naissance", "Année de naissance", 1800, 2999, 1,
							(isset($coureur) ? $coureur->ANNEE_NAISSANCE : $data_annee_naissance), null, true, true);

						echo FormUtils::getNumberField("annee_tdf", "Année du 1er TDF", 1903, 2999, 1,
							(isset($coureur) ? $coureur->ANNEE_TDF : $data_annee_tdf), null, true, true);

						echo FormUtils::getDropdownList("code_tdf", "Pays", "CODE_TDF", "NOM",
							$pays, (isset($coureur) ? $coureur->CODE_TDF : $data_code_tdf), 'FRA', "form-pays.php");

						echo '<input type="submit" class="btn btn-default">';

					?>

				</form>
			</div>
		</div>
	</div>
	<script type="application/javascript">

		var annee_naissance = $("input[name=annee_naissance]"),
			annee_tdf = $("input[name=annee_tdf]");

		annee_naissance.change(function (e) {
			//si l'année du premier TDF est inférieure à l'année de naissance,
			//on met les deux égaux

			if (!annee_naissance.prop("disabled")
				&& !annee_tdf.prop("disabled")) {

				if (annee_tdf.val() < annee_naissance.val()) {
					annee_tdf.val(annee_naissance.val());
				}
			}

		});

		annee_tdf.change(function (e) {
			//si l'année de naissance est supérieure à l'année du premier TDF,
			//on met les deux égaux

			if (!annee_naissance.prop("disabled")
				&& !annee_tdf.prop("disabled")) {

				if (annee_naissance.val() > annee_tdf.val()) {
					annee_naissance.val(annee_tdf.val());
				}
			}
		});

	</script>