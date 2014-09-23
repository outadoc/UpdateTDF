<?php
	/**
	 * NormalisationVillesTest.php
	 * (c) 2014 Baptiste Candellier
	 */

	namespace TDF;


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

		/**
		 * @expectedException \ErrorException
		 */
		public function testVilleCaractereInterdit()
		{
			TextUtils::normaliserNomVille("M@ARSEILLE");
		}

		/**
		 * @expectedException \ErrorException
		 */
		public function testVilleEmojiInterdit()
		{
			TextUtils::normaliserNomVille("Caen ?");
		}

	}
 