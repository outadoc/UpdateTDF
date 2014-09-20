<?php

	/**
	 * Fichier contrôleur pour l'accueil (liste des coureurs)
	 * (c) 2014 Baptiste Candellier
	 */

	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";

	define("PAGE_TITLE", "TDF - Liste des coureurs");

	require "view/header.php";
	require "view/liste-coureurs.php";
	require "view/footer.php";
