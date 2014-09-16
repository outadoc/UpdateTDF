<?php

	namespace TDF;


	require "includes/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";

?>

<!DOCTYPE html>
<html>
<head>
	<title>TDF - Liste des coureurs</title>
	<?php require "includes/header.php"; ?>
</head>
<body>
<?php require "includes/navbar.php"; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Liste des coureurs</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped sorted">
				<thead>
				<tr>
					<th>#</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Pays</th>
					<th>Année Naissance</th>
					<th>Année 1er TDF</th>
				</tr>
				</thead>
				<tbody>
				<?php

					try {
						$db       = new Database();
						$coureurs = $db->getListeCoureurs();

						foreach ($coureurs as $coureur) {
							echo "<tr>";
							echo '<td><a href="coureur.php?n_coureur=' . $coureur->N_COUREUR . '">' . $coureur->N_COUREUR . "</a></td>";
							echo "<td>" . $coureur->NOM . "</td>";
							echo "<td>" . $coureur->PRENOM . "</td>";
							echo "<td>" . $coureur->PAYS . "</td>";
							echo "<td>" . $coureur->ANNEE_NAISSANCE . "</td>";
							echo "<td>" . $coureur->ANNEE_TDF . "</td>";
							echo "</tr>\n";
						}

						$db->close();
					} catch (\Exception $e) {
						echo AlertBanner::getGenericErrorMessage("Erreur !", $e->getMessage());
					}

				?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>