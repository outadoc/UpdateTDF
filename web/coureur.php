<?php

	require "model/init.php";
	require "model/db/Database.class.php";
	require "model/AlertBanner.class.php";

	define("PAGE_TITLE", "TDF - Détails du coureur");

	require "view/header.php";
	require "view/coureur.php";
	require "view/footer.php";
