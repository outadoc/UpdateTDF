<?php
/**
 * Classe contenant des méthodes relatives à la date/l'heure.
 * (c) 2014 Baptiste Candellier
 */

namespace TDF;


abstract class Time {

	public static function getCurrentYear() {
		return date("Y");
	}

} 