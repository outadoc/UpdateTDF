<?php

	/**
	 * Fichier contrôleur pour la suppression d'une épreuve.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/FormUtils.class.php";

	$annee     = FormUtils::getGetVar("annee");
	$n_epreuve = FormUtils::getGetVar("epreuve");

	if ($annee !== null && $n_epreuve !== null) {
		try {
			$db = new Database();
			$db->supprimerEpreuve($annee, $n_epreuve);
			$db->close();

			header("Location: ./liste-epreuves.php?success");
		} catch (\Exception $e) {
			header("Location: ./liste-epreuves.php?error");
		}
	} else {
		header("Location: ./liste-epreuves.php?error=1");
	}