<?php

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */

if(defined(TEST_ON_TRAVIS) && TEST_ON_TRAVIS === "TRUE")
	require_once 'CWebTestCase.php';
else
	Yii::import('system.test.CWebTestCase');

class WebTestCase extends CWebTestCase
{	
	
	public static $browsers = array(
        array(
            'name'           => 'Firefox 3.6 on Windows',
            'os'             => 'Windows 2003',
            'browser'        => 'firefox',
            'browserVersion' => '3.6.',
        	'port'			 => 4445,
        ),
	);
	
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
	
	protected function getDriver(array $browser)
	{
		parent::getDriver($browser);
	}
}
