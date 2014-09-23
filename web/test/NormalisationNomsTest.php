<?php
	/**
	 * NormalisationNomsTest.php
	 * (c) 2014 outadoc
	 */

	namespace TDF;


	class NormalisationNomsTest extends \PHPUnit_Framework_TestCase
	{

		public function testNomNormal()
		{
			$this->assertEquals("PORCQ", TextUtils::normaliserNomCoureur("Porcq"));
		}

	}
 