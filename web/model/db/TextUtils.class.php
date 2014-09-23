<?php
	/**
	 * Classes liées au traitement des strings.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	abstract class TextUtils
	{

		/**
		 * Supprime les accents d'un string et les remplace par leur équivalent en plain ASCII.
		 *
		 * @param $str string la chaîne dont les accents doivent être remplacés
		 * @return string la chaîne ne comportant plus d'accents
		 */
		private static function supprimerAccents($str)
		{
			//source: https://stackoverflow.com/questions/10054818/convert-accented-characters-to-their-plain-ascii-equivalents#answer-10064701
			$normalizeChars = array(
				'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A',
				'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E',
				'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O',
				'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
				'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
				'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i',
				'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o',
				'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b',
				'ÿ' => 'y', 'ƒ' => 'f', 'ă' => 'a', 'ș' => 's', 'ț' => 't', 'Ă' => 'A', 'Ș' => 'S', 'Ț' => 'T'
			);

			return strtr($str, $normalizeChars);
		}

		/**
		 * Normalise le nom de famille d'un coureur.
		 * Met le nom en majuscules, supprime les accents et les tirets/espaces superflus.
		 *
		 * @param $nom string le nom du coureur
		 * @return string le nom une fois normalisé
		 */
		public static function normaliserNomCoureur($nom)
		{
			//on supprime les accents, comme demandé par la spec
			$nom = TextUtils::supprimerAccents($nom);

			//on met le nom en majuscules
			$nom = mb_strtoupper($nom);

			//on supprime les éventuels tirets/espaces au début et à la fin du nom
			$nom = trim($nom, " -\t\n\r\0\x0B");

			return $nom;
		}

		/**
		 * Normalise le prénom d'un coureur.
		 * Capitalise le nom, supprime l'accent de la première lettre, et supprime les tirets/espace superflus.
		 *
		 * @throws \ErrorException si la chaîne comporte des caractères interdits
		 * @param $prenom string le prénom du coureur
		 * @return string le prénom normalisé
		 */
		public static function normaliserPrenomCoureur($prenom)
		{
			//on supprime le premier accent du nom, en faisant bien attention d'utiliser mb_substr pour
			//ne pas avoir de problèmes avec l'encodage
			$prenom = mb_substr(TextUtils::supprimerAccents($prenom), 0, 1) . mb_substr($prenom, 1);

			//on met seulement la première lettre en majuscule
			$prenom = ucwords(mb_strtolower($prenom));

			$prenom = implode('-', array_map('ucfirst', explode('-', $prenom)));

			//on supprime les éventuels tirets/espaces au début et à la fin du prénom
			$prenom = trim($prenom, " -\t\n\r\0\x0B");

			if (!preg_match("/^[a-zA-Zéèàùôöäâêëüûïîŷÿ\\-']*$/u", $prenom)) {
				throw new \ErrorException('Le prénom "' . $prenom . '" comporte des caractères non conformes.');
			}

			return $prenom;
		}

	}