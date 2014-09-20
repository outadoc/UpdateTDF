<?php

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";
	require "model/FormUtils.class.php";


	//traitement du formulaire coureur

	$n_coureur = (isset($_GET['n_coureur']) && is_numeric($_GET['n_coureur']))
		? htmlspecialchars($_GET['n_coureur']) : null;

	$data_nom             = FormUtils::getPostVar("nom");
	$data_prenom          = FormUtils::getPostVar("prenom");
	$data_code_tdf        = FormUtils::getPostVar("code_tdf");
	$data_annee_naissance = FormUtils::getPostVar("annee_naissance");
	$data_annee_tdf       = FormUtils::getPostVar("annee_tdf");


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

	$title = (isset($n_coureur) && $n_coureur !== null) ? "Modifier un coureur" : "Ajouter un coureur";

	define("PAGE_TITLE", "TDF - " . $title);

	require "view/header.php";
	require "view/form-coureur.php";
	require "view/footer.php";