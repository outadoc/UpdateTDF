<?php

	/**
	 * Fichier contrôleur pour la suppression d'un coureur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";
	require "model/FormUtils.class.php";

	$n_coureur = FormUtils::getGetVar("n_coureur");

	if ($n_coureur !== null) {
		try {
			$db = new Database();
			$db->supprimerCoureur($n_coureur);
			$db->close();

			header("Location: ./?success");
		} catch (\Exception $e) {
			header("Location: ./form-coureur.php?n_coureur=" . $n_coureur . "&error=0");
		}
	} else {
		header("Location: ./?error=1");
	}