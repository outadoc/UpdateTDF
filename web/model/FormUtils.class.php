<?php
	/**
	 * Classe contenant des méthodes pour la création de formulaires.
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	abstract class FormUtils
	{

		/**
		 * Créé un champ texte HTML.
		 *
		 * @param string $id l'identifiant du champ
		 * @param string $label le texte qui sera affiché comme étiquette
		 * @param string $value la valeur du champ
		 * @param string $default la valeur que prendra le champ si $value vaut null
		 * @param bool $isRequired indique si le champ est requis ou pas (faux par défaut)
		 * @param int $maxLength la taille maximale du champ (30 caractères par défaut)
		 * @param string $placeholder le placeholder pour ce champ
		 * @param string $match une regex optionnelle pour valider le champ
		 * @param bool $isPassword indique si la valeur du champ doit être cachée
		 * @return string le contrôle au format HTML
		 */
		public static function getTextField($id, $label, $value = "", $default = "", $isRequired = false, $maxLength = 30, $placeholder = "", $match = null, $isPassword = false)
		{
			$value   = (!empty($value)) ? htmlspecialchars($value) : htmlspecialchars($default);
			$required = ($isRequired) ? "required" : "";
			$pattern = ($match !== null) ? 'pattern="' . htmlspecialchars($match) . '"' : "";
			$type     = ($isPassword) ? "password" : "text";

			return '<div class="form-group">
						<label for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>
						<div class="input-group">
							<input type="' . $type . '" class="form-control" maxlength="' . $maxLength . '" name="' . htmlspecialchars($id) . '"
								placeholder="' . htmlspecialchars($placeholder) . '" value="' . $value . '" ' . $required . ' ' . $pattern . '>
						</div>
					</div>';
		}

		/**
		 * Créé un champ nombre HTML.
		 *
		 * @param string $id l'identifiant du champ
		 * @param string $label le texte qui sera affiché comme étiquette
		 * @param integer $min la valeur minimum que peut prendre le champ
		 * @param integer $max la valeur maximum que peut prendre le champ
		 * @param integer $step le pas (différence entre chaque valeur)
		 * @param string $value la valeur du champ
		 * @param string $default la valeur que prendra le champ si $value vaut null
		 * @param bool $isEnabled indique si le champ est activé et modifiable
		 * @param bool $isNullable true si une checkbox doit être affichée à côté du contrôle pour pouvoir le désactiver
		 * @return string le contrôle au format HTML
		 */
		public static function getNumberField($id, $label, $min, $max, $step = 1, $value = null, $default = null, $isEnabled = true, $isNullable = false)
		{
			if ($isNullable) $default = null;

			if ($value === null && $default === null) {
				$enabled       = "disabled";
				$chkboxEnabled = "";
			} else {
				$enabled       = "";
				$chkboxEnabled = "checked";
			}

			$readonly = (!$isEnabled) ? "readonly" : "";
			$nullable = ($isNullable) ? '<span class="input-group-addon"><input class="nullable" type="checkbox" ' . $chkboxEnabled . '></span>' : "";

			return '<div class="form-group">
						<label for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>
						<div class="input-group">
							' . $nullable . '
							<input type="number" min="' . htmlspecialchars($min) . '" max="' . htmlspecialchars($max) . '"
								step="' . htmlspecialchars($step) . '" class="form-control" name="' . htmlspecialchars($id) . '"
								value="' . (($value != null) ? htmlspecialchars($value) : htmlspecialchars($default)) . '" ' . $readonly . ' ' . $enabled . '>
						</div>
					</div>';
		}

		/**
		 * Créé une liste déroulante HTML à partir d'un tableau.
		 *
		 * @param string $id l'identifiant du champ
		 * @param string $label le texte qui sera affiché comme étiquette
		 * @param string $id_col la colonne du tableau $items correspondant à l'identifiant
		 * @param string $name_col la colonne du tableau $items correspondant au nom (affiché)
		 * @param array $items le tableau servant à peupler la liste
		 * @param string $selectedId l'identifiant de l'entrée sélectionnée
		 * @param string $default la valeur que prendra le champ si $value vaut null
		 * @param string $addLink le lien pour ajouter un élément de ce type. ex: "form-annee.php"
		 * @return string le contrôle au format HTML
		 */
		public static function getDropdownList($id, $label, $id_col, $name_col, $items, $selectedId = null, $default = null, $addLink = null)
		{
			if ($addLink !== null) {
				$addon = '	<span class="input-group-btn">
								<a class="btn btn-default" href="' . $addLink . '"><span class="glyphicon glyphicon-plus"></span></a>
					      	</span>';
			} else {
				$addon = "";
			}

			$html = '<div class="form-group">
						<label for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>
						<div class="input-group">
							<select name="' . htmlspecialchars($id) . '" class="form-control">';

			foreach ($items as $item) {

				if ($selectedId !== null) {
					$selected = ($item->$id_col == $selectedId) ? "selected" : "";
				} else {
					$selected = ($item->$id_col == $default) ? "selected" : "";
				}

				$html .= '<option value="' . htmlspecialchars($item->$id_col) . '" ' . $selected . '>'
					. htmlspecialchars($item->$name_col) . '</option>';
			}

			$html .= '		</select>
							' . $addon . '
						</div>
					</div>';

			return $html;
		}

		public static function getFormControls() {
			return '<input type="submit" class="btn btn-primary btn-form">';
		}

		/**
		 * Récupère une variable POST, et retourne soit sa valeur, soit null.
		 *
		 * @param $id string le nom de la variable
		 * @return null|string la valeur de la variable (null si non définie)
		 */
		public static function getPostVar($id)
		{
			return (isset($_POST[$id]) ? htmlspecialchars($_POST[$id]) : null);
		}

		/**
		 * Récupère une variable GET, et retourne soit sa valeur, soit null.
		 *
		 * @param $id string le nom de la variable
		 * @return null|string la valeur de la variable (null si non définie)
		 */
		public static function getGetVar($id)
		{
			return (isset($_GET[$id]) ? htmlspecialchars($_GET[$id]) : null);
		}

	}