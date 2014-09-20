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
	if (defined("ERROR")) {
		echo \TDF\AlertBanner::getGenericErrorMessage("Erreur !", ERROR);
	}