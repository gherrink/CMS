<?php

use Behat\Behat\Context\ClosuredContextInterface,
	Behat\Behat\Context\TranslatedContextInterface,
	Behat\Behat\Context\BehatContext,
	Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
	Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;

require_once 'protected/components/MSG.php';

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @When /^login "([^"]*)" with "([^"]*)"$/
     */
    public function loginWith($usr, $pw)
    {
     	$this->getSession()->visit('http://localhost/CMS/index.php/login/login');
    	
     	$page = $this->getSession()->getPage();
    	$page->fillField('Usr_usrname', $usr);
    	$page->fillField('Usr_password', $usr);
     	$page->findButton(MSG::get('de')->getMessage(MSG::BTN_OK))->click();
    	
    	//throw new PendingException();
    	return true;
    }
    
    /**
     * @Then /^you soud see error Message "([^"]*)"$/
     */
    public function youSoudSeeErrorMessage($msg)
    {
    	$page = $this->getSession()->getPage();
//     	echo $page->getHtml();
    	$message = $page->find('css', 'alert-danger');
    	echo $message;
    	return false;
    }
    
    /**
     * @Then /^you soud be loged in$/
     */
    public function youSoudBeLoggedIn()
    {
    	throw new PendingException();
    }
    
    /**
     * @Then /^you soud see success Message "([^"]*)"$/
     */
    public function youSoudSeeSuccessMessage($msg)
    {
    	throw new PendingException();
    }
    
    /**
     * @Given /^logout$/
     */
    public function logout()
    {
    	throw new PendingException();
    }
    
    /**
     * @Then /^you soud be loged out$/
     */
    public function youSoudBeLogedOut()
    {
    	throw new PendingException();
    }
	
	/**
	 * @Then /^I wait for the suggestion box to appear$/
	 */
	public function iWaitForTheSuggestionBoxToAppear()
	{
		$this->getSession()->wait(5000,
				"$('.suggestions-results').children().length > 0"
		);
	}
	
}
