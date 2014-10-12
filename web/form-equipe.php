<?php

	/**
	 * Fichier contrôleur pour le formulaire d'ajout d'une équipe.
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
	$data_annee_creation    = FormUtils::getPostVar("annee_creation");
	$data_annee_disparition = FormUtils::getPostVar("annee_disparition");
	$data_code_tdf          = FormUtils::getPostVar("code_tdf");
	$data_nom_sponsor       = FormUtils::getPostVar("nom_sponsor");
	$data_na_sponsor        = FormUtils::getPostVar("na_sponsor");

	//si le formulaire a été dûment rempli
	if ($data_annee_creation !== null
		&& $data_code_tdf !== null
		&& $data_nom_sponsor !== null
		&& $data_na_sponsor !== null
	) {
		if ($data_annee_creation < 9999 && $data_annee_creation >= Time::getCurrentYear()
			&& ($data_annee_disparition === null ||
				($data_annee_disparition < 9999 && $data_annee_disparition >= Time::getCurrentYear()))
		) {
			try {
				$db = new Database();
				$db->ajouterEquipe($data_annee_creation, $data_annee_disparition, $data_code_tdf, $data_nom_sponsor, $data_na_sponsor);
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

	$title = "Ajouter une équipe";
	define("PAGE_TITLE", $title);

	try {
		$db   = new Database();
		$pays = $db->getListePays();
		$db->close();
	} catch (\Exception $e) {
		$fatal_error = $e->getMessage();
	}

	require "view/header.php";
	require "view/form-equipe.php";
	require "view/footer.php";