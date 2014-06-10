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
     * @Then /^I shoud see an error on the help block of "([^"]*)"$/
     */
    public function iShoudSeeAnErrorOnTheHelpBlockOf($fields)
    {
        $fields = str_replace(' ', '', $fields);
        foreach (mb_split(',', $fields) as $field)
            $this->getTest()->seeErrorOnHelpBlockOf($field);
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


    /**
     * @Given /^I am logged in as site moderator$/
     */
    public function iAmLoggedInAsSiteModerator()
    {
        $this->getTest('Site')->logInAs('bob123', 'Boddo123');
    }

    /**
     * @Given /^I am visiting the createpage page$/
     */
    public function iAmVisitingTheCreatepagePage()
    {
        //$this->getTest('Site')->visitCreatePage();
	$this->getTest('Site')->visitCreatePage();
    }

    /**
     * @Given /^I set the page title to "([^"]*)"$/
     */
    public function iSetThePageTitleTo($title)
    {
       $this->getTest('Site')->setPageTitleTo($title);
    }

    /**
     * @Given /^I create the page$/
     */
    public function iCreateThePage()
    {
        $this->getTest('Site')->createPage();
    }

    /**
     * @Given /^I try to create the page$/
     */
    public function iTryToCreateThePage()
    {
        $this->getTest('Site')->tryCreatePage();
    }


    /**
     * @Given /^I visit the "([^"]*)" page$/
     */
    public function iVisitThePage($label)
    {
	$this->getTest('Site')->visitPage($label);
    }

    /**
     * @Then /^I should see the text "([^"]*)"$/
     */
    public function iShouldSeeTheText($text)
    {
        $this->getTest()->seeTextPresent($text);
    }

    /**
     * @When /^I am visiting the editpage page of "([^"]*)"$/
     */
    public function iAmVisitingTheEditpagePageOf($label)
    {
        $this->getTest('Site')->visitEditPage($label);
    }

    /**
     * @Given /^I open the site update form$/
     */
    public function iOpenTheSiteUpdateForm()
    {
        $this->getTest('Site')->openUpdateForm();
    }

    /**
     * @Given /^I update the site$/
     */
    public function iUpdateTheSite()
    {
        $this->getTest('Site')->updateSite();
    }

    /**
     * @Then /^I should be on the editpage page of "([^"]*)"$/
     */
    public function iShouldBeOnTheEditpagePageOf($label)
    {
        $this->getTest('Site')->isUserOnEditPageOf($label);
    }

    /**
     * @Given /^I delete the site$/
     */
    public function iDeleteTheSite()
    {
        $this->getTest('Site')->deletePage();
    }

    /**
     * @Given /^I should not see the text "([^"]*)"$/
     */
    public function iShouldNotSeeTheText($text)
    {
        $this->getTest()->seeTextNotPresent($text);
    }



}
