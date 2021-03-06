<?php
	/**
	 * Initialisation de l'application, à insérer dans chaque page affichée.
	 * (c) 2014 Baptiste Candellier
	 */

	//configuration de l'application
	define("DB_USERNAME", "copie_tdf");
	define("DB_PASSWORD", "copie_tdf");
	define("DB_INSTANCE", "XE");
	define("DB_HOSTNAME", "localhost");
	define("DB_ENCODING", "AL32UTF8");

	define("DEFAULT_USER", "admin");
	define("DEFAULT_PASSWORD", "admin");

	//encodage des pages
	mb_internal_encoding("UTF-8");
	mb_http_output('UTF-8');

	header('Content-Type: text/html; charset=utf-8');

	//affichage des erreurs
	if (preg_match("/localhost/", $_SERVER['HTTP_HOST'])) {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	} else {
		error_reporting(0);
		ini_set('display_errors', 0);
	}

	//connexion de l'utilisateur
	session_start();

	if (!isset($_SESSION['logged_in']) && basename($_SERVER["PHP_SELF"]) != "login.php") {
		header("Location: login.php");
		exit(0);
	}