<?php

	/**
	 * Fichier contrôleur pour le formulaire d'édition/ajout d'un coureur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";
	require "model/FormUtils.class.php";
	require "model/Time.class.php";


	//traitement du formulaire coureur

	//on récupère le numéro de coureur s'il est défini
	$n_coureur = FormUtils::getGetVar("n_coureur");

	//on récupère les éléments du formulaire, s'ils sont définis
	$data_nom             = FormUtils::getPostVar("nom");
	$data_prenom          = FormUtils::getPostVar("prenom");
	$data_code_tdf        = FormUtils::getPostVar("code_tdf");
	$data_annee_naissance = FormUtils::getPostVar("annee_naissance");
	$data_annee_tdf       = FormUtils::getPostVar("annee_tdf");

	//si le formulaire a été dûment rempli
	if ($data_nom !== null && $data_prenom !== null && $data_code_tdf !== null) {
		if (($data_annee_naissance === null || ($data_annee_naissance < 9999 && $data_annee_naissance > 1800))
			&& ($data_annee_tdf === null || ($data_annee_tdf < 9999 && $data_annee_tdf > 1800))
			&& $data_annee_naissance < $data_annee_tdf
		) {
			try {
				$db = new Database();

				if ($n_coureur === null) {
					//on ajoute un nouveau coureur
					$db->ajouterCoureur($data_nom, $data_prenom, $data_code_tdf, $data_annee_naissance, $data_annee_tdf);

					//on redirige vers la page du coureur ajouté
					header("Location: coureur.php?n_coureur=" . $db->getDernierNumCoureur() . "&success");
				} else {
					//on met à jour un coureur existant
					$db->majCoureur($n_coureur, $data_nom, $data_prenom, $data_code_tdf, $data_annee_naissance, $data_annee_tdf);

					//on redirige vers la page du coureur mis à jour
					header("Location: coureur.php?n_coureur=" . $n_coureur . "&success");
				}

				$db->close();
			} catch (\Exception $e) {
				define("ERROR", $e->getMessage());
			}
		} else {
			define("ERROR", "Formulaire mal rempli. Vérifiez les informations données.");
		}
	}

	$title = (isset($n_coureur) && $n_coureur !== null) ? "Modifier un coureur" : "Ajouter un coureur";

	define("PAGE_TITLE", "TDF - " . $title);

	require "view/header.php";
	require "view/form-coureur.php";
	require "view/footer.php";