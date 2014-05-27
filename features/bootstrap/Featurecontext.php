<?php

use Behat\Behat\Context\BehatContext;

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{

    private $browser = array(
        'name' => 'Firefox on Linux',
        'browser' => '*firefox',
        'host' => 'localhost',
        'port' => 4444,
        'timeout' => 30000,
    );

    private $test;

    private function getTest($class = '')
    {
        if ($this->test === null)
        {
            Yii::import('application.tests.functional.*');
            Yii::import('application.tests.*');
            $class .= 'Test';
            $this->test = new $class('Test ' . $class, array(), 'Array', $this->browser);
            $this->test->config4Behat();
        }
        return $this->test;
    }

    /**
     * @Given /^I have viste the contact page$/
     */
    public function iHaveVisteTheContactPage()
    {
        $this->getTest('Contact')->visitContact();
    }

    /**
     * @Given /^I am visting the login page$/
     */
    public function iAmVistingTheLoginPage()
    {
        $this->getTest('Login')->visitLogin();
    }

    /**
     * @Given /^I am visiting the register page$/
     */
    public function iAmVisitingTheRegisterPage()
    {
        $this->getTest('Login')->visitRegister();
    }

    /**
     * @When /^I enter "([^"]*)" into the "([^"]*)"field$/
     */
    public function iEnterIntoTheField($name, $field)
    {
        $this->getTest()->fillinForm($field, $name);
    }

    /**
     * @Given /^I click "([^"]*)"$/
     */
    public function iClick($click)
    {
        switch ($click)
        {
            default:
                $this->getTest()->submitForm();
                break;
        }
    }

    /**
     * @Then /^I shoud see an error on "([^"]*)"$/
     */
    public function iShoudSeeAnErrorOn($fields)
    {
        $fields = str_replace(' ', '', $fields);
        foreach (mb_split(',', $fields) as $field)
            $this->getTest()->seeErrorOn($field);
    }

    /**
     * @Then /^I shoud see that my mail was send correctly$/
     */
    public function iShoudSeeThatMyMailWasSendCorrectly()
    {
        $this->getTest()->seeSuccess();
    }

    /**
     * @Then /^I shoud see password and username does not match$/
     */
    public function iShoudSeePasswordAndUsernameDoesNotMatch()
    {
        $this->getTest()->seePasswordUsernameNotMatch();
    }

    /**
     * @Then /^I shoud see that I am registered$/
     */
    public function iShoudSeeThatIAmRegistered()
    {
        $this->getTest()->seeSuccessOnRegister();
    }

    /**
     * @Given /^I am logedin with "([^"]*)"$/
     */
    public function iAmLogedinWith($user)
    {
        $this->getTest('Login')->seeSuccessOnLogin($user);
    }

    /**
     * @When /^I logout as "([^"]*)"$/
     */
    public function iLogout($user)
    {
        $this->getTest()->logout($user);
    }

    /**
     * @Then /^I shoud see that I am logged out as "([^"]*)"$/
     */
    public function iShoudSeeThatIAmLoggedOut($user)
    {
        $this->getTest()->seeLogout($user);
    }

}
