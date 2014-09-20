<?php

	/**
	 * Fichier contrôleur pour l'affichage d'un coureur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";
	require "model/FormUtils.class.php";

	define("PAGE_TITLE", "TDF - Détails du coureur");

	require "view/header.php";

	try {
		$n_coureur = FormUtils::getGetVar("n_coureur");

		if ($n_coureur === null || !is_numeric($n_coureur)) {
			$error = "Vous devez spécifier un numéro de coureur.";
		}

		$db      = new Database();
		$coureur = $db->getCoureur($n_coureur);
		$db->close();
	} catch (\Exception $e) {
		$error = $e->getMessage();
	}

	require "view/coureur.php";
	require "view/footer.php";
