<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'ajout de sponsor.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

	/** @var $equipes array */
	/** @var $annees array */
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
				<form role="form" method="post" action="form-sponsor.php">
					<?php

						//afficher liste déroulante équipes
						echo FormUtils::getDropdownList("n_equipe", "Équipe", "N_EQUIPE", "LIBELLE", $equipes, null, null, "form-equipe.php");

						echo FormUtils::getDropdownList("annee_sponsor", "Année du sponsor", "ANNEE", "ANNEE", $annees, null, null, "form-annee.php");

						echo FormUtils::getDropdownList("code_tdf", "Pays du sponsor", "CODE_TDF", "NOM", $pays, "FRA", "FRA", "form-pays.php");

						echo FormUtils::getTextField("nom_sponsor", "Nom du sponsor", "", null, true, 50, "KRISPROLLS");

						echo FormUtils::getTextField("na_sponsor", "Nom abrégé du sponsor", "", null, true, 3, "ABC");

						echo FormUtils::getFormControls();

					?>
				</form>
			</div>
		</div>
	</div>
</div>