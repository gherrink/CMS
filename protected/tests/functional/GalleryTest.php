<?php

/**
 * Description of LoginTest
 *
 * @author maurice
 */
class GalleryTest extends WebTestCase
{

    public $modelName = 'Gallery';

    /**
     * @dataProvider providerShowGallery
     * @param string $user
     * @param string $password
     * @param string $galleryname
     */    
    public function testShowGallery($name, $password, $galleryname)
    {
        $this->logInAs($name, $password);
        $this->visitGallery();
        $this->seeGalleryVisible($galleryname);
    }

    /**
     * @dataProvider providerCreateGallerySuccessful
     * @param string $user
     * @param string $password
     * @param string $label
     * @param string $access
     * @param string $title
     */    
    public function testCreateGallerySuccessful($user, $password, $label, $access, $title)
    {
        $this->logInAs($user, $password);
        $this->visitGallery();
	$this->openGalleryForm();
	$this->fillinForm('label', $label);
	$this->fillinForm('roleaccess', $access);
	$this->fillin('GalleryLanguage[0][head]', $title);
	$this->createGallery();
	$this->isUrlTheSame('gallery/edit');
	$this->seeGalleryVisible($label);
    }

    /**
     * @dataProvider providerUpdateGallery
     * @param string $user
     * @param string $password
     * @param string $label
     * @param string $namebefore
     * @param string $value
     * @param string $field
     * @param string $nameafter
     */  
    public function testUpdateGallery($user, $password, $label, $namebefore, $value, $field, $nameafter)
    {
        $this->logInAs($user, $password);
        $this->visitGallery();
        $this->openGallery($label, $namebefore);
	$this->openGalleryUpdateForm();
	$this->fillin($field, $value);
	$this->updateGallery();
	$this->visitGallery();
	$this->seeGalleryVisible($nameafter);
    }

    /**
     * @dataProvider providerDeleteGallery
     * @param string $user
     * @param string $password
     * @param string $label
     * @param string $name
     */    
    public function testDeleteGallery($user, $password, $label, $name)
    {
        $this->logInAs($name, $password);
        $this->visitGallery();
        $this->openGallery($label, $name);
	$this->deleteGallery();
	$this->isUrlTheSame('gallery');
	$this->seeGalleryNotVisible($name);
    }

    /**
     * Visit the gallery page
     */
    public function visitGallery()
    {
        $this->visitTag('gallery', array(
            'tag' => 'li',
            'content' => $this->getMessage(MSG::MP_GALLERY)
        ));
    }

    /**
     * tests if the given gallery is visible
     */
    public function seeGalleryVisible($name)
    {
	$this->assertTextPresent($name);
    }

    /**
     * opens the gallery creation form
     */
    public function openGalleryForm()
    {
	$this->click("name=yt0");
	$this->waitForTextPresent("Label");
    }

    /**
     * clicks the button "create"
     */
    public function createGallery()
    {
	$this->clickAndWait("name=yt1");	
    }

    /**
     * clicks the button "create" in expection of a failure
     */
    public function tryCreateGallery()
    {
        $this->click("name=yt1");	
    }

    /**
     * opens gallery with name $name
     */
    public function openGallery($label, $name)
    {
        $this->click("//a[contains(@href,'$label')]");
	$this->waitForTextPresent("Galerie: $name");	
    }

    /**
     * opens the gallery update form
     */
    public function openGalleryUpdateForm()
    {
        $this->click("name=yt0");
	$this->waitForTextPresent($this->getMessage(MSG::HEAD_GALLERY_UPDATE));	
    }

    /**
     * clicks the button update in the gallery update form
     */
    public function updateGallery()
    {
        $this->clickAndWait("//div[@class='modal-footer']//button[contains(., '".$this->getMessage(MSG::BTN_UPDATE)."')]");	
    }

    /**
     * clicks the "delete" gallery 
     */
    public function deleteGallery()
    {
        $this->click("//button[contains(., '".$this->getMessage(MSG::BTN_DELETE)."')]");
	$this->waitForTextPresent($this->getMessage(MSG::QUESTION_DELETE_GALLERY));
	$this->clickAndWait("//button[contains(., '".$this->getMessage(MSG::BTN_YES)."')]");	
    }

    /**
     * asserts that the given gallery is not visible
     */
    public function seeGalleryNotVisible($name)
    {
       $this->assertTextNotPresent($name);
    }

    public function providerShowGallery()
    {
        return array(
            array('bob123', 'Boddo123', 'Erste Galerie'),
        );
    }

    public function providerCreateGallerySuccessful()
    {
        return array(
            array('bob123', 'Boddo123', 'TestGallery', 'VISITOR', 'TestGallery'),
        );
    }

    public function providerUpdateGallery()
    {
        return array(
            array('bob123', 'Boddo123', 'ErsteGalerie', 'Erste Galerie', 'ZweiteGalerie', 'Gallery[label]', 'Erste Galerie'),
	    array('bob123', 'Boddo123', 'ZweiteGalerie', 'Erste Galerie', 'VISITOR', 'Gallery[roleaccess]', 'Erste Galerie'),
	    array('bob123', 'Boddo123', 'ZweiteGalerie', 'Erste Galerie', 'Zweite Galerie', 'GalleryLanguage[0][head]', 'Zweite Galerie'),
        );
    }

    public function providerDeleteGallery()
    {
        return array(
            array('bob123', 'Boddo123', 'LoeschGalerie', 'LoeschGalerie'),
        );
    }

}
