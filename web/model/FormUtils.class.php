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
		 * @param string $value la valeur du champ (vide par défaut)
		 * @param bool $isRequired indique si le champ est requis ou pas (faux par défaut)
		 * @param int $maxLength la taille maximale du champ (30 caractères par défaut)
		 * @param string $placeholder le placeholder pour ce champ
		 * @return string le contrôle au format HTML
		 */
		public static function getTextField($id, $label, $value = "", $isRequired = false, $maxLength = 30, $placeholder = "")
		{
			$value    = (!empty($value)) ? htmlspecialchars($value) : "";
			$required = ($isRequired) ? "required" : "";

			return '<div class="form-group">'
			. '<label for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>'
			. '<input type="text" class="form-control" maxlength="' . $maxLength . '" name="' . htmlspecialchars($id)
			. '" placeholder="' . htmlspecialchars($placeholder) . '" value="' . $value . '" ' . $required . '>'
			. '</div>';
		}

		/**
		 * Créé un champ nombre HTML.
		 *
		 * @param string $id l'identifiant du champ
		 * @param string $label le texte qui sera affiché comme étiquette
		 * @param integer $min la valeur minimum que peut prendre le champ
		 * @param integer $max la valeur maximum que peut prendre le champ
		 * @param integer $step le pas (différence entre chaque valeur)
		 * @param string $value la valeur par défaut du champ
		 * @param bool $isEnabled indique si le champ est activé et modifiable
		 * @return string le contrôle au format HTML
		 */
		public static function getNumberField($id, $label, $min, $max, $step = 1, $value = "", $isEnabled = true)
		{
			$enabled = (!$isEnabled) ? "disabled" : "";
			return '<div class="form-group">'
			. '<label for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>'
			. '<input type="number" min="' . htmlspecialchars($min) . '" max="' . htmlspecialchars($max)
			. '" step="' . htmlspecialchars($step) . '" class="form-control" name="' . htmlspecialchars($id)
			. '" value="' . htmlspecialchars($value) . '" ' . $enabled . '>'
			. '</div>';
		}

		/**
		 * Créé une liste déroulante HTML à partir d'un tableau.
		 *
		 * @param string $id l'identifiant du champ
		 * @param string $label le texte qui sera affiché comme étiquette
		 * @param string $id_col la colonne du tableau $items correspondant à l'identifiant
		 * @param string $name_col la colonne du tableau $items correspondant au nom (affiché)
		 * @param array $items le tableau servant à peupler la liste
		 * @param string $selectedId l'identifiant de l'entrée sélectionnée par défaut
		 * @return string le contrôle au format HTML
		 */
		public static function getDropdownList($id, $label, $id_col, $name_col, $items, $selectedId = null)
		{
			$html = '<div class="form-group"><label for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label)
				. '</label><select name="' . htmlspecialchars($id) . '" class="form-control">';

			foreach ($items as $item) {
				$selected = ($selectedId != null && $item->$id_col == $selectedId) ? "selected" : "";
				$html .= '<option value="' . $item->$id_col . '" ' . $selected . '>' . $item->$name_col . '</option>';
			}

			$html .= '</select></div>';
			return $html;
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