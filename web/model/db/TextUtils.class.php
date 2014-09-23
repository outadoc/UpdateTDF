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
		private static function supprimerAccentsEtrangers($str)
		{
			//source: https://stackoverflow.com/questions/10054818/convert-accented-characters-to-their-plain-ascii-equivalents#answer-10064701
			$normalizeChars = array(
				'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'Á' => 'A', 'Ã' => 'A',
				'Å' => 'A', 'Æ' => 'A', 'Ì' => 'I', 'Í' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O',
				'Õ' => 'O', 'Ø' => 'O', 'Ú' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'á' => 'a',
				'ã' => 'a', 'å' => 'a', 'æ' => 'a', 'ì' => 'i', 'í' => 'i', 'ð' => 'o', 'ñ' => 'n',
				'ò' => 'o', 'ó' => 'o', 'õ' => 'o', 'ø' => 'o', 'ú' => 'u', 'ý' => 'y', 'þ' => 'b',
				'ƒ' => 'f', 'ă' => 'a', 'ș' => 's', 'ț' => 't', 'Ă' => 'A', 'Ș' => 'S', 'Ț' => 'T'
			);

			return strtr($str, $normalizeChars);
		}

		/**
		 * Supprime les accents français d'un string et les remplace par leur équivalent en plain ASCII.
		 *
		 * @param $str string la chaîne dont les accents doivent être remplacés
		 * @return string la chaîne ne comportant plus d'accents
		 */
		private static function supprimerAccentsFrancais($str)
		{
			//source: https://stackoverflow.com/questions/10054818/convert-accented-characters-to-their-plain-ascii-equivalents#answer-10064701
			$normalizeChars = array(
				'À' => 'A', 'Â' => 'A', 'Ä' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E',
				'Ë' => 'E', 'Î' => 'I', 'Ï' => 'I', 'Ô' => 'O', 'Ö' => 'O', 'Ù' => 'U', 'Û' => 'U',
				'Ü' => 'U', 'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
				'ê' => 'e', 'ë' => 'e', 'î' => 'i', 'ï' => 'i', 'ô' => 'o', 'ö' => 'o', 'ù' => 'u',
				'û' => 'u', 'ÿ' => 'y'
			);

			return strtr($str, $normalizeChars);
		}

		/**
		 * Supprime "tous" les accents d'un string et les remplace par leur équivalent en plain ASCII.
		 *
		 * @param $str string la chaîne dont les accents doivent être remplacés
		 * @return string la chaîne ne comportant plus d'accents
		 */
		private static function supprimerAccents($str)
		{
			$str = TextUtils::supprimerAccentsFrancais($str);
			$str = TextUtils::supprimerAccentsEtrangers($str);

			return $str;
		}

		/**
		 * Normalise le nom de famille d'un coureur.
		 * Met le nom en majuscules, supprime les accents et les tirets/espaces superflus.
		 *
		 * @param $nom string le nom du coureur
		 * @throws \ErrorException si la chaine comporte des caractères interdits
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

			if (!preg_match("/^[A-Z\\-' ]*$/u", $nom)) {
				throw new \ErrorException('Le nom "' . $nom . '" comporte des caractères non conformes.');
			}

			return $nom;
		}

		public static function normaliserNomVille($nom)
		{
			//on supprime les accents, comme demandé par la spec
			$nom = TextUtils::supprimerAccents($nom);

			//on met le nom en majuscules
			$nom = mb_strtoupper($nom);

			//on supprime les éventuels tirets/espaces au début et à la fin du nom
			$nom = trim($nom, " -\t\n\r\0\x0B");

			if (!preg_match("/^[A-Z0-9\\-' ]*$/u", $nom)) {
				throw new \ErrorException('Le nom de ville "' . $nom . '" comporte des caractères non conformes.');
			}

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
			$prenom = TextUtils::supprimerAccentsEtrangers($prenom);

			//on supprime le premier accent du nom, en faisant bien attention d'utiliser mb_substr pour
			//ne pas avoir de problèmes avec l'encodage
			$prenom = mb_substr(TextUtils::supprimerAccents($prenom), 0, 1) . mb_substr($prenom, 1);

			//on met seulement la première lettre en majuscule
			$prenom = ucwords(mb_strtolower($prenom));

			//on met en majuscule la première lettre de chaque section (après chaque trait d'union)
			$prenom = implode('-', array_map('ucfirst', explode('-', $prenom)));

			//on supprime les éventuels tirets/espaces au début et à la fin du prénom
			$prenom = trim($prenom, " -\t\n\r\0\x0B");

			if (!preg_match("/^[a-zA-Zéèàùôöäâêëüûïîŷÿ\\-' ]*$/u", $prenom)) {
				throw new \ErrorException('Le prénom "' . $prenom . '" comporte des caractères non conformes.');
			}

			return $prenom;
		}

	}