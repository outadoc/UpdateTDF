<?php

	/**
	 * Fichier contrôleur pour le formulaire d'édition/ajout d'une épreuve.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";
	require "model/FormUtils.class.php";
	require "model/Time.class.php";

	//traitement du formulaire épreuve

	$error         = null;
	$key_annee     = FormUtils::getGetVar("annee");
	$key_n_epreuve = FormUtils::getGetVar("epreuve");

	//on récupère les éléments du formulaire, s'ils sont définis
	$data_annee      = FormUtils::getPostVar("n_annee");
	$data_n_epreuve  = FormUtils::getPostVar("n_epreuve");
	$data_code_tdf_d = FormUtils::getPostVar("code_tdf_d");
	$data_code_tdf_a = FormUtils::getPostVar("code_tdf_a");
	$data_ville_d    = FormUtils::getPostVar("ville_d");
	$data_ville_a    = FormUtils::getPostVar("ville_a");
	$data_distance   = FormUtils::getPostVar("distance");
	$data_moyenne    = FormUtils::getPostVar("moyenne");
	$data_jour       = FormUtils::getPostVar("jour");
	$data_cat_code   = FormUtils::getPostVar("cat_code");

	//si le formulaire a été dûment rempli
	if ($data_annee !== null
		&& $data_n_epreuve !== null
		&& $data_code_tdf_d !== null
		&& $data_code_tdf_a !== null
		&& $data_ville_d !== null
		&& $data_ville_a !== null
		&& $data_distance !== null
		&& $data_moyenne !== null
		&& $data_jour !== null
		&& $data_cat_code !== null
	) {
		if ($data_annee < 9999 && $data_annee > 1800
			&& $data_n_epreuve >= 0
			&& preg_match("#[0-9]{2}/[0-9]{2}/[0-9]{2}#", $data_jour)
			&& count($data_cat_code) < 4
		) {
			try {
				$db = new Database();

				if ($key_annee === null || $key_n_epreuve === null) {
					//on cherche une épreuve existante avec cette clé
					try {
						$db->getEpreuve($data_annee, $data_n_epreuve);
						$error = "Cette année existe déjà dans la base de données.";
					} catch (NoSuchEntryException $e) {
						$db->ajouterEpreuve($data_annee, $data_n_epreuve, $data_code_tdf_d, $data_code_tdf_a,
							$data_ville_d, $data_ville_a, $data_distance, $data_moyenne, $data_jour, $data_cat_code);

						//on redirige vers la page de l'épreuve
						header("Location: form-epreuve.php?annee=" . $data_annee . "&epreuve=" . $data_n_epreuve . "&success");
					}
				} else {
					//on met à jour une année existante
					//$db->majEpreuve($key_annee, $data_jours_repos);

					//on redirige vers la page de l'année
					header("Location: form-annee.php?annee=" . $data_annee . "&success");
				}

				$db->close();
			} catch (\Exception $e) {
				$error = $e->getMessage();
			}
		} else {
			$error = "Formulaire mal rempli. Vérifiez les informations données.";
		}
	}

	$title = (isset($key_annee) && $key_annee !== null) ? "Modifier une épreuve" : "Ajouter une épreuve";
	define("PAGE_TITLE", "TDF - " . $title);

	try {
		$db   = new Database();
		$pays = $db->getListePays();

		/** @var $key_annee integer */
		if ($key_annee !== null && $key_n_epreuve !== null) {
			$epreuve = $db->getEpreuve($key_annee, $key_n_epreuve);
		}

		$db->close();
	} catch (\Exception $e) {
		$fatal_error = $e->getMessage();
	}

	require "view/header.php";
	require "view/form-epreuve.php";
	require "view/footer.php";