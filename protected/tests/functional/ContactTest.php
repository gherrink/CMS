<?php

class ContactTest extends WebTestCase
{

    public $modelName = 'ContactForm';

    /**
     * Test the contentForm
     * @dataProvider providerContact
     * @param type $name
     * @param type $mail
     * @param type $subject
     * @param type $body
     * @param type $errors
     */
    public function testContact($name, $mail, $subject, $body, $errors = null)
    {
        $this->visitContact();
        $this->fillinForm('name', $name);
        $this->fillinForm('mail', $mail);
        $this->fillinForm('subject', $subject);
        $this->fillinForm('body', $body);

        $this->submitForm();

        if (isset($errors))
            foreach ($errors as $error)
                $this->seeErrorOn($error);
        else
            $this->seeSuccess();
    }

    /**
     * Visit the ContactForm
     */
    public function visitContact()
    {
        $this->visitTag('contact', array(
            'tag' => 'h1',
            'content' => $this->getMessage(MSG::HEAD_CONTACT)
        ));
    }

    public function submitForm()
    {
        $this->clickAndWait("//button[@type='submit']");
    }

    public function seeSuccess()
    {
        $this->waitForTextPresent($this->getMessage(MSG::SUCCESS_CONTACT_SENDMAIL));
    }

    public function providerContact()
    {
        return array(
            array(
                null,
                null,
                null,
                null,
                array('name', 'mail', 'subject', 'body')
            ),
            array(
                "Bob Tester",
                null,
                null,
                null,
                array('mail', 'subject', 'body')
            ),
            array(
                null,
                "test.test@test.net",
                null,
                null,
                array('name', 'subject', 'body')
            ),
            array(
                null,
                null,
                "Test Mail",
                null,
                array('name', 'mail', 'body')
            ),
            array(
                null,
                null,
                null,
                "This is a Testbody, Here 'll stay and a lot of Text.",
                array('name', 'mail', 'subject')
            ),
            array(
                "Bob tester",
                "bob@test.de",
                "This is a Test Mail",
                "Hey dear, this is a Test-Mail from bob, may you reseve it.",
                null
            ),
        );
    }

}
