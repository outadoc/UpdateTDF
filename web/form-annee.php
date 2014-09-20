<?php

	/**
	 * Fichier contrôleur pour le formulaire d'édition/ajout d'une année.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";
	require "model/FormUtils.class.php";


	//traitement du formulaire année

	$error   = null;
	$n_annee = FormUtils::getGetVar("annee");

	//on récupère les éléments du formulaire, s'ils sont définis
	$data_annee       = FormUtils::getPostVar("n_annee");
	$data_jours_repos = FormUtils::getPostVar("jours_repos");

	//si le formulaire a été dûment rempli
	if ($data_annee !== null && $data_jours_repos !== null) {
		if ($data_annee < 9999 && $data_annee > 1800 && $data_jours_repos >= 0) {
			try {
				$db = new Database();

				if ($n_annee === null) {
					//on cherche une année existante avec cette clé
					try {
						$db->getAnnee($data_annee);
						$error = "Cette année existe déjà dans la base de données.";
					} catch (\ErrorException $e) {
						$db->ajouterAnnee($data_annee, $data_jours_repos);

						//on redirige vers la page de l'année
						header("Location: form-annee.php?annee=" . $data_annee . "&success");
					}
				} else {
					//on met à jour une année existante
					$db->majAnnee($n_annee, $data_jours_repos);

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

	$title = (isset($n_annee) && $n_annee !== null) ? "Modifier une année" : "Ajouter une année";

	define("PAGE_TITLE", "TDF - " . $title);

	if ($error !== null) {
		define("ERROR", $error);
	}

	require "view/header.php";
	require "view/form-annee.php";
	require "view/footer.php";