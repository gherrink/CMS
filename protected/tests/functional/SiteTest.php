<?php

class SiteTest extends WebTestCase
{
	public $modelName = 'Site';


    /**
     * @dataProvider providerReadPage
     * @param string $user
     * @param string $password
     * @param string $pagelabel
     * @param string $pagetitle
     */    
    	public function testReadPage($name, $password, $pagelabel, $pagetitle)
    	{
       	 	$this->logInAs($name, $password);
        	$this->visitPage($pagelabel);
        	$this->seeTextPresent($pagetitle);
    	}

    /**
     * @dataProvider providerCreatePageSuccessful
     * @param string $user
     * @param string $password
     * @param string $label
     * @param string $access
     * @param string $layout
     * @param string $title
     */    
    public function testCreatePageSuccessful($user, $password, $label, $access, $layout, $title)
    {
        $this->logInAs($user, $password);
        $this->visitCreatePage();
	$this->fillinForm('label', $label);
	$this->fillinForm('roleaccess', $access);
	$this->fillinForm('layout', $layout);
	$this->setPageTitleTo($title);
	$this->createPage();
	$this->isUrlTheSame('site/edit');
    }

    /**
     * @dataProvider providerUpdatePage
     * @param string $user
     * @param string $password
     * @param string $labelbefore
     * @param string $value
     * @param string $field
     * @param string $labelafter
     * @param string $title
     */  
    public function testUpdatePage($user, $password, $labelbefore, $value, $field, $labelafter, $title)
    {
        $this->logInAs($user, $password);
        $this->visitEditPage($labelbefore);
        $this->openUpdateForm();
	$this->fillin($field, $value);
	$this->updateSite();
	$this->isUserOnEditPageOf($labelafter);
	$this->seeTextPresent($title);
    }

    /**
     * @dataProvider providerDeleteSite
     * @param string $user
     * @param string $password
     * @param string $label
     * @param string $title
     */    
    public function testDeleteSite($user, $password, $label, $title)
    {
        $this->logInAs($user, $password);
        $this->visitEditPage($label);
	$this->deletePage();
	$this->isUrlTheSame('site');
	$this->$this->seeTextNotPresent($title);
    }

	public function testIndex()
	{
		$this->visit('', 'Welcome');
	}

	public function visitCreatePage()
	{
		$this->click("link=".$this->getMessage(MSG::MP_MODERATOR_SITECREATE));
		$this->waitForTextPresent($this->getMessage(MSG::MODEL_LABEL));
	}

	public function setPageTitleTo($title)
	{
		$this->click("//button[contains(., '".$this->getMessage(MSG::BTN_SITE_ADDLANGUAGE)."')]");	
		$this->waitForElementPresent('SiteLanguage[1][head]');
	 	$this->fillin('SiteLanguage[1][head]', $title);
	}

	public function createPage()
	{
		$this->clickAndWait("//button[contains(., '".$this->getMessage(MSG::BTN_CREATE)."')]");
	}

        public function tryCreatePage()
	{
		$this->click("//button[contains(., '".$this->getMessage(MSG::BTN_CREATE)."')]");
	}
	
	public function visitPage($label)
	{
		$text = '';
		if ($label == 'ErsteSeite'){
			$text = 'Erste Seite';
		}
		$this->visit('site/read/'.$label.'.html', $text);
	}
	
	public function visitEditPage($label)
	{
		$text = '';
		if ($label == 'ErsteSeite'){
			$text = 'Erste Seite';
		} else if ($label == 'LoeschSeite'){
			$text = 'LoeschSeite';
		}
		$this->visit('site/edit/'.$label.'.html', $text);
	}

	public function openUpdateForm()
	{
		$this->click("//button[contains(., '".$this->getMessage(MSG::BTN_UPDATE)."')]");
		$this->waitForTextPresent($this->getMessage(MSG::HEAD_SITE_UPDATE));
	}

	public function updateSite()
	{
		$this->clickAndWait("//div[@class='modal-footer']//button[contains(., '".$this->getMessage(MSG::BTN_UPDATE)."')]");	
	}

	public function isUserOnEditPageOf($label)
	{
		 $this->isUrlTheSame('site/edit/'.$label.'.html');
	}

	public function deletePage()
	{
		$this->click("//button[contains(., '".$this->getMessage(MSG::BTN_DELETE)."')]");
		$this->waitForTextPresent($this->getMessage(MSG::QUESTION_DELETE_SITE));
		$this->clickAndWait("//button[contains(., '".$this->getMessage(MSG::BTN_YES)."')]");	
	}

	public function providerReadPage()
    	{
        	return array(
           	 array('bob123', 'Boddo123', 'ErsteSeite', 'Erste Seite'),
        	);
    	}

    	public function providerCreatePageSuccessful()
    	{
        	return array(
           	 array('bob123', 'Boddo123', 'testpage', 'VISITOR', 'COL01', ''),
		array('bob123', 'Boddo123', 'testpagezwei', 'VISITOR', 'COL01', 'Testseite Zwei'),
        	);
    	}

    	public function providerUpdatePage()
    	{
		return array(
		    array('bob123', 'Boddo123', 'ErsteSeite', 'ZweiteSeite', 'Site[label] ', 'ZweiteSeite', 'Erste Seite'),
		    array('bob123', 'Boddo123', 'ZweiteSeite', 'VISITOR', 'Site[roleaccess]', 'ZweiteSeite', 'Erste Seite'),
		    array('bob123', 'Boddo123', 'ZweiteSeite', 'Zweite Seite', 'SiteLanguage[0][head]', 'ZweiteSeite', 'Zweite Seite'),
		);
    	}

	public function providerDeleteSite()
    	{
        	return array(
           	 array('bob123', 'Boddo123', 'LoeschSeite', 'LoeschSeite'),
        	);
    	}

}
