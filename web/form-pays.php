<?php

	/**
	 * Fichier contrôleur pour le formulaire d'ajout d'un pays.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";
	require "model/FormUtils.class.php";


	//traitement du formulaire pays

	//on récupère les éléments du formulaire, s'ils sont définis
	$data_nom      = FormUtils::getPostVar("nom");
	$data_code_tdf = FormUtils::getPostVar("code_tdf");
	$data_c_pays   = FormUtils::getPostVar("c_pays");

	//si le formulaire a été dûment rempli
	if ($data_nom !== null && $data_code_tdf !== null && $data_c_pays !== null) {
		try {
			$db = new Database();

			if (!$db->verifierPaysExistant($data_nom)) {
				//on ajoute un nouveau pays
				$db->ajouterPays($data_code_tdf, $data_c_pays, $data_nom);
				$db->close();

				//on redirige vers la page d'accueil
				header("Location: ./form-pays.php?success");
			} else {
				$error = "Un pays avec ce nom existe déjà dans la base de données.";
			}

		} catch (\Exception $e) {
			$error = $e->getMessage();
		}
	}

	$title = "Ajouter un pays";
	define("PAGE_TITLE", "TDF - " . $title);

	require "view/header.php";
	require "view/form-pays.php";
	require "view/footer.php";