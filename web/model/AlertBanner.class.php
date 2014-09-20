<?php
	/**
	 * Classe pour afficher des bandeaux d'alertes.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	abstract class AlertBanner
	{

		public static function getGenericErrorMessage($message)
		{
			return '<div class="alert alert-danger" role="alert">'
			. '<strong>Oups !..</strong>&nbsp;&nbsp;'
			. htmlspecialchars($message)
			. '</div>';
		}

		public static function getGenericSuccessMessage($message)
		{
			return '<div class="alert alert-success" role="alert">'
			. '<strong>Ça roule !</strong>&nbsp;&nbsp;'
			. htmlspecialchars($message)
			. '</div>';
		}

	}