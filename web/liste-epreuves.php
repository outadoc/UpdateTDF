<?php

	/**
	 * Fichier contrôleur pour la liste des épreuves.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";

	define("PAGE_TITLE", "Liste des épreuves");

	try {
		$db       = new Database();
		$epreuves = $db->getListeEpreuves();
		$db->close();
	} catch (\Exception $e) {
		$fatal_error = $e->getMessage();
	}

	require "view/header.php";
	require "view/liste-epreuves.php";
	require "view/footer.php";
