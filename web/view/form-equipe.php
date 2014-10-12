<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'ajout d'équipe.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

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
		<form role="form" method="post" action="form-equipe.php">
			<?php

				echo FormUtils::getNumberField("annee_creation", "Année de création", Time::getCurrentYear(), 2999, 1,
					Time::getCurrentYear(), null, true, false);

				echo FormUtils::getNumberField("annee_disparition", "Année de disparition", Time::getCurrentYear(), 2999, 1,
					null, null, true, true);

				echo FormUtils::getDropdownList("code_tdf", "Pays du sponsor", "CODE_TDF", "NOM", $pays, "FRA", "FRA", "form-pays.php");

				echo FormUtils::getTextField("nom_sponsor", "Nom du sponsor", "", null, true, 40, "KRISPROLLS");

				echo FormUtils::getTextField("na_sponsor", "Nom abrégé du sponsor", "", null, true, 3, "ABC");

				echo '<input type="submit" class="btn btn-default">';

			?>
		</form>
	</div>
</div>