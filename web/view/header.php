<?php namespace TDF; ?>
	<!DOCTYPE html>
	<html>
	<head>
		<title><?php echo PAGE_TITLE; ?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="view/css/bootstrap.min.css">
		<link rel="stylesheet" href="view/css/global.css">
		<script type="application/javascript" src="view/js/jquery-2.1.1.min.js"></script>
		<script type="application/javascript" src="view/js/bootstrap.min.js"></script>
	</head>
<body>
<?php require "navbar.php"; ?>
	<div class="container-fluid">
<?php

	//si on doit afficher une erreur... on le fait
	if (isset($error)) {
		echo \TDF\AlertBanner::getGenericErrorMessage($error);
		$error = null;
	}

	if (isset($_GET['success'])) {
		echo AlertBanner::getGenericSuccessMessage("L'opération a été effectuée avec succès.");
	}

	if (isset($_GET['error'])) {
		echo AlertBanner::getGenericErrorMessage("Erreur lors de l'exécution de l'opération.");
	}

	if (isset($fatal_error)) {
		die(AlertBanner::getGenericErrorMessage($fatal_error));
	}