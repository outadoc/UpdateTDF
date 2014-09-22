<?php
	/**
	 * Classes liées à l'accès à la base de donnée.
	 * (c) 2014 Baptiste Candellier
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

		public function __destruct()
		{
			$this->close();
		}

		/**
		 * Ferme de la base de données.
		 */
		public function close()
		{
			if ($this->db !== null) {
				oci_close($this->db);
			}
		}

		/**
		 * Exécute une requête qui ne retourne pas de lignes (ex: INSERT INTO) sur la base de données Oracle.
		 *
		 * @param string $sql la requête à exécuter, avec des placeholders
		 * @param array $bindings les valeurs des placeholders
		 * @throws \ErrorException si la requête a échoué
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

			$succes = oci_execute($stid);

			if (!$succes) {
				throw new \ErrorException(oci_error($stid)['message']);
			}

			return $stid;
		}

		/**
		 * Exécute une requête retournant des lignes sur la base de données Oracle.
		 *
		 * @param string $sql la requête à exécuter, avec des placeholders
		 * @param array $bindings les valeurs des placeholders
		 * @return array une liste des résultats retournés
		 */
		private function executerRequeteAvecResultat($sql, $bindings = null)
		{
			return $this->parserResultat($this->executerRequete($sql, $bindings));
		}

		/**
		 * Parse le résultat d'une requête et la renvoie dans un array.
		 *
		 * @param resource $stid la transaction dont il faut passer le résultat
		 * @return array une liste des lignes retournées par la requête
		 */
		private function parserResultat($stid)
		{
			$result = array();

			while (($row = oci_fetch_object($stid)) !== false) {
				$result[] = $row;
			}

			return $result;
		}

		/**
		 * Ajoute un coureur dans la base de données.
		 *
		 * @param string $nom le nom du coureur (sera normalisé)
		 * @param string $prenom le prénom du coureur (sera normalisé)
		 * @param string $code_tdf le code pays du coureur, en 3 caractères maximum
		 * @param integer $annee_naissance l'année de naissance du coureur
		 * @param integer $annee_tdf l'année du premier tour de france du coureur
		 */
		public function ajouterCoureur($nom, $prenom, $code_tdf, $annee_naissance, $annee_tdf)
		{
			$sql = "INSERT INTO vt_coureur
					(n_coureur, code_tdf, nom, prenom, annee_naissance, annee_tdf)
					VALUES ((SELECT max(n_coureur) + 1 FROM vt_coureur), :code_tdf, :nom, :prenom, :annee_naissance, :annee_tdf)";

			$this->executerRequete($sql, array(
				":code_tdf"        => $code_tdf,
				":nom"             => TextUtils::normaliserNomCoureur($nom),
				":prenom"          => TextUtils::normaliserPrenomCoureur($prenom),
				":annee_naissance" => $annee_naissance,
				":annee_tdf"       => $annee_tdf
			));
		}

		/**
		 * Met à jour les informations d'un coureur dans la base de données.
		 *
		 * @param integer $n_coureur le numéro du coureur à mettre à jour
		 * @param string $nom le nom du coureur (sera normalisé)
		 * @param string $prenom le prénom du coureur (sera normalisé)
		 * @param string $code_tdf le code pays du coureur, en 3 caractères maximum
		 * @param integer $annee_naissance l'année de naissance du coureur
		 * @param integer $annee_tdf l'année du premier tour de france du coureur
		 */
		public function majCoureur($n_coureur, $nom, $prenom, $code_tdf, $annee_naissance, $annee_tdf)
		{
			$sql = "UPDATE vt_coureur
					SET code_tdf = :code_tdf, nom = :nom, prenom = :prenom, annee_naissance = :annee_naissance, annee_tdf = :annee_tdf
					WHERE n_coureur = :n_coureur";

			$this->executerRequete($sql, array(
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
		 *
		 * @return array un tableau contenant la liste des coureurs
		 */
		public function getListeCoureurs()
		{
			$sql = "SELECT n_coureur, cou.nom, prenom, annee_naissance, annee_tdf, code_tdf, pays.nom AS pays
					FROM vt_coureur cou
					JOIN vt_pays pays USING(code_tdf)
					WHERE n_coureur >= 0 ORDER BY cou.nom, prenom";

			return $this->executerRequeteAvecResultat($sql);
		}

		/**
		 * Récupère les informations d'un coureur dans la base de données.
		 *
		 * @param integer $n_coureur le numéro du coureur
		 * @return object les informations du coureur
		 * @throws NoSuchEntryException si aucun coureur ne possède ce numéro
		 */
		public function getCoureur($n_coureur)
		{
			$sql = "SELECT n_coureur, cou.nom, prenom, annee_naissance, annee_tdf, code_tdf, pays.nom AS pays
					FROM vt_coureur cou
					JOIN vt_pays pays USING(code_tdf)
					WHERE n_coureur = :n_coureur";

			$result = $this->executerRequeteAvecResultat($sql, array(":n_coureur" => $n_coureur));

			if ($result === null || count($result) < 1) {
				throw new NoSuchEntryException("Pas de coureur avec le numéro " . $n_coureur . ".");
			}

			return $result[0];
		}

		/**
		 * Supprime un coureur de la base de données.
		 *
		 * @param integer $n_coureur le numéro du coureur à supprimer
		 * @throws \ErrorException si le coureur ne peut pas être supprimé
		 * @return resource le résultat de la requête
		 */
		public function supprimerCoureur($n_coureur)
		{
			if (count($this->getParticipations($n_coureur)) > 0) {
				//le coureur a des participations dans la base, on ne peut donc pas le supprimer
				throw new \ErrorException("Ce coureur possède des participations");
			}

			$sql = "DELETE FROM vt_coureur WHERE n_coureur = :n_coureur";
			return $this->executerRequete($sql, array(":n_coureur" => $n_coureur));
		}

		/**
		 * Récupère la liste des participations d'un coureur spécifique.
		 *
		 * @param integer $n_coureur le numéro du coureur
		 * @return array la liste des participations
		 */
		public function getParticipations($n_coureur)
		{
			$sql = "SELECT * FROM vt_participation WHERE n_coureur = :n_coureur";
			return $this->executerRequeteAvecResultat($sql, array(":n_coureur" => $n_coureur));
		}

		/**
		 * Récupère la liste des pays dans la base de données.
		 *
		 * @return array la liste des pays
		 */
		public function getListePays()
		{
			$sql = "SELECT code_tdf, c_pays, nom FROM vt_pays ORDER BY nom";
			return $this->executerRequeteAvecResultat($sql);
		}

		/**
		 * Récupère le dernier numéro de coureur inséré dans la base de données.
		 *
		 * @return integer
		 */
		public function getDernierNumCoureur()
		{
			$sql = "SELECT max(n_coureur) AS MAXNUM FROM vt_coureur";
			return $this->executerRequeteAvecResultat($sql)[0]->MAXNUM;
		}

		/**
		 * Récupère les informations pour une année dans la base de données (jours de repos).
		 *
		 * @param integer $annee l'année pour laquelle les données doivent être récupérées
		 * @throws NoSuchEntryException si l'année ne fait pas partie de la base
		 * @return object un objet contenant des informations sur l'année passée en paramètre
		 */
		public function getAnnee($annee)
		{
			$sql    = "SELECT * FROM vt_annee WHERE annee = :annee";
			$result = $this->executerRequeteAvecResultat($sql, array(":annee" => $annee));

			if ($result === null || count($result) < 1) {
				throw new NoSuchEntryException("L'année " . $annee . " n'existe pas dans la base.");
			}

			return $result[0];
		}

		/**
		 * Ajoute une année dans la base de données.
		 *
		 * @param integer $annee l'année à ajouter
		 * @param integer $jours_repos le nombre de jours de repos pour cette année
		 * @return resource le résultat de la requête
		 */
		public function ajouterAnnee($annee, $jours_repos)
		{
			$sql = "INSERT INTO vt_annee (annee, jour_repos) VALUES (:annee, :jour_repos)";
			return $this->executerRequete($sql, array(":annee" => $annee, ":jour_repos" => $jours_repos));
		}

		/**
		 * Met à jour une année de la base de données.
		 *
		 * @param integer $annee l'année à mettre à jour
		 * @param integer $jours_repos le nombre de jours de repos pour cette année
		 * @return resource le résultat de la requête
		 */
		public function majAnnee($annee, $jours_repos)
		{
			$sql = "UPDATE vt_annee SET jour_repos = :jour_repos WHERE annee = :annee";
			return $this->executerRequete($sql, array(":annee" => $annee, ":jour_repos" => $jours_repos));
		}

		/**
		 * Récupère la liste des années insérées dans la base de données.
		 *
		 * @return array la liste des années
		 */
		public function getListeAnnees()
		{
			$sql = "SELECT * FROM vt_annee";
			return $this->executerRequeteAvecResultat($sql);
		}

		/**
		 * Récupère les participations d'un coureur.
		 *
		 * @param integer $n_coureur le numéro du coureur
		 * @return array la liste des participations
		 */
		public function getListeParticipationsCoureur($n_coureur)
		{
			$sql = "SELECT * FROM vt_participation
					JOIN vt_sponsor USING (n_equipe, n_sponsor)
					JOIN vt_equipe USING (n_equipe)
					WHERE n_coureur = :n_coureur";

			return $this->executerRequeteAvecResultat($sql, array(":n_coureur" => $n_coureur));
		}

		/**
		 * Récupère une participation pour un coureur durant une année.
		 *
		 * @param integer $n_coureur le coureur participant
		 * @param integer $annee l'année de participation
		 * @throws NoSuchEntryException si la participation n'existe pas
		 * @return object la participation
		 */
		public function getParticipation($n_coureur, $annee)
		{
			$sql = "SELECT * FROM vt_participation
					JOIN vt_sponsor USING (n_equipe, n_sponsor)
					JOIN vt_equipe USING (n_equipe)
					WHERE n_coureur = :n_coureur
					AND annee = :annee";

			$result = $this->executerRequeteAvecResultat($sql, array(":n_coureur" => $n_coureur, ":annee" => $annee));

			if ($result === null || count($result) < 1) {
				throw new NoSuchEntryException("Il n'existe pas de participation en " . $annee . " pour le coureur " . $n_coureur . ".");
			}

			return $result[0];
		}

		/**
		 * Récupère la liste des épreuves s'étant déroulées sur une année spécifiée.
		 *
		 * @param integer $annee l'année des épreuves
		 * @return array la liste des épreuves
		 */
		public function getListeEpreuvesAnnee($annee)
		{
			$sql = "SELECT annee, n_epreuve, ville_d, ville_a, distance, moyenne, code_tdf_d, code_tdf_a, TO_CHAR(jour, 'dd/MM') as jour, cat_code
					FROM vt_epreuve WHERE annee = :annee";

			return $this->executerRequeteAvecResultat($sql, array(":annee" => $annee));
		}

		/**
		 * Récupère une épreuve par son numéro et son année.
		 *
		 * @param integer $annee l'année de l'épreuve
		 * @param integer $n_epreuve le numéro de l'épreuve
		 * @return object l'épreuve
		 * @throws NoSuchEntryException si l'épreuve n'existe pas dans la base
		 */
		public function getEpreuve($annee, $n_epreuve)
		{
			$sql = "SELECT annee, n_epreuve, ville_d, ville_a, distance, moyenne, code_tdf_d, code_tdf_a, TO_CHAR(jour, 'dd/MM') as jour, cat_code
					FROM vt_epreuve
					WHERE annee = :annee
					AND n_epreuve = :n_epreuve";

			$result = $this->executerRequeteAvecResultat($sql, array(":n_epreuve" => $n_epreuve, ":annee" => $annee));

			if ($result === null || count($result) < 1) {
				throw new NoSuchEntryException("Il n'existe pas d'épreuve en " . $annee . " avec comme numéro " . $n_epreuve . ".");
			}

			return $result[0];
		}

		/**
		 * Ajoute une épreuve dans la base de donnée.
		 *
		 * @param integer $annee l'année de l'épreuve
		 * @param integer $n_epreuve le numéro de l'épreuve (relatif à l'année)
		 * @param string $code_tdf_d le code pays de départ
		 * @param string $code_tdf_a le code pays d'arrivée
		 * @param string $ville_d la ville de départ
		 * @param string $ville_a la ville d'arrivée
		 * @param integer $distance la distance de l'épreuve
		 * @param integer $moyenne la moyenne
		 * @param string $jour le jour de l'épreuve (au format dd/mm)
		 * @param string $cat_code le code de catégorie de l'épreuve
		 * @return resource le résultat de la requête
		 */
		public function ajouterEpreuve($annee, $n_epreuve, $code_tdf_d, $code_tdf_a, $ville_d, $ville_a, $distance, $moyenne, $jour, $cat_code)
		{
			$sql = "INSERT INTO vt_epreuve (annee, n_epreuve, code_tdf_a, code_tdf_d, ville_d, ville_a, distance, moyenne, jour, cat_code)
					VALUES (:annee, :n_epreuve, :code_tdf_a, :code_tdf_d, :ville_a, :ville_d, :distance, :moyenne, TO_DATE(:jour, 'dd/MM/yyyy'), :cat_code)";

			return $this->executerRequete($sql, array(
				":annee"      => $annee,
				":n_epreuve"  => $n_epreuve,
				":code_tdf_d" => TextUtils::normaliserNomCoureur($code_tdf_d),
				":code_tdf_a" => TextUtils::normaliserNomCoureur($code_tdf_a),
				":ville_d"    => TextUtils::normaliserNomCoureur($ville_d),
				":ville_a"    => TextUtils::normaliserNomCoureur($ville_a),
				":distance"   => $distance,
				":moyenne"    => $moyenne,
				":jour"       => $jour . "/" . $annee,
				":cat_code"   => TextUtils::normaliserNomCoureur($cat_code)
			));
		}

		/**
		 * Met à jour une épreuve dans la base de donnée.
		 *
		 * @param integer $annee l'année de l'épreuve
		 * @param integer $n_epreuve le numéro de l'épreuve (relatif à l'année)
		 * @param string $code_tdf_d le code pays de départ
		 * @param string $code_tdf_a le code pays d'arrivée
		 * @param string $ville_d la ville de départ
		 * @param string $ville_a la ville d'arrivée
		 * @param integer $distance la distance de l'épreuve
		 * @param integer $moyenne la moyenne
		 * @param string $jour le jour de l'épreuve (au format dd/mm)
		 * @param string $cat_code le code de catégorie de l'épreuve
		 * @return resource le résultat de la requête
		 */
		public function majEpreuve($annee, $n_epreuve, $code_tdf_d, $code_tdf_a, $ville_d, $ville_a, $distance, $moyenne, $jour, $cat_code)
		{
			$sql = "UPDATE vt_epreuve SET code_tdf_a = :code_tdf_a, code_tdf_d = :code_tdf_d, ville_a = :ville_a,
					ville_d = :ville_d, distance = :distance, moyenne = :moyenne, jour = TO_DATE(:jour, 'dd/MM/yyyy'),
					cat_code = :cat_code
					WHERE annee = :annee AND n_epreuve = :n_epreuve";

			return $this->executerRequete($sql, array(
				":annee"      => $annee,
				":n_epreuve"  => $n_epreuve,
				":code_tdf_d" => TextUtils::normaliserNomCoureur($code_tdf_d),
				":code_tdf_a" => TextUtils::normaliserNomCoureur($code_tdf_a),
				":ville_d"    => TextUtils::normaliserNomCoureur($ville_d),
				":ville_a"    => TextUtils::normaliserNomCoureur($ville_a),
				":distance"   => $distance,
				":moyenne"    => $moyenne,
				":jour"       => $jour . "/" . $annee,
				":cat_code"   => TextUtils::normaliserNomCoureur($cat_code)
			));
		}

	}

	/**
	 * Class NoSuchEntryException
	 *
	 * @package TDF
	 */
	class NoSuchEntryException extends \ErrorException
	{
	}