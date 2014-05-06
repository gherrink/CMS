<?php

use Behat\Behat\Context\ContextInterface,
    Behat\Behat\Context\ClosuredContextInterface,
	Behat\Behat\Context\TranslatedContextInterface,
	Behat\Behat\Context\BehatContext,
	Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
	Behat\Gherkin\Node\TableNode;
use Behat\YiiExtension\Context\Initializer\YiiAwareInitializer;

/**
 * Features context.
 */
// class FeatureContext extends YiiAwareInitializer implements ContextInterface
class FeatureContext implements ContextInterface
{
	private $browser = array(
					'name'    => 'Firefox on Linux',
					'browser' => '*firefox',
					'host'    => 'localhost',
					'port'    => 4444,
					'timeout' => 30000,
				);
	
	private $contact = null;
	
	private function getContact()
	{
		if($this->contact === null)
		{
			Yii::import('application.tests.functional.*');
			Yii::import('application.tests.*');
			$this->contact = new ContactTest('Test', array(), 'Array', $this->browser);
			$this->contact->config4Behat();
		}
		
		return $this->contact;
	}
	
	/**
	 * @When /^I do something$/
	 */
	public function iDoSomething()
	{
		$this->getContact()->testBala();
		$this->getContact()->testTest();
	}
	
	/**
	 * @Then /^I should see something$/
	 */
	public function iShouldSeeSomething()
	{
		throw new PendingException();
	}
	
}
