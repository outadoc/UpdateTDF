<?php
	/**
	 * Fichier de vue pour l'affichage d'un formulaire d'ajout/édition d'année.
	 * (c) 2014 Baptiste Candellier
	 * Date: 20/09/14
	 * Time: 11:07
	 */

	namespace TDF;

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
			<?php echo 'action="form-annee.php' . (isset($key_annee) ? '?annee=' . $key_annee : '') . '"'; ?>>
		<?php

				echo FormUtils::getNumberField("n_annee", "Année", 1800, 2999, 1,
					(isset($annee) ? $annee->ANNEE : Time::getCurrentYear()), (!isset($annee) || $annee === null));

				echo FormUtils::getNumberField("jours_repos", "Jours de repos", 0, 100, 1,
					(isset($annee) ? $annee->JOUR_REPOS : 0));

				echo '<input type="submit" class="btn btn-default">';

			?>
		</form>
	</div>
</div>