<?php
	/**
	 * NormalisationNomsTest.php
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

	require_once 'model/db/TextUtils.class.php';

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

		public function testNomTraitsUnionMultiples()
		{
			$this->assertEquals("DUBEURRE--LAMOTTE", TextUtils::normaliserNomCoureur("dubeurre-------lamotte"));
		}

		public function testNomAeOe()
		{
			$this->assertEquals("OEUF OEUF SOEUR AERONEF", TextUtils::normaliserNomCoureur("Œuf œuf sœur Æronef"));
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testNomChiffreInterdit()
		{
			TextUtils::normaliserNomCoureur("bogossdu14");
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testNomCaractereInterdit()
		{
			TextUtils::normaliserNomCoureur("C@NDELLIER");
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testNomCyrillique()
		{
			TextUtils::normaliserNomCoureur("Влади мирович Путин");
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testNomEmojiInterdit()
		{
			TextUtils::normaliserNomCoureur("Candellier ?");
		}

	}
 