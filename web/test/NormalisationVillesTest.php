<?php
	/**
	 * NormalisationVillesTest.php
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;

	require_once 'model/db/TextUtils.class.php';

	class NormalisationVillesTest extends \PHPUnit_Framework_TestCase
	{

		public function testVilleNormal()
		{
			$this->assertEquals("ANTIBES", TextUtils::normaliserNomVille("Antibes"));
		}

		public function testVilleMinuscules()
		{
			$this->assertEquals("PARIS", TextUtils::normaliserNomVille("paris"));
		}

		public function testVilleAccent()
		{
			$this->assertEquals("BERLIN", TextUtils::normaliserNomVille("Bérlin"));
		}

		public function testNomAccentTiret()
		{
			$this->assertEquals("LA FERTE-MACE", TextUtils::normaliserNomVille("La Ferté-Macé"));
		}

		public function testVilleMajusculesMinuscules()
		{
			$this->assertEquals("MARSEILLE", TextUtils::normaliserNomVille("mArSEilLE"));
		}

		public function testVilleSimpleTraitUnion()
		{
			$this->assertEquals("SAINT-TROPEZ", TextUtils::normaliserNomVille("Saint-Tropez"));
		}

		public function testVilleNombre()
		{
			$this->assertEquals("LES 2 ALPES", TextUtils::normaliserNomVille("les 2 alpes"));
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testVilleCaractereInterdit()
		{
			TextUtils::normaliserNomVille("M@ARSEILLE");
		}

		/**
		 * @expectedException \TDF\IllegalCharacterException
		 */
		public function testVilleEmojiInterdit()
		{
			TextUtils::normaliserNomVille("Caen ?");
		}

	}
 