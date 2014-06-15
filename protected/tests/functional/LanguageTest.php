<?php

class LanguageTest extends WebTestCase
{
	public $modelName = 'Language';


	/**
	 * @dataProvider providerTestLanguage
	 * @param string $current
	 * @param string $new
	 */    
	public function testLanguage($current, $new)
	{
		$this->visitIndex();
		$this->checkCurrentLanguage($current);
		$this->isGermanHomepageDescriptionVisible();
		$this->selectLanguage($new);
		$this->isEnglishHomepageDescriptionVisible();
	}

	public function visitIndex()
	{
		$this->visit('', 'Willkommen');
	}

	public function checkCurrentLanguage($lang)
	{
		$this->seeTextPresent($lang);
	}

	public function isGermanHomepageDescriptionVisible()
	{
		$this->seeTextPresent($this->getMessage(MSG::PAGE_HOME));
	}

	public function selectLanguage($lang)
	{
		$this->clickAndWait("link=".$lang);
	}

	public function isEnglishHomepageDescriptionVisible()
	{	
		$this->seeTextPresent('CollectMySociety is a simple Content Management System, optimized for social organizations.');
	}

	public function providerTestLanguage()
    	{
        	return array(
           	 array('Deutsch', 'English'),
        	);
    	}

}	
