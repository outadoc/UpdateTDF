<?php
	/**
	 * Classe pour afficher des bandeaux d'alertes.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	abstract class AlertBanner
	{

		/**
		 * Retourne un message d'erreur sous forme d'une bannière stylisée.
		 *
		 * @param string $message le message d'erreur à afficher
		 * @return string le code HTML de la bannière
		 */
		public static function getGenericErrorMessage($message)
		{
			return '<div class="alert alert-danger" role="alert">'
			. '<strong>Oups !..</strong>&nbsp;&nbsp;'
			. htmlspecialchars($message)
			. '</div>';
		}

		/**
		 * Retourne un message de succès sous forme d'une bannière stylisée.
		 *
		 * @param string $message le message de succès à afficher
		 * @return string le code HTML de la bannière
		 */
		public static function getGenericSuccessMessage($message)
		{
			return '<div class="alert alert-success" role="alert">'
			. '<strong>Ça roule !</strong>&nbsp;&nbsp;'
			. htmlspecialchars($message)
			. '</div>';
		}

		/**
		 * Certaines erreurs passées par URL peuvent avoir un code spécifique.
		 * Cette méthode associe un code d'erreur à son message.
		 *
		 * @param integer $code le code d'erreur à rechercher
		 * @return string le message d'erreur correspondant
		 */
		public static function getMessageFromCode($code)
		{
			if (empty($code)) {
				return "Erreur lors de l'exécution de l'opération.";
			}

			switch ($code) {
				case 0:
					return "Erreur lors de la connexion à la base de données.";
				case 1:
					return "Vous devez spécifier un numéro de coureur.";
				default:
					return "Erreur lors de l'exécution de l'opération.";
			}
		}

	}