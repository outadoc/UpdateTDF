<?php

	namespace TDF;


	require "includes/init.php";
	require "includes/db/Database.class.php";
	require "includes/AlertBanner.class.php";
	require "includes/FormControls.class.php";

	function getPostVar($id)
	{
		return ((isset($_POST[$id]) && !empty($_POST[$id])) ? htmlspecialchars($_POST[$id]) : null);
	}

	$n_coureur = (isset($_GET['n_coureur']) && is_numeric($_GET['n_coureur']))
		? htmlspecialchars($_GET['n_coureur']) : null;

	$data_nom = getPostVar("nom");
	$data_prenom = getPostVar("prenom");
	$data_code_tdf = getPostVar("code_tdf");
	$data_annee_naissance = getPostVar("annee_naissance");
	$data_annee_tdf = getPostVar("annee_tdf");

	$title = (isset($n_coureur) && $n_coureur !== null) ? "Modifier un coureur" : "Ajouter un coureur";

	if ($data_nom !== null && $data_prenom !== null && $data_code_tdf !== null
		&& ($data_annee_naissance === null || ($data_annee_naissance < 9999 && $data_annee_naissance > 1800))
		&& ($data_annee_tdf === null || ($data_annee_tdf < 9999 && $data_annee_tdf > 1800))
	) {
		try {
			$db = new Database();

			if ($n_coureur === null) {
				//on ajoute un nouveau coureur
				$db->ajouterCoureur($data_nom, $data_prenom, $data_code_tdf, $data_annee_naissance, $data_annee_tdf);

				//on redirige vers la page du coureur ajouté
				header("Location: coureur.php?n_coureur=" . $db->getDernierNumCoureur()->MAXNUM . "&success");
			} else if ($n_coureur !== null) {
				//on met à jour un coureur existant
				$db->majCoureur($n_coureur, $data_nom, $data_prenom, $data_code_tdf, $data_annee_naissance, $data_annee_tdf);

				//on redirige vers la page du coureur mis à jour
				header("Location: coureur.php?n_coureur=" . $n_coureur . "&success");
			}

		} catch (\Exception $e) {
			die(AlertBanner::getGenericErrorMessage("Erreur !", $e->getMessage()));
		}

		$db->close();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>TDF - <?php echo $title; ?></title>
	<?php require "includes/header.php"; ?>
</head>
<body>
<?php

	require "includes/navbar.php";

	try {
		$db   = new Database();
		$pays = $db->getListePays();

		if ($n_coureur !== null) {
			$coureur = $db->getCoureur($n_coureur);
		}

		$db->close();
	} catch (\Exception $e) {
		die(AlertBanner::getGenericErrorMessage("Erreur !", $e->getMessage()));
	}

?>
<div class="container-fluid">
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

					echo FormControls::getTextField("prenom", "Prénom",
						(isset($coureur) ? $coureur->PRENOM : ""), true, 20);
					echo FormControls::getTextField("nom", "Nom",
						(isset($coureur) ? $coureur->NOM : ""), true, 30);

					echo FormControls::getNumberField("annee_naissance", "Année de naissance", 1800, 2999, 1,
						(isset($coureur) ? $coureur->ANNEE_NAISSANCE : 1955));
					echo FormControls::getNumberField("annee_tdf", "Année du 1er TDF", 1903, 2999, 1,
						(isset($coureur) ? $coureur->ANNEE_TDF : 2014));

					echo FormControls::getDropdownList("code_tdf", "Pays", "CODE_TDF", "NOM",
						$pays, (isset($coureur)) ? $coureur->CODE_TDF : 'FRA');

				?>
				<input type="submit" class="btn btn-default">
			</form>
		</div>
	</div>
</div>
</body>
</html>