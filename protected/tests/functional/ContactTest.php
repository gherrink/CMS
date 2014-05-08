<?php

class ContactTest extends WebTestCase
{
	
	public function testBala()
	{	
		$this->open('');
		$this->assertTextPresent('Welcome to');
	}
	
// 	public function testTest()
// 	{
// 		$this->assertTextPresent('Welcome to');
// 	}

	public function testContact()
	{
		$this->visit('/contact', $see)
		$this->open('/contact');
		// 		$this->assertTextPresent('Contact Us');
		// 		$this->assertElementPresent('name=ContactForm[name]');
		
		// 		$this->type('name=ContactForm[name]','tester');
		// 		$this->type('name=ContactForm[email]','tester@example.com');
		// 		$this->type('name=ContactForm[subject]','test subject');
		// 		$this->click("//input[@value='Submit']");
		// 		$this->waitForTextPresent('Body cannot be blank.');
	}
	
	
	
}