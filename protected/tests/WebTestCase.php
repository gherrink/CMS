<?php

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
if (defined('TEST_ON_TRAVIS'))
{
    require_once dirname(__FILE__) . '/SauceWebTestCase.php';
}
else
{
    Yii::import('system.test.CWebTestCase');
}

if(!defined('TEST_BASE_URL_PATH'))
    define('TEST_BASE_URL_PATH', 'cms/de/');

define('TEST_MAILS', true);

class WebTestCase extends CWebTestCase
{

    public $language = 'de';
    public $modelName = null;

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
        $this->setBrowserUrl('http://localhost/');
        $this->prepareTestSession();
        $this->shareSession(true);
    }

    public function getMessage($const)
    {
        return MsgPicker::msg($this->language)->getMessage($const);
    }

    /**
     * Open $url and test if you can see $see
     * @param string $url
     * @param string $see
     */
    public function visit($url, $see)
    {
        $this->open(TEST_BASE_URL_PATH . $url);
        $this->assertTextPresent($see);
    }

    /**
     * Open the $url and test if the $matcher (assertTag) exists
     * @param type $url
     * @param type $matcher
     */
    public function visitTag($url, $matcher)
    {
        $this->open(TEST_BASE_URL_PATH . $url);
        $this->assertTag($matcher, $this->getHtmlSource());
    }

    /**
     * Tests if the $element exists and if it exit it fills in the $value.
     * @param string $element
     * @param string $value
     */
    public function fillin($element, $value)
    {
        $this->assertElementPresent($element);
        $this->type($element, $value);
    }
    
    /**
     * A Field with $name will be filled with $value. The Feeld must be
     * created with the model $modelName
     * @param string $name
     * @param string $value
     */
    public function fillinForm($name, $value)
    {
        if ($value !== null && $value !== '' && $value !== 'nothing')
        {
            $this->fillin("name={$this->modelName}[$name]", $value);
        }
    }
    
    /**
     * Looks if the field with $name have an error.
     * @param string $name
     */
    public function seeErrorOn($name)
    {
        $errorMatcher = array(
            'attributes' => array(
                'id' => "{$this->modelName}_$name",
                'class' => 'error'
                ),
            );
        $this->assertTag($errorMatcher, $this->getHtmlSource());
    }

}
