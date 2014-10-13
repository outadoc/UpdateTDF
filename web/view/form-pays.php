<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'ajout de pays.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	/** @var $data_code_tdf string */
	/** @var $data_c_pays string */
	/** @var $data_nom string */

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
				<form role="form" method="post" action="form-pays.php">
					<?php

						echo FormUtils::getTextField("nom", "Nom du pays", "", "", true, 20, "Autriche");
						echo FormUtils::getTextField("code_tdf", "Code pays (3 lettres)", "", "", true, 3, "AUT");
						echo FormUtils::getTextField("c_pays", "Code pays (2 lettres)", "", "", true, 2, "AT");

						echo FormUtils::getFormControls();

					?>

				</form>
			</div>
		</div>
	</div>
</div>