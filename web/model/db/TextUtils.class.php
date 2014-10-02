<?php
	/**
	 * Classes liées au traitement des strings.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	abstract class TextUtils
	{

		/**
		 * Normalise le nom de famille d'un coureur.
		 * Met le nom en majuscules, supprime les accents et les tirets/espaces superflus.
		 * Les chiffres ne sont pas autorisés.
		 *
		 * @param $nom string le nom du coureur
		 * @throws \ErrorException si la chaine comporte des caractères interdits
		 * @return string le nom une fois normalisé
		 */
		public static function normaliserNomCoureur($nom)
		{
			$nom = TextUtils::normaliserMajuscules($nom);

			if (!preg_match("/^[A-Z\\-' ]*$/u", $nom)) {
				throw new IllegalCharacterException('Le nom "' . $nom . '" comporte des caractères non conformes.');
			}

			return $nom;
		}

		/**
		 * Convertir une chaîne en majuscules, et supprime les accents.
		 *
		 * Toutes les lettres en majuscules.
		 *
		 * @param string $str la chaîne à formater
		 * @return string la chaîne normalisée
		 */
		private static function normaliserMajuscules($str)
		{
			//on supprime les accents, comme demandé par la spec
			$str = TextUtils::supprimerAccents($str);

			//on met le nom en majuscules
			$str = mb_strtoupper($str);

			//on remplace les ligatures se répètant plus de deux fois en deux seulement
			$str = preg_replace("/([\\-]){3,}/", "$1$1", $str);
			$str = preg_replace("/([' ]){2,}/", "$1", $str);

			//on supprime les éventuels tirets/espaces au début et à la fin du nom
			return trim($str, " -\t\n\r\0\x0B");
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
		 * Supprime les accents français d'un string et les remplace par leur équivalent en plain ASCII.
		 *
		 * @param $str string la chaîne dont les accents doivent être remplacés
		 * @return string la chaîne ne comportant plus d'accents
		 */
		private static function supprimerAccentsFrancais($str)
		{
			//source: https://stackoverflow.com/questions/10054818/convert-accented-characters-to-their-plain-ascii-equivalents#answer-10064701
			$normalizeChars = array(
				'À' => 'A', 'Â' => 'A', 'Ä' => 'A', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
				'Î' => 'I', 'Ï' => 'I', 'Ô' => 'O', 'Ö' => 'O', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
				'à' => 'a', 'â' => 'a', 'ä' => 'a', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
				'î' => 'i', 'ï' => 'i', 'ô' => 'o', 'ö' => 'o', 'ù' => 'u', 'û' => 'u', 'ÿ' => 'y',
				'ç' => 'c', 'Ç' => 'C'
			);

			return strtr($str, $normalizeChars);
		}

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
				'Å' => 'A', 'Æ' => 'AE', 'Ì' => 'I', 'Í' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O',
				'Õ' => 'O', 'Ø' => 'O', 'Ú' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'á' => 'a',
				'ã' => 'a', 'å' => 'a', 'æ' => 'ae', 'ì' => 'i', 'í' => 'i', 'ð' => 'o', 'ñ' => 'n',
				'ò' => 'o', 'ó' => 'o', 'õ' => 'o', 'ø' => 'o', 'ú' => 'u', 'ý' => 'y', 'þ' => 'b',
				'ƒ' => 'f', 'ă' => 'a', 'ș' => 's', 'ț' => 't', 'Ă' => 'A', 'Ș' => 'S', 'Ț' => 'T',
				'œ' => 'oe', 'Œ' => 'OE', '€' => 'e'
			);

			return strtr($str, $normalizeChars);
		}

		/**
		 * Normalise le nom d'une ville.
		 * Met le nom en majuscules, supprime les accents et les tirets/espaces superflus.
		 * Les chiffres sont autorisés.
		 *
		 * @param $nom
		 * @return string
		 * @throws \ErrorException
		 */
		public static function normaliserNomVille($nom)
		{
			$nom = TextUtils::normaliserMajuscules($nom);

			if (!preg_match("/^[A-Z0-9\\-' ]*$/u", $nom)) {
				throw new IllegalCharacterException('Le nom de ville "' . $nom . '" comporte des caractères non conformes.');
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
			$prenom = TextUtils::normaliserMinuscules($prenom);

			if (!preg_match("/^[a-zA-Zéèàùôöäâêëüûïîŷÿç\\-' ]*$/u", $prenom)) {
				throw new IllegalCharacterException('Le prénom "' . $prenom . '" comporte des caractères non conformes.');
			}

			return $prenom;
		}

		/**
		 * Convertit une chaîne en minuscules, et supprime les accents.
		 *
		 * 1ère lettre en majuscule sans accent.
		 * Autres lettres en minuscules.
		 * Tirets et espaces acceptés.
		 *
		 * @param string $str la chaîne à formater
		 * @return string la chaîne normalisée
		 */
		private static function normaliserMinuscules($str)
		{
			$str = TextUtils::supprimerAccentsEtrangers($str);
			$str = mb_strtolower($str);

			//on explose le prénom en un array, et on traîte chaque morceau séparé par des traits d'union OU des espaces
			$separators = array("-", " ", "'");

			foreach ($separators as $separator) {
				$str = implode($separator, array_map(array('TDF\TextUtils', 'normaliserSectionPrenomCoureur'), explode($separator, $str)));
			}

			//on remplace les ligatures multiples en une seule
			$str = preg_replace("/([\\-' ]){2,}/", "$1", $str);

			//on supprime les éventuels traits d'union/espaces au début et à la fin du prénom
			return trim($str, " -\t\n\r\0\x0B");
		}

		/**
		 * Normalise une section du prénom d'un coureur.
		 * Par exemple, si un coureur s'appelle Jean-Jérôme, vous devriez passer successivement à cette méthode :
		 * - Jean
		 * - Jérôme
		 *
		 * Cette méthode corrigera la casse et ne gardera que les accents demandés.
		 *
		 * @param $str
		 * @return string
		 */
		private static function normaliserSectionPrenomCoureur($str)
		{
			//on supprime le premier accent du nom, en faisant bien attention d'utiliser mb_substr pour
			//ne pas avoir de problèmes avec l'encodage
			$str = mb_substr(TextUtils::supprimerAccents($str), 0, 1) . mb_substr($str, 1);

			//on met la chaine en minuscules, puis on met la première lettre uniquement en majuscule
			return ucfirst($str);
		}

	}

	/**
	 * Class IllegalCharacterException
	 * Lancée lorsqu'un caractère inattendu a été trouvé dans une chaîne.
	 *
	 * @package TDF
	 */
	class IllegalCharacterException extends \ErrorException
	{
	}