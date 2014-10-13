<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'ajout de directeur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	/** @var $data_prenom string */
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
				<form role="form" method="post" action="form-directeur.php">
					<?php

						echo FormUtils::getTextField("prenom", "Prénom", "", "", true, 20, "Michael");
						echo FormUtils::getTextField("nom", "Nom", "", "", true, 30, "BAY");

						echo '<input type="submit" class="btn btn-default">';

					?>

				</form>
			</div>
		</div>
	</div>
</div>