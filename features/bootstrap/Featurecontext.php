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


    /**
     * @Given /^I am logged in as gallery moderator$/
     */
    public function iAmLoggedInAsGalleryModerator()
    {
        $this->getTest('Gallery')->logInAs('bob123', 'Boddo123');
    }

    /**
     * @Given /^I am visting the gallery page$/
     */
    public function iAmVistingTheGalleryPage()
    {
        $this->getTest('Gallery')->visitGallery();
    }

    /**
     * @Given /^I fill in "([^"]*)" into the "([^"]*)" field$/
     */
    public function iFillInIntoTheField($value, $element)
    {
        $this->getTest()->fillin($element, $value);
    }

    /**
     * @Then /^the url should match "([^"]*)"$/
     */
    public function theUrlShouldMatch($url)
    {
        $this->getTest()->isUrlTheSame($url);
    }

    /**
     * @Given /^I should see the gallery "([^"]*)"$/
     */
    public function iShouldSeeTheGallery($name)
    {
        $this->getTest('Gallery')->seeGalleryVisible($name);
    }

    /**
     * @When /^I open the gallery creation form$/
     */
    public function iOpenTheGalleryCreationForm()
    {
        $this->getTest('Gallery')->openGalleryForm();
    }

    /**
     * @Given /^I create the gallery$/
     */
    public function iCreateTheGallery()
    {
        $this->getTest('Gallery')->createGallery();
    }

    /**
     * @Given /^I try to create the gallery$/
     */
    public function iTryToCreateTheGallery()
    {
        $this->getTest('Gallery')->tryCreateGallery();
    }

    /**
     * @When /^I open the "([^"]*)" gallery with name "([^"]*)"$/
     */
    public function iOpenTheGallery($label, $name)
    {
        $this->getTest('Gallery')->openGallery($label, $name);
    }

    /**
     * @Given /^I open the gallery update form$/
     */
    public function iOpenTheGalleryUpdateForm()
    {
        $this->getTest('Gallery')->openGalleryUpdateForm();
    }

    /**
     * @Given /^I update the gallery$/
     */
    public function iUpdateTheGallery()
    {
        $this->getTest('Gallery')->updateGallery();
    }

    /**
     * @Given /^I delete the gallery$/
     */
    public function iDeleteTheGallery()
    {
        $this->getTest('Gallery')->deleteGallery();
    }

    /**
     * @Given /^I should not see the gallery "([^"]*)"$/
     */
    public function iShouldNotSeeTheGallery($name)
    {
        $this->getTest('Gallery')->seeGalleryNotVisible($name);
    }


}
