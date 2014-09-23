<?php
	/**
	 * Fichier contrôleur chargé de la déconnexion de l'utilisateur.
	 * (c) 2014 Baptiste Candellier
	 */

	require 'model/init.php';

	//déconnexion de l'utilisateur
	session_destroy();

	//redirection vers la page de login
	header("Location: login.php");