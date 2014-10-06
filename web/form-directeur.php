<?php

	/**
	 * Fichier contrôleur pour le formulaire d'ajout d'un directeur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";
	require "model/FormUtils.class.php";


	//traitement du formulaire directeur

	//on récupère les éléments du formulaire, s'ils sont définis
	$data_nom    = FormUtils::getPostVar("nom");
	$data_prenom = FormUtils::getPostVar("prenom");

	//si le formulaire a été dûment rempli
	if ($data_nom !== null && $data_prenom !== null) {
		try {
			$db = new Database();

			//on ajoute un nouveau directeur
			$db->ajouterDirecteur($data_nom, $data_prenom);
			$db->close();

			//on redirige vers la page d'accueil
			header("Location: ./form-directeur.php?success");
		} catch (\Exception $e) {
			$error = $e->getMessage();
		}
	}

	$title = "Ajouter un directeur";
	define("PAGE_TITLE", $title);

	require "view/header.php";
	require "view/form-directeur.php";
	require "view/footer.php";