<?php
	/**
	 * Created by PhpStorm.
	 * User: outadoc
	 * Date: 14/09/14
	 * Time: 12:15
	 */

	//encodage des pages
	mb_internal_encoding("UTF-8");
	mb_http_output('UTF-8');

	header('Content-Type: text/html; charset=utf-8');

	//affichage des erreurs
	error_reporting(E_ALL);
	ini_set('display_errors', 1);