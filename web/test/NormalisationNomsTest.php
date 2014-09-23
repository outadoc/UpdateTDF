<?php
	/**
	 * NormalisationNomsTest.php
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


	class NormalisationNomsTest extends \PHPUnit_Framework_TestCase
	{

		public function testNomNormal()
		{
			$this->assertEquals("PORCQ", TextUtils::normaliserNomCoureur("Porcq"));
		}

		public function testNomMinuscules()
		{
			$this->assertEquals("GESQUIN", TextUtils::normaliserNomCoureur("gesquin"));
		}

		public function testNomAccent()
		{
			$this->assertEquals("LEFEVRE", TextUtils::normaliserNomCoureur("Lefévré"));
		}

		public function testNomAccentTiret()
		{
			$this->assertEquals("LE-FEVRE", TextUtils::normaliserNomCoureur("Le-févré"));
		}

		public function testNomMajusculesMinuscules()
		{
			$this->assertEquals("CANDELLIER", TextUtils::normaliserNomCoureur("cAndElLieR"));
		}

		public function testNomSimpleTraitUnion()
		{
			$this->assertEquals("DUBEURRE-LAMOTTE", TextUtils::normaliserNomCoureur("dubeurre-lamotte"));
		}

		public function testNomDoubleTraitUnion()
		{
			$this->assertEquals("DUBEURRE--LAMOTTE", TextUtils::normaliserNomCoureur("dubeurre--lamotte"));
		}

		/**
		 * @expectedException \ErrorException
		 */
		public function testNomCaractereInterdit()
		{
			TextUtils::normaliserNomCoureur("C@NDELLIER");
		}

		/**
		 * @expectedException \ErrorException
		 */
		public function testNomCyrillique()
		{
			TextUtils::normaliserNomCoureur("Влади мирович Путин");
		}

		/**
		 * @expectedException \ErrorException
		 */
		public function testNomEmojiInterdit()
		{
			TextUtils::normaliserNomCoureur("Candellier ?");
		}

	}
 