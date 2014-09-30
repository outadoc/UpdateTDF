<?php
	/**
	 * NormalisationPrenomsTest.php
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

	mb_internal_encoding("UTF-8");

	require_once 'model/db/TextUtils.class.php';

	class TDFTest extends \PHPUnit_Framework_TestCase
	{

		public function testPrenomNormal()
		{
			$this->assertEquals("Marie", TextUtils::normaliserPrenomCoureur("Marie"));
		}

		public function testPrenomMinuscules()
		{
			$this->assertEquals("Marie", TextUtils::normaliserPrenomCoureur("marie"));
		}

		public function testPrenomAccent()
		{
			$this->assertEquals("Sébastien", TextUtils::normaliserPrenomCoureur("sébastien"));
		}

		public function testPrenomAccentTiret()
		{
			$this->assertEquals("Jean-René", TextUtils::normaliserPrenomCoureur("jean-rené"));
		}

		public function testPrenomMajusculesMinuscules()
		{
			$this->assertEquals("Robert", TextUtils::normaliserPrenomCoureur("rOBErT"));
		}

		public function testPrenomAccentRemplace()
		{
			$this->assertEquals("Eléonore", TextUtils::normaliserPrenomCoureur("Éléonore"));
		}

		public function testPrenomDoubleAccentMajuscule()
		{
			$this->assertEquals("Sainte-Eléonore", TextUtils::normaliserPrenomCoureur("sainte-éléonore"));
		}

		public function testPrenomAccentNonFrRemplace()
		{
			$this->assertEquals("Eléonore", TextUtils::normaliserPrenomCoureur("Éléoñore"));
		}

		public function testPrenomEspace()
		{
			$this->assertEquals("Machin Bidule", TextUtils::normaliserPrenomCoureur("machin bidule"));
		}

		public function testPrenomApostrophe()
		{
			$this->assertEquals("N'Guyen", TextUtils::normaliserPrenomCoureur("n'guyen"));
		}

		public function testEbe()
		{
			$this->assertEquals("Ebe-Ebé", TextUtils::normaliserPrenomCoureur("ébe-ebé"));
			$this->assertEquals("Ebé-Ebé", TextUtils::normaliserPrenomCoureur("ébé-ébé"));
			$this->assertEquals("Eb'E Iuç", TextUtils::normaliserPrenomCoureur("éb'é iuç"));
		}

		public function testAeOe()
		{
			$this->assertEquals("Oeuf Oeuf Soeur Aeronef", TextUtils::normaliserPrenomCoureur("Œuf œuf sœur Æronef"));
		}

		public function testLigaturesMultiples()
		{
			$this->assertEquals("Jean-Michel", TextUtils::normaliserPrenomCoureur("jean-----michel"));
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testPonctuation()
		{
			TextUtils::normaliserPrenomCoureur("¿!uoaei");
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testPrenomCaractereInterdit()
		{
			TextUtils::normaliserPrenomCoureur("J@ck");
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testPrenomCyrillique()
		{
			TextUtils::normaliserPrenomCoureur("Владимир");
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testPrenomEmojiInterdit()
		{
			TextUtils::normaliserPrenomCoureur("Baptiste ?");
		}

	}
 