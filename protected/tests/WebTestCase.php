<?php

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */

if(defined('TEST_ON_TRAVIS'))
	require_once dirname(__FILE__).'/SauceWebTestCase.php';
else
	Yii::import('system.test.CWebTestCase');


class WebTestCase extends CWebTestCase
{
	
	/**
	 * Sets up before each test method runs.
	 * This mainly sets the base URL for the test application.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->setBrowserUrl(TEST_BASE_URL);
	}
	
	public function config4Behat()
	{
		$this->setBrowserUrl('http://localhost/cms/index-test.php/');
		$this->prepareTestSession();
		$this->shareSession(true);
	}
	
	/**
	 * Open $url and test if you can see $see
	 * @param string $url
	 * @param string $see
	 */
	public function visit($url, $see)
	{
		$this->open($url);
		$this->assertTextPresent($see);
	}
}
