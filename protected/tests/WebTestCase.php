<?php

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends CWebTestCase
{
	public static $browsers = array(
			array(
				'name'    => 'Firefox on Linux',
				'browser' => '*firefox',
				'host'    => 'localhost',
				'port'    => 4444,
				'timeout' => 30000,
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
}
