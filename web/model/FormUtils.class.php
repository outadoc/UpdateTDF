<?php
	/**
	 * Created by PhpStorm.
	 * User: outadoc
	 * Date: 14/09/14
	 * Time: 21:42
	 */

	namespace TDF;


	abstract class FormUtils
	{

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

		public static function getNumberField($id, $label, $min, $max, $step, $value = "")
		{
			return '<div class="form-group">'
			. '<label for="' . htmlspecialchars($id) . '">' . htmlspecialchars($label) . '</label>'
			. '<input type="number" min="' . htmlspecialchars($min) . '" max="' . htmlspecialchars($max)
			. '" step="' . htmlspecialchars($step) . '" class="form-control" name="' . htmlspecialchars($id)
			. '" value="' . htmlspecialchars($value) . '">'
			. '</div>';
		}

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
		 * @param $id string le nom de la variable
		 * @return null|string la valeur de la variable (null si non définie)
		 */
		public static function getPostVar($id)
		{
			return ((isset($_POST[$id]) && !empty($_POST[$id])) ? htmlspecialchars($_POST[$id]) : null);
		}

	}