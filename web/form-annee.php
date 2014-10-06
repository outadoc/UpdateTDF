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
	require "model/Time.class.php";

	//traitement du formulaire année


	$error     = null;
	$key_annee = FormUtils::getGetVar("annee");

	//on récupère les éléments du formulaire, s'ils sont définis
	$data_annee       = FormUtils::getPostVar("n_annee");
	$data_jours_repos = FormUtils::getPostVar("jours_repos");

	//si le formulaire a été dûment rempli
	if ($data_annee !== null && $data_jours_repos !== null) {
		if ($data_annee < 9999 && $data_annee >= Time::getCurrentYear() && $data_jours_repos >= 0) {
			try {
				$db = new Database();

				if ($key_annee === null) {
					//on cherche une année existante avec cette clé
					try {
						$db->getAnnee($data_annee);

						//si on n'a pas d'exception, on essaye de mettre à jour une année implicitement
						//on met donc à jour une année existante
						$db->majAnnee($data_annee, $data_jours_repos);

						//on redirige vers la page de l'année
						header("Location: form-annee.php?annee=" . $data_annee . "&success");
					} catch (NoSuchEntryException $e) {
						$db->ajouterAnnee($data_annee, $data_jours_repos);

						//on redirige vers la page de l'année
						header("Location: form-annee.php?annee=" . $data_annee . "&success");
					}
				} else {
					//on met à jour une année existante
					$db->majAnnee($key_annee, $data_jours_repos);

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

	$title = "Ajouter / Modifier une année";
	define("PAGE_TITLE", $title);

	try {
		$db = new Database();

		/** @var $key_annee integer */
		if ($key_annee !== null) {
			$annee = $db->getAnnee($key_annee);
		}

		$db->close();
	} catch (\Exception $e) {
		$fatal_error = $e->getMessage();
	}

	require "view/header.php";
	require "view/form-annee.php";
	require "view/footer.php";