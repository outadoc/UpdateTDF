<?php

	namespace TDF;

	if (isset($_GET['success'])) {
		echo AlertBanner::getGenericSuccessMessage("Wouhou !", "L'opération a été effectuée avec succès.");
	}

	try {
		$n_coureur = (isset($_GET['n_coureur'])) ? htmlspecialchars($_GET['n_coureur']) : null;

		if ($n_coureur === null || !is_numeric($n_coureur)) {
			die(AlertBanner::getGenericErrorMessage("Oups !", "Vous devez spécifier un numéro de coureur."));
		}

		$db      = new Database();
		$coureur = $db->getCoureur($n_coureur);

	} catch (\Exception $e) {
		die(AlertBanner::getGenericErrorMessage("Erreur !", $e->getMessage()));
	}

?>
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1>Détails du coureur
				<small><?php echo htmlspecialchars($coureur->PRENOM . " " . $coureur->NOM); ?> </small>
			</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<span class="glyphicon glyphicon-user"></span>
					&nbsp;Fiche d'identité
					<a href="form-coureur.php?n_coureur=<?php echo $_GET['n_coureur']; ?>"
					   class="pull-right">Modifier</a>
				</h3>

			</div>
			<div class="panel-body">
				<ul>
					<?php

						echo "<li><strong>Nom :</strong> " . htmlspecialchars($coureur->NOM) . "</li>";
						echo "<li><strong>Prénom :</strong> " . htmlspecialchars($coureur->PRENOM) . "</li>";
						echo "<li><strong>Pays :</strong> " . htmlspecialchars($coureur->PAYS) . "</li>";
						echo "<li><strong>Année de naissance :</strong> "
							. htmlspecialchars($coureur->ANNEE_NAISSANCE) . "</li>";
						echo "<li><strong>Année de 1er Tour de France :</strong> "
							. htmlspecialchars($coureur->ANNEE_TDF) . "</li>";

					?>
				</ul>
			</div>
		</div>
	</div>
</div>