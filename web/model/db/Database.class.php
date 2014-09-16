<?php
	/**
	 * Created by PhpStorm.
	 * User: outadoc
	 * Date: 12/09/14
	 * Time: 18:26
	 */

	namespace TDF;


	require "TextUtils.class.php";

	class Database
	{

		private static $DB_USERNAME = "copie_tdf";
		private static $DB_PASSWORD = "copie_tdf";

		private static $DB_INSTANCE = "XE";
		private static $DB_HOSTNAME = "localhost";

		private $db;

		public function __construct()
		{
			//connexion à la base de données
			$this->db = oci_connect(Database::$DB_USERNAME, Database::$DB_PASSWORD, Database::$DB_HOSTNAME . "/" . Database::$DB_INSTANCE);

			//si erreur à la connection, on balance une exception
			if ($this->db === false) {
				throw new \ErrorException(oci_error()['message']);
			}
		}

		/**
		 * Fermeture de la base de données.
		 */
		public function close()
		{
			if ($this->db !== null) {
				oci_close($this->db);
			}
		}

		/**
		 * Exécute une requête qui ne retourne pas de lignes (ex: INSERT INTO) sur la base de données Oracle.
		 * @param $sql string la requête à exécuter, avec des placeholders
		 * @param $bindings array les valeurs des placeholders
		 * @return resource le statement correspondant à la requête exécutée
		 */
		private function executerRequete($sql, $bindings = null)
		{
			$stid = oci_parse($this->db, $sql);

			if ($bindings !== null && is_array($bindings)) {
				foreach ($bindings as $key => &$value) {
					oci_bind_by_name($stid, $key, $value);
				}
			}

			oci_execute($stid);
			return $stid;
		}

		/**
		 * Exécute une requête retournant des lignes sur la base de données Oracle.
		 * @param $sql string la requête à exécuter, avec des placeholders
		 * @param $bindings array les valeurs des placeholders
		 * @return array une liste des résultats retournés
		 */
		private function executerRequeteAvecResultat($sql, $bindings = null)
		{
			return $this->parserResultat($this->executerRequete($sql, $bindings));
		}

		/**
		 * Parse le résultat d'une requête et la renvoie dans un array.
		 * @param $stid resource la transaction dont il faut passer le résultat
		 * @return array une liste des lignes retournées par la requête
		 */
		private function parserResultat($stid)
		{
			$result = Array();

			while (($row = oci_fetch_object($stid)) !== false) {
				$result[] = $row;
			}

			return $result;
		}

		/**
		 * Ajoute un coureur dans la base de données.
		 * @param $nom string le nom du coureur (sera normalisé)
		 * @param $prenom string le prénom du coureur (sera normalisé)
		 * @param $code_tdf string le code pays du coureur, en 3 caractères maximum
		 * @param $annee_naissance integer l'année de naissance du coureur
		 * @param $annee_tdf integer l'année du premier tour de france du coureur
		 */
		public function ajouterCoureur($nom, $prenom, $code_tdf, $annee_naissance, $annee_tdf)
		{
			$sql = "INSERT INTO vt_coureur (n_coureur, code_tdf, nom, prenom, annee_naissance, annee_tdf) VALUES ((SELECT max(n_coureur) + 1 FROM vt_coureur), :code_tdf, :nom, :prenom, :annee_naissance, :annee_tdf)";

			$this->executerRequete($sql, Array(
				":code_tdf"        => $code_tdf,
				":nom"             => TextUtils::normaliserNomCoureur($nom),
				":prenom"          => TextUtils::normaliserPrenomCoureur($prenom),
				":annee_naissance" => $annee_naissance,
				":annee_tdf"       => $annee_tdf
			));
		}

		public function majCoureur($n_coureur, $nom, $prenom, $code_tdf, $annee_naissance, $annee_tdf)
		{
			$sql = "UPDATE vt_coureur SET code_tdf = :code_tdf, nom = :nom, prenom = :prenom, annee_naissance = :annee_naissance, annee_tdf = :annee_tdf WHERE n_coureur = :n_coureur";

			$this->executerRequete($sql, Array(
				":n_coureur"       => $n_coureur,
				":code_tdf"        => $code_tdf,
				":nom"             => TextUtils::normaliserNomCoureur($nom),
				":prenom"          => TextUtils::normaliserPrenomCoureur($prenom),
				":annee_naissance" => $annee_naissance,
				":annee_tdf"       => $annee_tdf
			));
		}

		/**
		 * Liste les coureurs présents dans la base.
		 * @return array un tableau contenant la liste des coureurs
		 */
		public function getListeCoureurs()
		{
			$sql = "SELECT n_coureur, cou.nom, prenom, annee_naissance, annee_tdf, code_tdf, pays.nom AS pays FROM vt_coureur cou JOIN vt_pays pays USING(code_tdf) WHERE n_coureur >= 0 ORDER BY cou.nom, prenom";
			return $this->executerRequeteAvecResultat($sql);
		}

		public function getCoureur($n_coureur)
		{
			$sql    = "SELECT n_coureur, cou.nom, prenom, annee_naissance, annee_tdf, code_tdf, pays.nom AS pays FROM vt_coureur cou JOIN vt_pays pays USING(code_tdf) WHERE n_coureur = :n_coureur";
			$result = $this->executerRequeteAvecResultat($sql, Array(":n_coureur" => $n_coureur));

			if ($result === null || count($result) < 1) {
				throw new \ErrorException("Pas de coureur avec le numéro " . $n_coureur . ".");
			}

			return $result[0];
		}

		public function updateCoureur($n_coureur, $nom, $prenom, $code_tdf, $annee_naissance, $annee_tdf)
		{
			$sql = "UPDATE vt_coureur SET nom = :nom, prenom = :prenom, code_tdf = :code_tdf, annee_naissance = :annee_naissance, annee_tdf = :annee_tdf WHERE n_coureur = :n_coureur";

			return $this->executerRequete($sql, Array(
				":code_tdf"        => $code_tdf,
				":nom"             => TextUtils::normaliserNomCoureur($nom),
				":prenom"          => TextUtils::normaliserPrenomCoureur($prenom),
				":annee_naissance" => $annee_naissance,
				":annee_tdf"       => $annee_tdf,
				":n_coureur"       => $n_coureur
			));
		}

		public function getListePays()
		{
			$sql = "SELECT code_tdf, c_pays, nom FROM vt_pays ORDER BY nom";
			return $this->executerRequeteAvecResultat($sql);
		}

		public function getDernierNumCoureur()
		{
			$sql = "SELECT max(n_coureur) AS MAXNUM FROM vt_coureur";
			return $this->executerRequeteAvecResultat($sql)[0];
		}

		public function __destruct()
		{
			$this->close();
		}

	}