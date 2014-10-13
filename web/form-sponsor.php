<?php

	/**
	 * Fichier contrôleur pour le formulaire d'ajout d'un sponsor.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";
	require "model/FormUtils.class.php";
	require "model/Time.class.php";

	//traitement du formulaire épreuve

	$error = null;

	//on récupère les éléments du formulaire, s'ils sont définis
	$data_n_equipe      = FormUtils::getPostVar("n_equipe");
	$data_annee_sponsor = FormUtils::getPostVar("annee_sponsor");
	$data_code_tdf      = FormUtils::getPostVar("code_tdf");
	$data_nom_sponsor   = FormUtils::getPostVar("nom_sponsor");
	$data_na_sponsor    = FormUtils::getPostVar("na_sponsor");

	//si le formulaire a été dûment rempli
	if ($data_annee_sponsor !== null
		&& $data_code_tdf !== null
		&& $data_nom_sponsor !== null
		&& $data_na_sponsor !== null
	) {
		if ($data_annee_sponsor < 9999 && $data_annee_sponsor >= Time::getCurrentYear()) {
			try {
				$db = new Database();
				$db->ajouterSponsor($data_n_equipe, $data_code_tdf, $data_nom_sponsor, $data_na_sponsor, $data_annee_sponsor);
				$db->close();

				//on redirige vers la page de la liste des équipes
				header("Location: liste-equipes.php?success");
			} catch (\Exception $e) {
				$error = $e->getMessage();
			}
		} else {
			$error = "Formulaire mal rempli. Vérifiez les informations données.";
		}
	}

	define("PAGE_TITLE", "Ajouter un sponsor");

	try {
		$db      = new Database();
		$annees  = $db->getListeAnnees();
		$pays    = $db->getListePays();
		$equipes = $db->getListeSponsorsActifs();
		$db->close();
	} catch (\Exception $e) {
		$fatal_error = $e->getMessage();
	}

	require "view/header.php";
	require "view/form-sponsor.php";
	require "view/footer.php";