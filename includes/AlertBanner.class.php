<?php
/**
 * Created by PhpStorm.
 * User: outadoc
 * Date: 14/09/14
 * Time: 18:37
 */

namespace TDF;


abstract class AlertBanner {

	public static function getGenericErrorMessage($title, $message) {
		return '<div class="alert alert-danger" role="alert">'
		. '<strong>' . htmlspecialchars($title) . '</strong>&nbsp;&nbsp;'
		. htmlspecialchars($message)
		. '</div>';
	}

	public static function getGenericSuccessMessage($title, $message) {
		return '<div class="alert alert-success" role="alert">'
		. '<strong>' . htmlspecialchars($title) . '</strong>&nbsp;&nbsp;'
		. htmlspecialchars($message)
		. '</div>';
	}

} 