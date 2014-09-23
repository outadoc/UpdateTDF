<?php
	/**
	 * Fichier contrôleur chargé de l'authentification de l'utilisateur.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	require 'model/init.php';
	require 'model/AlertBanner.class.php';
	require 'model/FormUtils.class.php';

	define("PAGE_TITLE", "TDF - Connexion");

	$username = FormUtils::getPostVar("username");
	$password = FormUtils::getPostVar("password");

	$redirect = FormUtils::getGetVar("redirect");

	if ($username !== null && $password !== null) {
		if ($username === DEFAULT_USER && $password === DEFAULT_PASSWORD) {
			$_SESSION["logged_in"] = true;

			if ($redirect !== null && preg_match("/^[a-z_-]\\.php$/", $redirect)) {
				header("Location: " . $redirect);
			} else {
				header("Location: ./");
			}
		} else {
			$error = "Mauvais identifiant/mot de passe !";
		}
	}

	require 'view/header.php';
	require 'view/login.php';
	require 'view/footer.php';