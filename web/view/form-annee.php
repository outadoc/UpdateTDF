<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'ajout/édition d'année.
	 * (c) 2014 Baptiste Candellier
	 * Date: 20/09/14
	 * Time: 11:07
	 */

	namespace TDF;


	/** @var $data_annee string */
	/** @var $data_jours_repos string */

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
				      method="post" <?= 'action="form-annee.php' . (isset($key_annee) ? '?annee=' . $key_annee : '') . '"' ?>>
					<?php

						echo FormUtils::getNumberField("n_annee", "Année", Time::getCurrentYear(), 9999, 1,
							(isset($annee) ? $annee->ANNEE : $data_annee), Time::getCurrentYear(), (!isset($annee) || $annee === null));

						echo FormUtils::getNumberField("jours_repos", "Jours de repos", 0, 100, 1,
							(isset($annee) ? $annee->JOUR_REPOS : $data_jours_repos), 0);

						echo FormUtils::getFormControls();

					?>
				</form>
			</div>
		</div>
	</div>
</div>