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

}
