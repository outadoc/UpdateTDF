<?php
/**
 * Created by PhpStorm.
 * User: outadoc
 * Date: 20/09/14
 * Time: 20:19
 */

namespace TDF;


abstract class Time {

	public static function getCurrentYear() {
		return date("Y");
	}

} 