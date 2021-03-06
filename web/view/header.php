<?php namespace TDF; ?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>TDF - <?= PAGE_TITLE ?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<link rel="stylesheet" href="view/css/bootstrap.min.css">
		<link rel="stylesheet" href="view/css/bootstrap-sortable.css">
		<link rel="stylesheet" href="view/css/global.css">

		<script type="application/javascript" src="view/js/jquery-2.1.1.min.js"></script>
		<script type="application/javascript" src="view/js/bootstrap.min.js"></script>
		<script type="application/javascript" src="view/js/moment.min.js"></script>
		<script type="application/javascript" src="view/js/bootstrap-sortable.js"></script>
		<script type="application/javascript" src="view/js/global.js"></script>
	</head>
<body>
<?php require "navbar.php"; ?>
	<div class="container-fluid">
<?php

	/** @var $error string */
	/** @var $fatal_error string */

	//si on doit afficher une erreur... on le fait
	if (isset($error)) {
		echo AlertBanner::getGenericErrorMessage($error);
		$error = null;
	}

	//on peut passer "success" ou "error" avec GET pour afficher des messages
	if (isset($_GET['success'])) {
		echo AlertBanner::getGenericSuccessMessage("L'opération a été effectuée avec succès.");
	}

	if (isset($_GET['error'])) {
		echo AlertBanner::getGenericErrorMessage(AlertBanner::getMessageFromCode($_GET['error']));
	}

	//si on a rencontré une erreur fatale, on l'affiche et on arrête le traitement
	if (isset($fatal_error)) {
		die(AlertBanner::getGenericErrorMessage($fatal_error));
	}