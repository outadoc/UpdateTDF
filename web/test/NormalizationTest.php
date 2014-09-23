<?php
	/**
	 * NormalizationTest.php
	 * (c) 2014 outadoc
	 */

	namespace TDF;

	require 'model/init.php';
	require 'model/db/TextUtils.class.php';


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

		/**
		 * @expectedException \ErrorException
		 */
		public function testPrenomCaractereInterdit()
		{
			TextUtils::normaliserPrenomCoureur("J@ck");
		}

		/**
		 * @expectedException \ErrorException
		 */
		public function testPrenomRusse()
		{
			TextUtils::normaliserPrenomCoureur("Владимир");
		}

		/**
		 * @expectedException \ErrorException
		 */
		public function testPrenomEmojiInterdit()
		{
			TextUtils::normaliserPrenomCoureur("Baptiste ?");
		}

	}
 