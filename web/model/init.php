<?php
	/**
	 * Initialisation de l'application, à insérer dans chaque page affichée.
	 * (c) 2014 Baptiste Candellier
	 */

	//encodage des pages
	mb_internal_encoding("UTF-8");
	mb_http_output('UTF-8');

	header('Content-Type: text/html; charset=utf-8');

	//affichage des erreurs
	error_reporting(E_ALL);
	ini_set('display_errors', 1);