<?php

	/**
	 * Fichier contrôleur pour l'accueil (liste des coureurs)
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";

	define("PAGE_TITLE", "Liste des coureurs");

	try {
		$db       = new Database();
		$coureurs = $db->getListeCoureurs();
		$db->close();
	} catch (\Exception $e) {
		$fatal_error = $e->getMessage();
	}

	require "view/header.php";
	require "view/liste-coureurs.php";
	require "view/footer.php";
